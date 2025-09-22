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
        switch ($params[2] ?? '') {
            case 'add-song':
                require 'controllers/SongController.php';
                $controller = new SongController();
                $controller->add($params[1] ?? null);
                break;
            case 'edit-song':
                require 'controllers/SongController.php';
                $controller = new SongController();
                $controller->edit($params[3] ?? null);
                break;
            default:
                require 'controllers/MediaController.php';
                $controller = new MediaController();
                $controller->showMedia($params[1] ?? null);
                break;
        }
        break;
    case 'add':
        switch ($params[1] ?? '') {
            case 'book':
                require 'controllers/BookController.php';
                $controller = new BookController();
                $controller->add();
                break;
            case 'album':
                require 'controllers/AlbumController.php';
                $controller = new AlbumController();
                $controller->add();
                break;
            case 'movie':
                require 'controllers/MovieController.php';
                $controller = new MovieController();
                $controller->add();
                break;
            default:
                http_response_code(404);
                echo "Page non trouvée";
                break;
        }
        break;
    case 'edit':
        switch ($params[1] ?? '') {
            case 'book':
                require 'controllers/BookController.php';
                $controller = new BookController();
                $controller->edit($params[2] ?? null);
                break;
            case 'album':
                require 'controllers/AlbumController.php';
                $controller = new AlbumController();
                $controller->edit($params[2] ?? null);
                break;
            case 'movie':
                require 'controllers/MovieController.php';
                $controller = new MovieController();
                $controller->edit($params[2] ?? null);
                break;
        }
        break;
    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}