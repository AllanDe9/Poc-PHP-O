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

    public function setPageNumber(int $pageNumber): void {
        $this->pageNumber = $pageNumber;
    }

    /**
     * Méthode pour récupérer tous les livres de la base de données
     *
     * @return array
     * @throws Exception
     */
    public static function getAllBooks(): array {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, b.page_number 
                                   FROM media m 
                                   JOIN book b ON m.id = b.media_id");
            $stmt->execute();
            $books = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $books[] = new Book(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['page_number']
                );
            }
            return $books;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des livres : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour ajouter un livre à la base de données
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
            $stmt = $pdo->prepare("INSERT INTO book (media_id, page_number) VALUES (:media_id, :page_number)");
            $stmt->execute([
                ':media_id' => $mediaId,
                ':page_number' => $this->pageNumber,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du livre : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour mettre à jour un livre dans la base de données
     *
     * @return void
     * @throws Exception
     */
    public function update(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("UPDATE media SET title = :title, author = :author, available = :available WHERE id = :id");
            $stmt->execute([
                ':id' => $this->id,
                ':title' => $this->title,
                ':author' => $this->author,
                ':available' => $this->available ? 1 : 0,
            ]);
            $stmt = $pdo->prepare("UPDATE book SET page_number = :page_number WHERE media_id = :media_id");
            $stmt->execute([
                ':media_id' => $this->id,
                ':page_number' => $this->pageNumber,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la modification du livre : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour récupérer un livre par son ID
     *
     * @param int $id
     * @return Book|null
     * @throws Exception
     */
    public static function getById(int $id): ?Book {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT m.id, m.title, m.author, m.available, b.page_number 
                                   FROM media m 
                                   JOIN book b ON m.id = b.media_id 
                                   WHERE m.id = :id");
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Book(
                    $row['id'],
                    $row['title'],
                    $row['author'],
                    (bool)$row['available'],
                    (int)$row['page_number']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du livre : " . $e->getMessage());
        }
    }
    
}