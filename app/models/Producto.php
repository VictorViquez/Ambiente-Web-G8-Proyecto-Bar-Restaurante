<?php

class Producto {
    private $conn;
    private $table = 'productos';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listar() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos() {
        $sql = "SELECT * FROM {$this->table} WHERE estado = 'activo' ORDER BY nombre ASC";
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

    public function crear($nombre, $descripcion, $precio, $estado = 'activo') {
        $sql = "INSERT INTO {$this->table} (nombre, descripcion, precio, estado)
                VALUES (:nombre, :descripcion, :precio, :estado)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':estado' => $estado
        ]);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $estado) {
        $sql = "UPDATE {$this->table}
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    estado = :estado
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':estado' => $estado,
            ':id' => $id
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