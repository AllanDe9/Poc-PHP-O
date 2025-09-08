<?php

session_start();
require 'connection.php';

$params = explode('/', $_GET['params'] ?? '');
if (!isset($_SESSION['user']) && !in_array($params[0], ['login', 'register'])) {
    header('Location: login');
    exit();
}

switch ($params[0]) {
    case 'login':
        require 'controllers/UserController.php';
        $controller = new UserController();
        $controller->login();
        break;
    case 'logout':
        require 'controllers/UserController.php';
        $controller = new UserController();
        $controller->logout();
        break;
    case 'register':
        require 'controllers/UserController.php';
        $controller = new UserController();
        $controller->register();
        break;
    case '':
        require 'controllers/MediaController.php';
        $controller = new MediaController();
        $controller->listMedia();
        break;
    case 'media':
        require 'controllers/MediaController.php';
        $controller = new MediaController();
        $controller->showMedia($params[1] ?? null);
        break;
    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}