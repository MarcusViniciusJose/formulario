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
}
