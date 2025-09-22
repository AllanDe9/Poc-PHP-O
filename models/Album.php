<?php

/**
 * Class Album
 *
 * Ce modèle représente un album dans la médiathèque, fils du modèle Media.
 */
class Album extends Media {

    /**
     * @var int Nombre de pistes de l'album
     */
    private int $trackNumber;

    /**
     * @var string Éditeur de l'album
     */
    private string $editor;

    /**
     * Constructeur de la classe Album
     *
     * @param int $id
     * @param string $title
     * @param string $author
     * @param bool $available
     * @param int $trackNumber
     * @param string $editor
     */
    public function __construct(int $id, string $title, string $author, bool $available, int $trackNumber, string $editor) {
        parent::__construct($id, $title, $author, $available);
        $this->trackNumber = $trackNumber;
        $this->editor = $editor;
    }

    public function getTrackNumber(): int {
        return $this->trackNumber;
    }

    public function setTrackNumber(int $trackNumber): void {
        $this->trackNumber = $trackNumber;
    }

    public function getEditor(): string {
        return $this->editor;
    }

    public function setEditor(string $editor): void {
        $this->editor = $editor;
    }
    
    /**
     * Méthode pour récupérer tous les albums de la base de données
     *
     * @return array
     * @throws Exception
     */
    public static function getAllAlbums(): array {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, a.track_number, a.editor 
                                   FROM media m 
                                   JOIN album a ON m.id = a.media_id");
            $stmt->execute();
            $albums = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $albums[] = new Album(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['track_number'],
                    $row['editor']
                );
            }
            return $albums;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des albums : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour ajouter un album à la base de données
     *
     * @return void
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
            $stmt = $pdo->prepare("INSERT INTO album (media_id, track_number, editor) VALUES (:media_id, :track_number, :editor)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':track_number' => $this->trackNumber,
                ':editor' => $this->editor,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de l'album : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour mettre à jour un album dans la base de données
     *
     * @return void
     * @throws Exception
     */
    public function update(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("UPDATE media SET title = :title, author = :author, available = :available WHERE id = :id");
            $stmt->execute([
                ':title' => $this->title,
                ':author' => $this->author,
                ':available' => $this->available ? 1 : 0,
                ':id' => $this->id
            ]);
            $stmt = $pdo->prepare("UPDATE album SET track_number = :track_number, editor = :editor WHERE media_id = :media_id");
            $stmt->execute([
                ':track_number' => $this->trackNumber,
                ':editor' => $this->editor,
                ':media_id' => $this->id
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'album : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour récupérer un album par son ID
     *
     * @param int $id
     * @return Album|null
     * @throws Exception
     */
    public static function getById(int $id): ?Album {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, a.track_number, a.editor 
                                   FROM media m 
                                   JOIN album a ON m.id = a.media_id 
                                   WHERE m.id = :id");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Album(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['track_number'],
                    $row['editor']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de l'album : " . $e->getMessage());
        }
    }
}
