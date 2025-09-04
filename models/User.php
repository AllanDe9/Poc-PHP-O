<?php

/**
 * Class User
 *
 * Ce modèle représente un utilisateur de la médiathèque.
 */
class User {

    /**
     * @var int Identifiant de l'utilisateur
     */
    private int $id;

    /**
     * @var string Nom d'utilisateur
     */
    private string $username;

    /**
     * @var string Mot de passe
     */
    private string $password;

    /**
     * Constructeur de la classe User
     *
     * @param int $id
     * @param string $username
     * @param string $password
     */

    public function __construct(int $id, string $username, string $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

}