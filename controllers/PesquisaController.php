<?php
require_once __DIR__ . '/../models/Pergunta.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Resposta.php';
require_once __DIR__ . '/../models/Setor.php';

class PesquisaController {
    
    private $perguntaModel;
    private $categoriaModel;
    private $respostaModel;
    private $modelSetor;

    public function __construct() {
        $this->perguntaModel = new Pergunta();
        $this->categoriaModel = new Categoria();
        $this->respostaModel = new Resposta();
        $this->modelSetor = new Setor();
    }

  
    public function index() {
        $categorias = $this->categoriaModel->getAll();
        $perguntas_flat = $this->perguntaModel->getAll();

        $perguntas = [];
        foreach ($perguntas_flat as $p) {
            $id_cat = $p['categoria_id'];
            $perguntas[$id_cat][] = $p;
        }

        $setores = $this->modelSetor->listar();

        include __DIR__ . '/../views/pesquisa/index.php';
    }

    public function confirmar() {
        if (!isset($_POST['setor_id']) || !isset($_POST['respostas'])) {
            header('Location: ?page=pesquisa&erro=missing');
            exit;
        }

        $setor_id = $_POST['setor_id'];
        $respostas = $_POST['respostas'];

        include __DIR__ . '/../views/pesquisa/confirmar.php';
    }

    public function salvar() {
        if (!isset($_POST['setor_id']) || !isset($_POST['respostas'])) {
            header('Location: ?page=pesquisa&erro=missing');
            exit;
        }

        $setor_id = $_POST['setor_id'];
        $respostas = $_POST['respostas'];

        foreach ($respostas as $pergunta_id => $resposta) {
            $this->respostaModel->salvarResposta($pergunta_id, $resposta, $setor_id);
        }

        header('Location: ?page=pesquisa&sucesso=1');
        exit;
    }

   
    public function dadosGraficos() {
        header('Content-Type: application/json; charset=utf-8');

        $categoria = $_GET['categoria'] ?? '';
        $setor = $_GET['setor'] ?? '';

        $dados = $this->respostaModel->obterDadosFiltrados($categoria, $setor);

        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
