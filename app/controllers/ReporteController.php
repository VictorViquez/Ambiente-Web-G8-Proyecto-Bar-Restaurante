<?php
require_once __DIR__ . '/../helpers/utils.php';

class ReporteController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        if ($_SESSION['user']['rol'] !== 'admin') {
            set_flash('danger', 'Acceso denegado.');
            redirect(base_url('/index.php?route=dashboard'));
        }

        $fecha_inicio = clean($_GET['fecha_inicio'] ?? date('Y-m-01'));
        $fecha_fin = clean($_GET['fecha_fin'] ?? date('Y-m-d'));

        $sql = "SELECT 
                    COUNT(*) AS total_pedidos,
                    IFNULL(SUM(total), 0) AS total_vendido
                FROM pedidos
                WHERE estado = 'cerrado'
                AND DATE(fecha) BETWEEN :fecha_inicio AND :fecha_fin";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);

        $resumen = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlDetalle = "SELECT 
                            p.id,
                            p.fecha,
                            p.total,
                            m.numero_mesa,
                            u.nombre AS usuario_nombre
                       FROM pedidos p
                       INNER JOIN mesas m ON m.id = p.mesa_id
                       INNER JOIN usuarios u ON u.id = p.usuario_id
                       WHERE p.estado = 'cerrado'
                       AND DATE(p.fecha) BETWEEN :fecha_inicio AND :fecha_fin
                       ORDER BY p.fecha DESC";

        $stmtDetalle = $this->conn->prepare($sqlDetalle);
        $stmtDetalle->execute([
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);

        $detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/reportes/index.php';
    }
}