<?php
require_once __DIR__ . '/../core/Database.php';

class Categoria {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM categorias ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
