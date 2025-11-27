<?php
require_once __DIR__ . '/../core/Database.php';

class Sugestao {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function salvar($texto) {
        $stmt = $this->conn->prepare("
            INSERT INTO sugestoes (sugestao, created_at)
            VALUES (:sugestao, NOW())
        ");

        $stmt->bindParam(':sugestao', $texto);
        $stmt->execute();
    }

    public function listar() {
        $sql = "
            SELECT 
                s.id, 
                s.sugestao, 
                s.created_at
            FROM sugestoes s
            ORDER BY s.created_at DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
