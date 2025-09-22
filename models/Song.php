<?php 
/**
 * Class Song
 *
 * Ce modèle représente une chanson dans la médiathèque, fils du modèle Media.
 */
class Song  {

    /**
     * @var int Identifiant de la chanson
     */
    private int $id;

    /**
     * @var string Titre de la chanson
     */
    private string $title;

    /**
     * @var int Notation de la chanson
     */
    private int $notation;

    /**
     * @var Album Album de la chanson
     */
    private Album $album;

    /**
     * Constructeur de la classe Song
     *
     * @param int $id
     * @param string $title
     * @param int $notation
     * @param Album $album
     */
    public function __construct(int $id, string $title, int $notation, Album $album) {
        $this->id = $id;
        $this->title = $title;
        $this->notation = $notation;
        $this->album = $album;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getNotation(): int {
        return $this->notation;
    }

    public function setNotation(int $notation): void {
        $this->notation = $notation;
    }

    public function getAlbum(): Album {
        return $this->album;
    }

    public function setAlbum(Album $album): void {
        $this->album = $album;
    }

    /**
     * Méthode pour récupérer toutes les chansons d'un album de la base de données
     *
     * @param Album $album
     * @return array
     * @throws Exception
     */
    public static function getSongs($album): array {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT s.id, s.title, s.notation, s.album_id 
                                   FROM song s 
                                   WHERE s.album_id = :album_id");
            $stmt->execute([':album_id' => $album->getId()]);
            $songs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $songs[] = new Song(
                    $row['id'],
                    $row['title'],
                    $row['notation'],
                    $album
                );
            }
            return $songs;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des chansons : " . $e->getMessage());
        }
    }
    /**
     * Méthode pour ajouter une chanson à la base de données
     *
     * @throws Exception
     */
    public function add(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("INSERT INTO song (title, notation, album_id) VALUES (:title, :notation, :album_id)");
            $stmt->execute([
                ':title' => $this->title,
                ':notation' => $this->notation,
                ':album_id' => $this->album->getId(),
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la chanson : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour mettre à jour une chanson dans la base de données
     *
     * @return void
     * @throws Exception
     */
    public function update(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("UPDATE song SET title = :title, notation = :notation, album_id = :album_id WHERE id = :id");
            $stmt->execute([
                ':title' => $this->title,
                ':notation' => $this->notation,
                ':album_id' => $this->album->getId(),
                ':id' => $this->id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de la chanson : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour supprimer une chanson de la base de données
     *
     * @return void
     * @throws Exception
     */
    public function delete(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("DELETE FROM song WHERE id = :id");
            $stmt->execute([':id' => $this->id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la chanson : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour récupérer une chanson par son ID
     *
     * @param int $id
     * @return Song|null
     * @throws Exception
     */
    public static function getById(int $id): ?Song {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT s.id, s.title, s.notation, s.album_id,
                                          a.id AS album_id, a.title AS album_title, a.author AS album_author, a.available AS album_available, a.track_number AS album_track_number, a.editor AS album_editor
                                   FROM song s
                                   JOIN album a ON s.album_id = a.media_id
                                   WHERE s.id = :id");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $album = new Album(
                    $row['album_id'],
                    $row['album_title'],
                    $row['album_author'],
                    (bool)$row['album_available'],
                    (int)$row['album_track_number'],
                    $row['album_editor']
                );
                return new Song(
                    $row['id'],
                    $row['title'],
                    $row['notation'],
                    $album
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de la chanson : " . $e->getMessage());
        }
    }
}
