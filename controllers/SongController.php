<?php

require_once 'models/Media.php';
require_once 'models/Album.php';
require_once 'models/Song.php';

class SongController {

    public function add($albumId) {
        if ($albumId === null) {
            echo "ID d'album manquant.";
            return;
        }
        try {
            $album = Album::getById((int)$albumId);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de l'album : " . $e->getMessage();
            return;
        }
        if ($album === null) {
            echo "Album non trouvé.";
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $notation = isset($_POST['notation']) ? (int)$_POST['notation'] : 0;

            if (empty($title) || $notation < 0 || $notation > 10) {
                echo "Tous les champs sont obligatoires et la notation doit être comprise entre 0 et 10.";
                return;
            }

            $song = new Song(0, $title, $notation, $album);

            try {
                $song->add();
                header("Location: /Poc-PHP-O/media/" . $song->getAlbum()->getId());
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout de la chanson : " . $e->getMessage();
            }
        } else {
            require 'views/SongForm.php';
        }
    }

    public function edit($songId) {
        if ($songId === null) {
            echo "ID de chanson manquant.";
            return;
        }
        try {
            $song = Song::getById((int)$songId);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de la chanson : " . $e->getMessage();
            return;
        }
        if ($song === null) {
            echo "Chanson non trouvée.";
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $notation = isset($_POST['notation']) ? (int)$_POST['notation'] : 0;

            if (empty($title) || $notation < 0 || $notation > 10) {
                echo "Tous les champs sont obligatoires et la notation doit être comprise entre 0 et 10.";
                return;
            }

            $song->setTitle($title);
            $song->setNotation($notation);

            try {
                $song->update();
                header("Location: /Poc-PHP-O/media/" . $song->getAlbum()->getId());
                exit();
            } catch (Exception $e) {
                echo "Erreur lors de la mise à jour de la chanson : " . $e->getMessage();
            }
        } else {
            require 'views/SongForm.php';
        }
    }
}
