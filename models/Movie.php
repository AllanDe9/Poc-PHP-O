<?php

/**
 * Class Movie
 *
 * Ce modèle représente un film dans la médiathèque, fils du modèle Media.
 */
class Movie extends Media {

    /**
     * @var int Durée du film en minutes
     */
    private int $duration;

    /**
     * @var Genre Genre du film
     */
    private Genre $genre;

    /**
     * Constructeur de la classe Movie
     *
     * @param int $id
     * @param string $title
     * @param string $author
     * @param bool $available
     * @param int $duration
     * @param Genre $genre
     */
    public function __construct(int $id, string $title, string $author, bool $available, int $duration, Genre $genre) {
        parent::__construct($id, $title, $author, $available);
        $this->duration = $duration;
        $this->genre = $genre;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getGenre(): Genre {
        return $this->genre;
    }

    /**
     * Méthode pour récupérer tous les films de la base de données
     *
     * @return array
     * @throws Exception
     */
    public static function getAllMovies(): array {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, mv.duration, mv.genre 
                                   FROM media m 
                                   JOIN movie mv ON m.id = mv.media_id");
            $stmt->execute();
            $movies = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $movies[] = new Movie(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['duration'],
                    Genre::from($row['genre'])
                );
            }
            return $movies;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des films : " . $e->getMessage());
        }
    }
    /**
     * Méthode pour récupérer tous les films de la base de données
     *
     * @return array
     * @throws Exception
     */
    public function add(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("INSERT INTO media (title, author, available) VALUES (:title, :author, :available)");
            $stmt->execute([
                ':title' => $this->getTitle(),
                ':author' => $this->getAuthor(),
                ':available' => $this->getAvailable() ? 1 : 0,
            ]);
            $mediaId = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO movie (media_id, duration, genre) VALUES (:media_id, :duration, :genre)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':duration' => $this->getDuration(),
                ':genre' => $this->getGenre()->value
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du film : " . $e->getMessage());
        }
    }
}

/**
 * Enum Genre
 *
 * Cette énumération représente les différents genres de films.
 */
Enum Genre: string {
    case Action = 'Action';
    case Comedy = 'Comédie';
    case Drama = 'Drame';
    case Horror = 'Horreur';
    case ScienceFiction = 'Science Fiction';
}