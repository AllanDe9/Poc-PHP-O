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

    public function login(string $username, string $password): ?User {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([
                ':username' => $username,
            ]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($foundUser && password_verify($password, $foundUser['password'])) {
                return new User($foundUser['id'], $foundUser['username'], $foundUser['password']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
        }
    }

    public function register(string $username, string $password): void {
        try {
            $pdo = connection();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'inscription de l'utilisateur : " . $e->getMessage());
        }
    }

    public function checkDisponibility(string $username): bool {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE username = :username");
            $stmt->execute([
                ':username' => $username,
            ]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($foundUser) {
                return false; 
            } else {
                return true; 
            }
            
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de la disponibilité du nom d'utilisateur : " . $e->getMessage());
        }
    }
}