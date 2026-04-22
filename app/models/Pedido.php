<?php

class Pedido {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $sql = "SELECT p.*, m.numero_mesa, u.nombre AS usuario_nombre
                FROM pedidos p
                INNER JOIN mesas m ON m.id = p.mesa_id
                INNER JOIN usuarios u ON u.id = p.usuario_id
                ORDER BY p.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos() {
        $sql = "SELECT p.*, m.numero_mesa, u.nombre AS usuario_nombre
                FROM pedidos p
                INNER JOIN mesas m ON m.id = p.mesa_id
                INNER JOIN usuarios u ON u.id = p.usuario_id
                WHERE p.estado = 'activo'
                ORDER BY p.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT p.*, m.numero_mesa, u.nombre AS usuario_nombre
                FROM pedidos p
                INNER JOIN mesas m ON m.id = p.mesa_id
                INNER JOIN usuarios u ON u.id = p.usuario_id
                WHERE p.id = :id
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($mesa_id, $usuario_id) {
        $sql = "INSERT INTO pedidos (mesa_id, usuario_id, estado, total)
                VALUES (:mesa_id, :usuario_id, 'activo', 0)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ':mesa_id' => $mesa_id,
            ':usuario_id' => $usuario_id
        ]);

        if ($ok) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function agregarDetalle($pedido_id, $producto_id, $cantidad) {
        $sqlProducto = "SELECT precio FROM productos WHERE id = :id AND estado = 'activo' LIMIT 1";
        $stmtProducto = $this->conn->prepare($sqlProducto);
        $stmtProducto->execute([':id' => $producto_id]);
        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            return false;
        }

        $precio = (float)$producto['precio'];
        $subtotal = $precio * $cantidad;

        $sql = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
                VALUES (:pedido_id, :producto_id, :cantidad, :precio_unitario, :subtotal)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ':pedido_id' => $pedido_id,
            ':producto_id' => $producto_id,
            ':cantidad' => $cantidad,
            ':precio_unitario' => $precio,
            ':subtotal' => $subtotal
        ]);

        if ($ok) {
            $this->recalcularTotal($pedido_id);
        }

        return $ok;
    }

    public function obtenerDetalles($pedido_id) {
        $sql = "SELECT d.*, p.nombre AS producto_nombre
                FROM detalle_pedido d
                INNER JOIN productos p ON p.id = d.producto_id
                WHERE d.pedido_id = :pedido_id
                ORDER BY d.id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pedido_id' => $pedido_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recalcularTotal($pedido_id) {
        $sql = "UPDATE pedidos
                SET total = (
                    SELECT IFNULL(SUM(subtotal),0)
                    FROM detalle_pedido
                    WHERE pedido_id = :pedido_id
                )
                WHERE id = :pedido_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pedido_id' => $pedido_id]);
    }

    public function cerrar($pedido_id) {
        $sql = "UPDATE pedidos SET estado = 'cerrado' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $pedido_id]);
    }
}