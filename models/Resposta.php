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

    public function obterDadosFiltrados($categoria = '', $setor = '') {
    $query = "
        SELECT 
            p.id AS pergunta_id,
            p.texto AS pergunta,
            r.resposta
        FROM respostas r
        INNER JOIN perguntas p ON p.id = r.pergunta_id
        INNER JOIN categorias c ON c.id = p.categoria_id
        INNER JOIN setores s ON s.id = r.setor_id
        WHERE 1=1
    ";

    $params = [];

    if (!empty($categoria)) {
        $query .= " AND c.nome = :categoria";
        $params[':categoria'] = $categoria;
    }

    if (!empty($setor)) {
        $query .= " AND s.nome = :setor";
        $params[':setor'] = $setor;
    }

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $resultado = [];
    foreach ($dados as $linha) {
        $pergunta = $linha['pergunta'];
        $resposta = $linha['resposta'];

        if (!isset($resultado[$pergunta])) {
            $resultado[$pergunta] = [
                'pergunta' => $pergunta,
                'respostas' => []
            ];
        }

        if (!isset($resultado[$pergunta]['respostas'][$resposta])) {
            $resultado[$pergunta]['respostas'][$resposta] = 0;
        }

        $resultado[$pergunta]['respostas'][$resposta]++;
    }

    return array_values($resultado); 
}

}
