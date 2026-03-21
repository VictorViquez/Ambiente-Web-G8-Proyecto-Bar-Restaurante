<?php
class Database {
    private $host = '127.0.0.1';
    private $port = '3306';
    private $db_name = 'proyecto_sc502';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die('Error de conexión: ' . $exception->getMessage());
        }

        return $this->conn;
    }
}