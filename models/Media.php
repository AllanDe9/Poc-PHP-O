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

            if ($this instanceof Book) {
                $table = 'book';
            } elseif ($this instanceof Movie) {
                $table = 'movie';
            } elseif ($this instanceof Album) {
                $table = 'album';
                Song::deleteByAlbum($this);
            }

            if (isset($table)) {
                $stmt = $pdo->prepare("DELETE FROM $table WHERE media_id = :id");
                $stmt->execute([':id' => $this->id]);
            }

            $stmt = $pdo->prepare("DELETE FROM media WHERE id = :id");
            $stmt->execute([':id' => $this->id]);

        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du média : " . $e->getMessage());
        }
    }

    /**
     * Retourne le type de média sous forme de chaîne
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

    /**
     * Génère une image simple avec le titre du média
     *
     * @return void
     */
    public function generateImage(): void {
        $width = 200;
        $height = 200;

        $image = imagecreatetruecolor($width, $height);

        $bgColor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));

        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

        $type = $this->getType();

        if ($type === 'Livre') {

            $bookColor = imagecolorallocate($image, 120, 80, 40); // marron
            $pageColor = imagecolorallocate($image, 255, 255, 255); // blanc
            $shadowColor = imagecolorallocate($image, 80, 60, 30); // ombre
            $borderColor = imagecolorallocate($image, 0, 0, 0); // noir
            
            imagefilledrectangle($image, 61, 101, 139, 159, $shadowColor);
            
            imagefilledrectangle($image, 60, 100, 140, 160, $bookColor);
            
            imagefilledrectangle($image, 70, 110, 130, 150, $pageColor);
           
            imagerectangle($image, 60, 100, 140, 160, $borderColor);
            imagerectangle($image, 70, 110, 130, 150, $borderColor);
            
            for ($i = 0; $i < 4; $i++) {
                imageline($image, 72, 115 + $i*8, 128, 115 + $i*8, $borderColor);
            }
        }
        
        elseif ($type === 'Film') {
       
            // Dessiner un écran de télévision
            $screenColor = imagecolorallocate($image, 30, 30, 30); // gris foncé pour l'écran
            $frameColor = imagecolorallocate($image, 80, 80, 80); // gris pour le cadre
            $borderColor = imagecolorallocate($image, 0, 0, 0); // noir pour le contour
            $standColor = imagecolorallocate($image, 60, 60, 60); // gris pour le pied

            // Cadre de la TV
            imagefilledrectangle($image, 50, 80, 150, 150, $frameColor);
            imagerectangle($image, 50, 80, 150, 150, $borderColor);

            // Écran
            imagefilledrectangle($image, 60, 90, 140, 140, $screenColor);

            // Pied de la TV
            imagefilledrectangle($image, 90, 151, 110, 165, $standColor);
            imagerectangle($image, 90, 151, 110, 165, $borderColor);

            // Boutons sous l'écran
            $buttonColor = imagecolorallocate($image, 200, 0, 0); // rouge
            imagefilledellipse($image, 60, 145, 6, 6, $buttonColor);
            imageellipse($image, 60, 145, 6, 6, $borderColor);
        }
      
        elseif ($type === 'Album') {
          
            $cdColor = imagecolorallocate($image, 180, 180, 255); // bleu pâle
            $centerColor = imagecolorallocate($image, 220, 220, 220); // gris très clair
            $borderColor = imagecolorallocate($image, 0, 0, 0); // noir
   
            imagefilledellipse($image, 100, 130, 80, 80, $cdColor);
            imageellipse($image, 100, 130, 80, 80, $borderColor);
          
            imagefilledellipse($image, 100, 130, 20, 20, $centerColor);
            imageellipse($image, 100, 130, 20, 20, $borderColor);
          
            $refletColor = imagecolorallocate($image, 230, 230, 255);
            imagearc($image, 100, 130, 60, 60, 30, 60, $refletColor);
            imagearc($image, 100, 130, 60, 60, 210, 240, $refletColor);
        }

        header('Content-Type: image/png');
        imagepng($image);

        imagedestroy($image);
    }
}