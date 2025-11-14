<?php
require_once __DIR__ . '/../models/Relatorio.php';

class RHController {
    public function index() {
        require __DIR__ . '/../views/rh/dashboard.php';
    }

    public function dadosGraficos() {
        header('Content-Type: application/json');
        $categoria = $_GET['categoria'] ?? '';
        $setor = $_GET['setor'] ?? '';

        $relatorio = new Relatorio();
        $dados = $relatorio->buscarRespostas($categoria, $setor);

        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }

    public function insatisfeitas() {
    require_once 'models/Relatorio.php';
    $pesquisa = new Relatorio();
    
    $dados = $pesquisa->buscarRespostas();

    $resultados = [];

    foreach ($dados as $item) {
        $respostas = $item['respostas'];
        $total = array_sum($respostas);

        if ($total > 0) {
            $insatisfacao = (
                ($respostas['Discordo Totalmente'] ?? 0) +
                ($respostas['Discordo Parcialmente'] ?? 0)
            );

            $pct = ($insatisfacao / $total) * 100;

            if ($pct > 35) {
                $resultados[] = [
                    'pergunta' => $item['pergunta'],
                    'insatisfacao' => round($pct, 1),
                    'total' => $total
                ];
            }
        }
    }

    include __DIR__ . '/../views/rh/insatisfacao.php';
}


    
}
