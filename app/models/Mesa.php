<?php

class Mesa {
    private $conn;
    private $table = 'mesas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $sql = "SELECT * FROM {$this->table} ORDER BY numero_mesa ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($numero_mesa, $capacidad, $estado = 'disponible') {
        $sql = "INSERT INTO {$this->table} (numero_mesa, capacidad, estado)
                VALUES (:numero_mesa, :capacidad, :estado)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':numero_mesa' => $numero_mesa,
            ':capacidad' => $capacidad,
            ':estado' => $estado
        ]);
    }

    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE {$this->table} SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id' => $id
        ]);
    }
}