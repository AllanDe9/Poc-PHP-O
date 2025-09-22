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
    protected int $id;

    /**
     * @var string Titre du média
     */
    protected string $title;

    /**
     * @var string Auteur du média
     */
    protected string $author;

    /**
     * @var bool Disponibilité du média (true = disponible, false = emprunté)
     */
    protected bool $available;

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

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getAvailable() {
        return $this->available;
    }

    public function setAvailable($available) {
        $this->available = $available;
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

    /**
     * Méthode pour supprimer un média de la base de données
     *
     * @return void
     * @throws Exception
     */
    public function delete(): void {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("DELETE FROM media WHERE id = :id");
            $stmt->execute([':id' => $this->id]);

            if ($this instanceof Book) {
                $table = 'book';
            } elseif ($this instanceof Movie) {
                $table = 'movie';
            } elseif ($this instanceof Album) {
                $table = 'album';
            }

            if (isset($table)) {
                $stmt = $pdo->prepare("DELETE FROM $table WHERE media_id = :id");
                $stmt->execute([':id' => $this->id]);
            }

        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du média : " . $e->getMessage());
        }
    }

    /**
     * Retourne le type de média sous forme de chaîne de caractères
     *
     * @return string
     */
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