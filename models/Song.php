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
}
