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
                (palavra, `what`, `why`, `where`, when_date, who, how, how_much, created_at)
                VALUES
                (:palavra, :what, :why, :where, :when_date, :who, :how, :how_much, NOW())
            ";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':palavra'    => $dados['palavra'],
                ':what'       => $dados['what'],
                ':why'        => $dados['why'],
                ':where'      => $dados['where'] ?? '',
                ':when_date' => !empty($dados['when_date']) ? $dados['when_date'] : null,
                ':who'        => $dados['who'],
                ':how'        => $dados['how'] ?? '',
                ':how_much'   => $dados['howMuch'] ?? ''
            ]);

        } catch (PDOException $e) {
            error_log("Erro ao salvar plano: " . $e->getMessage());
            throw new Exception("Erro ao salvar plano de ação");
        }
    }


    public function listarPlanos(){
    $stmt = $this->conn->prepare("
        SELECT 
            palavra, 
            `what`, 
            `why`, 
            `where`, 
            when_date, 
            who, 
            how, 
            how_much, 
            created_at 
        FROM planos_acao
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function atualizarPlano($dados) {
    try {
        $sql = "
            UPDATE planos_acao SET
                `what` = :what,
                `why` = :why,
                `where` = :where,
                when_date = :when_date,
                who = :who,
                how = :how,
                how_much = :how_much
            WHERE palavra = :palavra
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':palavra'   => $dados['palavra'],
            ':what'      => $dados['what'],
            ':why'       => $dados['why'],
            ':where'     => $dados['where'] ?? '',
            ':when_date' => !empty($dados['when_date']) ? $dados['when_date'] : null,
            ':who'       => $dados['who'],
            ':how'       => $dados['how'] ?? '',
            ':how_much'  => $dados['howMuch'] ?? ''
        ]);

    } catch (PDOException $e) {
        error_log("Erro ao atualizar plano: " . $e->getMessage());
        throw new Exception("Erro ao atualizar plano");
    }
}

public function excluirPlano($palavra) {
    try {
        $stmt = $this->conn->prepare("
            DELETE FROM planos_acao WHERE palavra = :palavra
        ");
        return $stmt->execute([':palavra' => $palavra]);

    } catch (PDOException $e) {
        error_log("Erro ao excluir plano: " . $e->getMessage());
        throw new Exception("Erro ao excluir plano");
    }
}


}