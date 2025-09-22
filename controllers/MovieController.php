<?php

require_once 'models/Media.php';
require_once 'models/Movie.php';

class MovieController {

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;
            $genre = $_POST['genre'] ?? '';

            if (empty($title) || empty($author) || $duration <= 0) {
                echo "Tous les champs sont obligatoires et la durée doit être positive.";
                return;
            }

            $movie = new Movie(0, $title, $author, $available, $duration, $genre);
            try {
                $movie->add();
                header("Location: /media");
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout du film : " . $e->getMessage();
            }
        } else {
            $mediaType = 'film';
            require 'views/MediaForm.php';
        }
    }

    public function edit($id) {
        if ($id === null) {
            echo "ID de film manquant.";
            return;
        }
        try {
            $movie = Movie::getById((int)$id);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération du film : " . $e->getMessage();
            return;
        }

        if ($movie === null) {
            echo "Film non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;
            $genre = $_POST['genre'] ?? '';

            if (empty($title) || empty($author) || $duration <= 0) {
                echo "Tous les champs sont obligatoires et la durée doit être positive.";
                return;
            }

            $movie->setTitle($title);
            $movie->setAuthor($author);
            $movie->setAvailable($available);
            $movie->setDuration($duration);
            $movie->setGenre($genre);

            try {
                $movie->update();
                header("Location: /media");
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de la mise à jour du film : " . $e->getMessage();
            }
        } else {
            $mediaType = 'film';
            require 'views/MediaForm.php';
        }
    }
}