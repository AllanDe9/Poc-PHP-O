<?php 

require_once 'models/User.php';
class UserController {

    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = new User(0, '', '');
            if ($user->login($username, $password) ) {
                $_SESSION['user'] = $user->getUsername();
                header('Location: /Poc-PHP-O/');
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }
        require 'views/LoginView.php';
    }

    public function logout() {
        session_destroy();
        header('Location: login');
        exit();
    }

    public function register() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = new User(0, $username, $password);
            $errors = [];

            if (!$user->checkDisponibility()) {
                $errors[] = "Nom d'utilisateur déjà pris.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
            }
            if (
                !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[a-z]/', $password) ||
                !preg_match('/[0-9]/', $password) ||
                !preg_match('/[\W_]/', $password)
            ) {
                $errors[] = "Le mot de passe n'est pas assez complexe.";
            }
            if (strpos($password, $username) !== false) {
                $errors[] = "Le mot de passe ne doit pas contenir le nom d'utilisateur.";
            }

            if (empty($errors)) {
                $user->register($username, $password);
                $_SESSION['message'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: login');
                exit();
            }
        }
        require 'views/RegisterView.php';
    }
}