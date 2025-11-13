<?php
require_once __DIR__ . '/../core/Database.php';

class Sugestao {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function salvar($setor_id, $texto) {
        $stmt = $this->conn->prepare("
            INSERT INTO sugestoes (setor_id, sugestao, created_at)
            VALUES (:setor, :sugestao, NOW())
        ");
        $stmt->bindParam(':setor', $setor_id);
        $stmt->bindParam(':sugestao', $texto);
        $stmt->execute();
    }

    public function listar($setor_id = null) {
        $sql = "
            SELECT s.id, st.nome AS setor, s.sugestao, s.created_at
            FROM sugestoes s
            INNER JOIN setores st ON st.id = s.setor_id
        ";

        if ($setor_id) {
            $sql .= " WHERE s.setor_id = :setor_id";
        }

        $sql .= " ORDER BY s.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        if ($setor_id) {
            $stmt->bindParam(':setor_id', $setor_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
