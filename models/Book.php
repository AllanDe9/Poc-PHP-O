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
}