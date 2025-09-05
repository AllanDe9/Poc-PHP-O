<?php
/**
 * Class Book
 *
 * Ce modèle représente un livre dans la médiathèque, fils du modèle Media.
 */
class Book extends Media {
    
    /**
     * @var int Nombre de pages du livre
     */
    private int $pageNumber;

    /**
     * Constructeur de la classe Book
     *
     * @param int $id
     * @param string $title
     * @param string $author
     * @param bool $available
     * @param int $pageNumber
     */
    public function __construct(int $id, string $title, string $author, bool $available, int $pageNumber) {
        parent::__construct($id, $title, $author, $available);
        $this->pageNumber = $pageNumber;
    }

    public function getPageNumber(): int {
        return $this->pageNumber;
    }

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
            $stmt = $pdo->prepare("INSERT INTO book (media_id, page_number) VALUES (:media_id, :page_number)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':page_number' => $this->getPageNumber(),
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du livre : " . $e->getMessage());
        }
    }
}