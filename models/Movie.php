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

    public function setDuration(int $duration): void {
        $this->duration = $duration;
    }

    public function getGenre(): Genre {
        return $this->genre;
    }

    public function setGenre(Genre $genre): void {
        $this->genre = $genre;
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
                ':title' => $this->title,
                ':author' => $this->author,
                ':available' => $this->available ? 1 : 0,
            ]);
            $mediaId = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO movie (media_id, duration, genre) VALUES (:media_id, :duration, :genre)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':duration' => $this->duration,
                ':genre' => $this->genre->value
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du film : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour mettre à jour un film dans la base de données
     *
     * @return void
     * @throws Exception
     */
    public function update(){
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("UPDATE media SET title = :title, author = :author, available = :available WHERE id = :id");
            $stmt->execute([
                ':title' => $this->title,
                ':author' => $this->author,
                ':available' => $this->available ? 1 : 0,
                ':id' => $this->id
            ]);
            $stmt = $pdo->prepare("UPDATE movie SET duration = :duration, genre = :genre WHERE media_id = :media_id");
            $stmt->execute([
                ':duration' => $this->duration,
                ':genre' => $this->genre->value,
                ':media_id' => $this->id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du film : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour récupérer un film par son ID
     *
     * @param int $id
     * @return Movie|null
     * @throws Exception
     */
    public static function getById(int $id): ?Movie {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, mv.duration, mv.genre 
                                   FROM media m 
                                   JOIN movie mv ON m.id = mv.media_id
                                   WHERE m.id = :id");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Movie(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['duration'],
                    Genre::from($row['genre'])
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du film : " . $e->getMessage());
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