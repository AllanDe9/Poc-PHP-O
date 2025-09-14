<?php

/**
    * Class Media abstraite
    *
    * Ce modèle représente un média dans la médiathèque.
    */
abstract class Media {

    /**
     * @var int Identifiant unique du média
     */
    private int $id;

    /**
     * @var string Titre du média
     */
    private string $title;

    /**
     * @var string Auteur du média
     */
    private string $author;

    /**
     * @var bool Disponibilité du média (true = disponible, false = emprunté)
     */
    private bool $available;

    /**
     * Constructeur de la classe Media
     *
     * @param int $id
     * @param string $title
     * @param string $author
     * @param bool $available
     */
    public function __construct(int $id, string $title, string $author, bool $available) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->available = $available;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getAvailable() {
        return $this->available;
    }

    /**
     * Change la disponibilité du média
     */
    public function changeAvailable() {
        $this->available = !$this->available;
        $pdo = connection();
        $stmt = $pdo->prepare("UPDATE media SET available = :available WHERE id = :id");
        $stmt->execute([
            ':available' => $this->available ? 1 : 0,
            ':id' => $this->id
        ]);
    }

    public function delete(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("DELETE FROM media WHERE id = :id");
            $stmt->execute([':id' => $this->id]);


            if ($this instanceof Book) {
                $stmt = $pdo->prepare("DELETE FROM books WHERE media_id = :id");
                $stmt->execute([':id' => $this->id]);
            } elseif ($this instanceof Movie) {
                $stmt = $pdo->prepare("DELETE FROM movies WHERE media_id = :id");
                $stmt->execute([':id' => $this->id]);
            } elseif ($this instanceof Album) {
                $stmt = $pdo->prepare("DELETE FROM albums WHERE media_id = :id");
                $stmt->execute([':id' => $this->id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du média : " . $e->getMessage());
        }
    }

    public function getType(): string {
        if ($this instanceof Book) {
            return 'Livre';
        } elseif ($this instanceof Movie) {
            return 'Film';
        } elseif ($this instanceof Album) {
            return 'Album';
        }
        return '';
    }
}