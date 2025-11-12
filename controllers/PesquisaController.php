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


    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respostas'])) {
            $respostas = $_POST['respostas'];
            
            $setor_id = isset($_POST['setor_id']) && is_numeric($_POST['setor_id'])
                ? (int)$_POST['setor_id']
                : null; 

            foreach ($respostas as $id_pergunta => $valor) {
                 $this->respostaModel->salvarResposta($id_pergunta, $valor, $setor_id);
            }

            include __DIR__ . '/../views/pesquisa/confirmar.php';
        } else {
            header("Location: index.php?page=pesquisa");
            exit;
        }
    }
}
