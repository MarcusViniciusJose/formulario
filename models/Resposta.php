<?php
require_once __DIR__ . '/../core/Database.php';

class Resposta {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }

    public function salvarResposta($id_pergunta, $valor, $setor) {
        $stmt = $this->conn->prepare("
            INSERT INTO respostas (pergunta_id, resposta, setor_id, created_at)
            VALUES (:id_pergunta, :resposta, :setor, NOW())
        ");
        $stmt->bindParam(':id_pergunta', $id_pergunta);
        $stmt->bindParam(':resposta', $valor);
        $stmt->bindParam(':setor', $setor);
        $stmt->execute();
    }
}
