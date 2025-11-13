<?php
require_once __DIR__ . '/../core/Database.php';

class Sugestao {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function salvar($setor_id, $texto) {
        $stmt = $this->conn->prepare("
            INSERT INTO sugestoes (setor_id, sugestao)
            VALUES (:setor, :sugestao)
        ");
        $stmt->bindParam(':setor', $setor_id);
        $stmt->bindParam(':sugestao', $texto);
        $stmt->execute();
    }

    public function listar() {
        $sql = "SELECT s.id, set.nome AS setor, s.sugestao, s.created_at 
                FROM sugestoes s
                INNER JOIN setores set ON set.id = s.setor_id
                ORDER BY s.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
