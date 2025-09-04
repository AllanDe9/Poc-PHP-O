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
}
