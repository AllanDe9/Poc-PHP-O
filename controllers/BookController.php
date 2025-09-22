<?php

require_once 'models/Media.php';
require_once 'models/Book.php';

class BookController {

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $pageNumber = isset($_POST['page_number']) ? (int)$_POST['page_number'] : 0;

            if (empty($title) || empty($author) || $pageNumber <= 0) {
                echo "Tous les champs sont obligatoires et le nombre de pages doit être positif.";
                return;
            }

            $book = new Book(0, $title, $author, $available, $pageNumber);
            try {
                $book->add();
                header("Location: /media");
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout du livre : " . $e->getMessage();
            }
        } else {
            $mediaType = 'livre';
            require 'views/MediaForm.php';
        }
    }

    public function edit($id) {
        if ($id === null) {
            echo "ID de livre manquant.";
            return;
        }
        try {
            $book = Book::getById((int)$id);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération du livre : " . $e->getMessage();
            return;
        }

        if ($book === null) {
            echo "Livre non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $pageNumber = isset($_POST['page_number']) ? (int)$_POST['page_number'] : 0;

            if (empty($title) || empty($author) || $pageNumber <= 0) {
                echo "Tous les champs sont obligatoires et le nombre de pages doit être positif.";
                return;
            }

            $book->setTitle($title);
            $book->setAuthor($author);
            $book->setAvailable($available);
            $book->setPageNumber($pageNumber);

            try {
                $book->update();
                header("Location: /media");
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de la mise à jour du livre : " . $e->getMessage();
            }
        } else {
            $mediaType = 'livre';
            require 'views/MediaForm.php';
        }
    }
}