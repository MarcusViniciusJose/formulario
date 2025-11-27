<?php
require_once __DIR__ . '/../models/Pergunta.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Resposta.php';

class PesquisaController {
    
    private $perguntaModel;
    private $categoriaModel;
    private $respostaModel;

    public function __construct() {
        $this->perguntaModel = new Pergunta();
        $this->categoriaModel = new Categoria();
        $this->respostaModel = new Resposta();
    }

    public function index() {
        $categorias = $this->categoriaModel->getAll();
        $perguntas_flat = $this->perguntaModel->getAll();

        $perguntas = [];
        foreach ($perguntas_flat as $p) {
            $id_cat = $p['categoria_id'];
            $perguntas[$id_cat][] = $p;
        }

        include __DIR__ . '/../views/pesquisa/index.php';
    }

    public function confirmar() {
        if (!isset($_POST['respostas'])) {
            header('Location: ?page=pesquisa&erro=missing');
            exit;
        }

        $respostas = $_POST['respostas'];
        $sugestao = $_POST['sugestao'] ?? ''; 

        include __DIR__ . '/../views/pesquisa/confirmar.php';
    }

    public function salvar() {
        if (!isset($_POST['respostas'])) {
            header('Location: ?page=pesquisa&erro=missing');
            exit;
        }

        $respostas = $_POST['respostas'];
        $sugestao = trim($_POST['sugestao'] ?? '');

        foreach ($respostas as $pergunta_id => $resposta) {
            $this->respostaModel->salvarResposta($pergunta_id, $resposta);
        }

        if ($sugestao !== '') {
            require_once __DIR__ . '/../models/Sugestao.php';
            $sugModel = new Sugestao();
            $sugModel->salvar($sugestao);
        }

        header('Location: ?page=pesquisa&action=sucesso');
        exit;
    }

    public function dadosGraficos() {
        header('Content-Type: application/json; charset=utf-8');

        $categoria = $_GET['categoria'] ?? '';

        $dados = $this->respostaModel->obterDadosFiltrados($categoria);

        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
