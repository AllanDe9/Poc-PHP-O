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

    public function getTitle(): string {
        return $this->title;
    }

    public function getNotation(): int {
        return $this->notation;
    }

    public function getAlbum(): Album {
        return $this->album;
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
                ':title' => $this->getTitle(),
                ':notation' => $this->getNotation(),
                ':album_id' => $this->getAlbum()->getId(),
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la chanson : " . $e->getMessage());
        }
    }

    public function delete(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("DELETE FROM song WHERE id = :id");
            $stmt->execute([':id' => $this->id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la chanson : " . $e->getMessage());
        }
    }
}
