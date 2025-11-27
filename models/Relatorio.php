<?php
require_once __DIR__ . '/../core/database.php';

class Relatorio {
    private $db;

    public function __construct() {
        $this->db = Database::conn();
    }

    public function buscarRespostas($categoria = '') {
        $where = [];
        $params = [];

        if ($categoria !== '') {
            $where[] = "c.nome = ?";
            $params[] = $categoria;
        }

        $sqlWhere = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT 
                p.texto AS pergunta,
                r.resposta,
                COUNT(*) AS total
            FROM respostas r
            JOIN perguntas p ON p.id = r.pergunta_id
            JOIN categorias c ON c.id = p.categoria_id
            $sqlWhere
            GROUP BY p.texto, r.resposta
            ORDER BY c.nome, p.texto
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados = [];
        foreach ($result as $linha) {

            $pergunta = $linha['pergunta'];
            $resposta = $linha['resposta'];
            $total = (int) $linha['total'];

            if (!isset($dados[$pergunta])) {
                $dados[$pergunta] = [
                    'pergunta' => $pergunta,
                    'respostas' => [
                        'Discordo Totalmente' => 0,
                        'Discordo Parcialmente' => 0,
                        'Nem Concordo Nem Discordo' => 0,
                        'Concordo Parcialmente' => 0,
                        'Concordo Totalmente' => 0
                    ]
                ];
            }

            // Atribui contagem da resposta
            $dados[$pergunta]['respostas'][$resposta] = $total;
        }

        return array_values($dados);
    }
}
