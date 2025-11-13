<?php
require_once __DIR__ . '/../models/Sugestao.php';
require_once __DIR__ . '/../models/Setor.php';

class SugestaoController {
    private $model;
    private $setorModel;

    public function __construct() {
        $this->model = new Sugestao();
        $this->setorModel = new Setor();
    }

    public function index() {
        $setor_id = $_GET['setor_id'] ?? null;
        $sugestoes = $this->model->listar($setor_id);
        $setores = $this->setorModel->listar();
        require_once __DIR__ . '/../views/sugestoes/index.php';
    }

    public function filtrar() {
        $setor_id = $_GET['setor_id'] ?? null;
        header("Location: index.php?page=sugestoes&setor_id={$setor_id}");
        exit;
    }
}
