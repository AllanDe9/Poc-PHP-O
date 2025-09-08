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

    public function getEditor(): string {
        return $this->editor;
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
                ':title' => $this->getTitle(),
                ':author' => $this->getAuthor(),
                ':available' => $this->getAvailable() ? 1 : 0,
            ]);
            $mediaId = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO album (media_id, track_number, editor) VALUES (:media_id, :track_number, :editor)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':track_number' => $this->getTrackNumber(),
                ':editor' => $this->getEditor(),
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de l'album : " . $e->getMessage());
        }
    }
}
