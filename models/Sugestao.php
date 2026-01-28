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

    public function salvarPlano($dados) {
        try {
            $sql = "
                INSERT INTO planos_acao
                (palavra, `what`, `why`, `where`, `when`, who, how, how_much, created_at)
                VALUES
                (:palavra, :what, :why, :where, :when, :who, :how, :how_much, NOW())
            ";

            $stmt = $this->conn->prepare($sql);
            
            return $stmt->execute([
                ':palavra'   => $dados['palavra'],
                ':what'      => $dados['what'],
                ':why'       => $dados['why'],
                ':where'     => $dados['where'] ?? '',
                ':when'      => !empty($dados['when']) ? $dados['when'] : null,
                ':who'       => $dados['who'],
                ':how'       => $dados['how'] ?? '',
                ':how_much'  => $dados['howMuch'] ?? ''
            ]);
            
        } catch (PDOException $e) {
            error_log("Erro ao salvar plano: " . $e->getMessage());
            throw new Exception("Erro ao salvar plano de ação");
        }
    }

    public function listarPlanos(){
        $stmt = $this->conn->query("SELECT palavra, `what`, `why`, `where`, `when`, who, how, how_much, created_at FROM planos_acao");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}