<?php

require_once 'models/Media.php';
require_once 'models/Album.php';

class AlbumController {

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $trackNumber = isset($_POST['track_number']) ? (int)$_POST['track_number'] : 0;
            $editor = $_POST['editor'] ?? '';

            if (empty($title) || empty($author) || $trackNumber <= 0 || empty($editor)) {
                echo "Tous les champs sont obligatoires et le nombre de pistes doit être positif.";
                return;
            }

            $album = new Album(0, $title, $author, $available, $trackNumber, $editor);
            try {
                $album->add();
                header("Location: /Poc-PHP-O/");
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout de l'album : " . $e->getMessage();
            }
        } else {
            $mediaType = 'album';
            require 'views/MediaForm.php';
        }
    }

    public function edit($id) {
        if ($id === null) {
            echo "ID d'album manquant.";
            return;
        }
        try {
            $media = Album::getById((int)$id);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de l'album : " . $e->getMessage();
            return;
        }
        if ($media === null) {
            echo "Album non trouvé.";
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $available = isset($_POST['available']) ? true : false;
            $trackNumber = isset($_POST['track_number']) ? (int)$_POST['track_number'] : 0;
            $editor = $_POST['editor'] ?? '';

            if (empty($title) || empty($author) || $trackNumber <= 0 || empty($editor)) {
                echo "Tous les champs sont obligatoires et le nombre de pistes doit être positif.";
                return;
            }

            $media->setTitle($title);
            $media->setAuthor($author);
            $media->setAvailable($available);
            $media->setTrackNumber($trackNumber);
            $media->setEditor($editor);

            try {
                $media->update();
                header("Location: /Poc-PHP-O/media/".$media->getId());
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de la mise à jour de l'album : " . $e->getMessage();
            }
        } else {
            $mediaType = 'album';
            require 'views/MediaForm.php';
        }
    }
}