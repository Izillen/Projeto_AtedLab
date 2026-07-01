<?php

require_once __DIR__ . "/config/database.php";
require_once __DIR__ . "/app/Controllers/UsuariosController.php";
require_once __DIR__ . "/app/Controllers/PessoaController.php";
require_once __DIR__ . "/app/Controllers/TiposAtendimentosController.php";
require_once __DIR__ . "/app/Controllers/AtendimentosController.php";
require_once __DIR__ . "/app/Controllers/AuthController.php";
require_once __DIR__ . "/app/Middleware/auth.php";

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

switch ($controller) {
    case 'auth':
        $authController = new AuthController();
        break;

    case 'usuarios':
        exigirAutenticacao();
        $controllerInstance = new UsuariosController();
        break;

    case 'pessoas':
        $controllerInstance = new PessoaController();
        break;

    case 'tipos_atendimentos':
        $controllerInstance = new TiposAtendimentosController();
        break;

    case 'atendimentos':
        $controllerInstance = new AtendimentosController();
        break;

    default:
        $authController = new AuthController();
        $action = 'login';
        break;
}

switch ($action) {

    case 'listar':
        $controllerInstance->listar();
        break;

    case 'buscar':
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

    case 'login':
        $authController->exibirLogin();
        break;

    case 'entrar':
        $authController->entrar();
        break;

    case 'dashboard':
        $authController->dashboard();
        break;

    case 'logout':
        $authController->logout();
        break;
    case 'tipos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/TiposAtendimentosController.php';
        $tiposController = new TiposAtendimentosController();

        switch ($action) {
            case 'listar':
                $tiposController->listar();
                break;
            case 'buscarPorId':
                $tiposController->buscarPorId();
                break;
            case 'criar':
                $tiposController->criar();
                break;
            case 'atualizar':
                $tiposController->atualizar();
                break;
            case 'inativar':
                $tiposController->inativar();
                break;
            default:
                responderRotaNaoEncontrada('Ação de tipos de atendimento não encontrada.');
        }
        break;
    case 'atendimentos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
        $atendimentosController = new AtendimentosController();
        switch ($action) {
            case 'listar':
                $atendimentosController->listar();
                break;
            case 'visualizar':
                $atendimentosController->visualizar();
                break;
            case 'criar':
                $atendimentosController->criar();
                break;
            case 'alterarStatus':
            case 'atualizarStatus':
                $atendimentosController->atualizarStatus();
                break;
            case 'opcoesFormulario':
                $atendimentosController->opcoesFormulario();
                break;
            default:
                responderRotaNaoEncontrada(
                    'Ação de atendimentos não encontrada.'
                );
        }
        break;
        
    default:
        echo "Ação não encontrada.";
        break;
}