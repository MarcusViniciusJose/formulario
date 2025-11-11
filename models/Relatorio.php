<?php
require_once __DIR__ . '/../core/database.php';

class Relatorio {
    private $db;

    public function __construct() {
        $this->db = Database::conn();
    }

    public function buscarRespostas($categoria = '', $setor = '') {
        $where = [];
        $params = [];

        if ($categoria !== '') {
            $where[] = "p.categoria = ?";
            $params[] = $categoria;
        }

        if ($setor !== '') {
            $where[] = "s.setor = ?";
            $params[] = $setor;
        }

        $sqlWhere = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT p.texto AS pergunta, r.resposta, COUNT(*) AS total
            FROM respostas r
            JOIN perguntas p ON p.codigo = r.pergunta_codigo
            JOIN submissions s ON s.id = r.submission_id
            $sqlWhere
            GROUP BY p.texto, r.resposta
            ORDER BY p.categoria, p.texto
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organizar resultados para o gráfico
        $dados = [];
        foreach ($result as $linha) {
            $pergunta = $linha['pergunta'];
            $resposta = $linha['resposta'];
            $total = (int)$linha['total'];

            if (!isset($dados[$pergunta])) {
                $dados[$pergunta] = [
                    'pergunta' => $pergunta,
                    'respostas' => [
                        'Discordo totalmente' => 0,
                        'Discordo parcialmente' => 0,
                        'Nem concordo nem discordo' => 0,
                        'Concordo parcialmente' => 0,
                        'Concordo totalmente' => 0
                    ]
                ];
            }

            $dados[$pergunta]['respostas'][$resposta] = $total;
        }

        return array_values($dados);
    }
}
