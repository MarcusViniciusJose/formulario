<?php
require_once __DIR__ . '/../models/Sugestao.php';

class SugestaoController {

    private $model;

    public function __construct() {
        $this->model = new Sugestao();
    }

    public function index() {
        $sugestoes = $this->model->listar();
        include __DIR__ . '/../views/sugestoes/index.php';
    }

    public function wordcloud() {
        $dados = $this->model->listar();

        $sugestoes = array_map(
            fn($s) =>trim($s['sugestao']),
            $dados
        );

        
        $planos = $this->model->listarPlanos();

        include __DIR__ . '/../views/sugestoes/wordcloud.php';
    }

    public function salvarPlano() {
        header('Content-Type: application/json');
        
        try {
            $json = file_get_contents('php://input');
            $dados = json_decode($json, true);

            if (!$dados) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Dados inválidos ou não enviados'
                ]);
                return;
            }

            if (empty($dados['palavra']) || empty($dados['what']) || 
                empty($dados['why']) || empty($dados['who'])) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Campos obrigatórios não preenchidos'
                ]);
                return;
            }

            $dadosCompletos = [
                'palavra' => $dados['palavra'],
                'what' => $dados['what'],
                'why' => $dados['why'],
                'where' => $dados['where'] ?? '',
                'when' => $dados['when'] ?? '',
                'who' => $dados['who'],
                'how' => $dados['how'] ?? '',
                'howMuch' => $dados['howMuch'] ?? ''
            ];

            $this->model->salvarPlano($dadosCompletos);

            echo json_encode([
                'success' => true,
                'message' => 'Plano salvo com sucesso'
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Erro: ' . $e->getMessage()
            ]);
        }
    }
}