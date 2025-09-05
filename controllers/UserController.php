<?php 

class UserController {

    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user->getUsername();
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
        require 'views/RegisterView.php';
    }
}