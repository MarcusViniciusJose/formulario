<?php
require_once __DIR__ . '/../core/Database.php';

class Pergunta {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT p.*, c.nome AS categoria_nome
            FROM perguntas p
            JOIN categorias c ON p.categoria_id = c.id
            ORDER BY c.id, p.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
