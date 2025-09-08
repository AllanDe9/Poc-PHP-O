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

    /**
     * Emprunte le média si disponible
     *
     * @return bool True si l'emprunt a réussi, false sinon
     */
    public function borrow() {
        if ($this->available) {
            $this->available = false;
            return true;
        }
        return false;
    }

    /**
     * Rend le média s'il est emprunté
     *
     * @return bool True si le retour a réussi, false sinon
     */
    public function return() {
        if (!$this->available) {
            $this->available = true;
            return true;
        }
        return false;
    }
    
}