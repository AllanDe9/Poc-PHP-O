<?php

require_once 'models/Media.php';
require_once 'models/Book.php';
require_once 'models/Movie.php';
require_once 'models/Album.php';
require_once 'models/Song.php';

class MediaController {

    public function listMedia() {
        $books = Book::getAllBooks();
        $albums = Album::getAllAlbums();
        $movies = Movie::getAllMovies();
        $medias = array_merge($books, $albums, $movies);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $medias = array_filter($medias, function($media) use ($search) {
                $titleWords = explode(' ', $media->getTitle());
                $authorWords = explode(' ', $media->getAuthor());
                foreach (array_merge($titleWords, $authorWords) as $word) {
                    if (levenshtein($word, $search) <= 2) {
                        return true;
                    }
                }
                return false;
            });
        }
        if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $sort = $_GET['sort'];
            usort($medias, function($a, $b) use ($sort) {
                if ($sort == 'title_asc') {
                    return strcmp($a->getTitle(), $b->getTitle());
                } elseif ($sort == 'title_desc') {
                    return strcmp($b->getTitle(), $a->getTitle());
                } elseif ($sort == 'author_asc') {
                    return strcmp($a->getAuthor(), $b->getAuthor());
                } elseif ($sort == 'author_desc') {
                    return strcmp($b->getAuthor(), $a->getAuthor());
                } elseif ($sort == 'available') {
                    return ($a->getAvailable() === $b->getAvailable()) ? 0 : ($a->getAvailable() ? -1 : 1);
                }

                return 0;
            });
        }
        require 'views/Dashboard.php';
    }

    public function showMedia($id) {
        if (!isset($id) || empty($id) || !is_numeric($id)) {
            echo "Aucun identifiant fourni.";
            return;
        } 
        $id = (int)$id;
        $books = Book::getAllBooks();
        $albums = Album::getAllAlbums();
        $movies = Movie::getAllMovies();
        $medias = array_merge($books, $albums, $movies);
        $media = null;
        foreach ($medias as $m) {
            if ($m->getId() === $id) {
                $media = $m;
                break;
            }
        }
        if (!$media) {
            echo "Média non trouvé.";
            return;
        } 
        if ($media instanceof Album) {
            $songs = Song::getSongs($media);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['media_id'])) {
                $media->changeAvailable();
                $_SESSION['message'] = $media->getAvailable() ? 'Média rendu avec succès.' : 'Média emprunté avec succès.';
            } elseif (isset($_POST['delete_id'])) {
                $media->delete();
                $_SESSION['message'] = 'Média supprimé avec succès.';
                header("Location: /");
                exit();
            } elseif (isset($_POST['delete-song']) && $media instanceof Album) {
                $songId = $_POST['delete-song'];
                $song = Song::getById($songId);
                $song->delete();
                $_SESSION['message'] = 'Chanson supprimée avec succès.';
                header("Location: ./".$media->getId());
                exit();
            }
        }
        
        require 'views/MediaView.php';
    }
}