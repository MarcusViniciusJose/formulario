<?php
require_once __DIR__ . '/../core/Database.php';

class Pergunta {
    private $conn;

    public function __construct() {
        $this->conn = Database::conn();
    }
   public function getAll() {
        $sql = "
            SELECT 
                p.id,
                p.texto,
                c.nome AS categoria_nome,
                c.id AS categoria_id
            FROM perguntas p
            INNER JOIN categorias c ON p.categoria_id = c.id
            ORDER BY c.id, p.id
        ";

        $stmt = $this->conn->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        return $dados; 
    }
}
