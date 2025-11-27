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
}
