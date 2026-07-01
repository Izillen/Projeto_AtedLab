<?php

require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/app/Controllers/AuthController.php";
require_once __DIR__ . "/app/Controllers/UsuariosController.php";
require_once __DIR__ . "/app/Controllers/PessoaController.php";
require_once __DIR__ . "/app/Controllers/TiposAtendimentosController.php";
require_once __DIR__ . "/app/Controllers/AtendimentosController.php";
require_once __DIR__ . "/app/Middleware/auth.php";

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

$controllerInstance = null;
$authController = null;
switch ($controller) {

    case 'auth':
        $authController = new AuthController();
        break;

    case 'usuarios':
        exigirAutenticacao();
        $controllerInstance = new UsuariosController();
        break;

    case 'pessoas':
        exigirAutenticacao();
        $controllerInstance = new PessoaController();
        break;

    case 'tipos_atendimentos':
        exigirAutenticacao();
        $controllerInstance = new TiposAtendimentosController();
        break;

    case 'atendimentos':
        exigirAutenticacao();
        $controllerInstance = new AtendimentosController();
        break;

    default:
        echo "Controller não encontrado.";
        exit;
}

switch ($action) {
    case 'listar':
        $controllerInstance->listar();
        break;

    case 'buscar':
    case 'buscarPorId':
        $controllerInstance->buscarPorId();
        break;

    case 'criar':
        $controllerInstance->criar();
        break;

    case 'atualizar':
        $controllerInstance->atualizar();
        break;

    case 'excluir':
        $controllerInstance->excluir();
        break;

        case 'inativar':
        $controllerInstance->inativar();
        break;

    case 'visualizar':
        $controllerInstance->visualizar();
        break;

    case 'opcoesFormulario':
        $controllerInstance->opcoesFormulario();
        break;

    case 'alterarStatus':
    case 'atualizarStatus':
        $controllerInstance->atualizarStatus();
        break;
    case 'login':
        $authController->exibirLogin();
        break;

    case 'entrar':
        $authController->entrar();
        break;

    case 'dashboard':
        exigirAutenticacao();
        $authController->dashboard();
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        echo "Ação não encontrada.";
        break;
}