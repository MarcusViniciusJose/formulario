<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$page = $_GET['page'] ?? 'pesquisa'; 
$action = $_GET['action'] ?? 'index';

switch ($page) {

    case 'pesquisa':
        require_once 'controllers/PesquisaController.php';
        $controller = new PesquisaController();

        if ($action === 'salvar') {
            $controller->salvar();
        } else {
            $controller->index();
        }
        break;

    case 'rh':
        require_once 'controllers/RHController.php';
        $controller = new RHController();

        if ($action === 'dadosGraficos') {
            $controller->dadosGraficos();
        } else {
            $controller->index();
        }
        break;

    case 'salvar':
        require_once 'controllers/PesquisaController.php';
        $controller = new PesquisaController();
        $controller->salvar();
        break;

    default:
        http_response_code(404);
        echo "<h2 style='text-align:center;margin-top:50px;'>Página não encontrada</h2>";
        break;
}
