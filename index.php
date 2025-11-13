<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$page = $_GET['page'] ?? 'pesquisa'; 
$action = $_GET['action'] ?? 'index';

switch ($page) {

    case 'pesquisa':
        require_once 'controllers/PesquisaController.php';
        $controller = new PesquisaController();

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'confirmar':
                $controller->confirmar();
                break;
            case 'salvar':
                $controller->salvar();
                break;
            case 'dadosGraficos':
                $controller->dadosGraficos();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'rh':
        require_once 'controllers/RHController.php';
        $controller = new RHController();

        switch ($action) {
            case 'dadosGraficos':
                $controller->dadosGraficos();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    default:
        http_response_code(404);
        echo "<h2 style='text-align:center;margin-top:50px;'>Página não encontrada</h2>";
        break;
}
