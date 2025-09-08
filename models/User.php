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

    /**
     * Méthode pour connecter un utilisateur
     *
     * @param string $username
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function login(string $username, string $password): bool {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([
                ':username' => $username,
            ]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($foundUser && password_verify($password, $foundUser['password'])) {
                $this->id = $foundUser['id'];
                $this->username = $foundUser['username'];
                $this->password = $foundUser['password'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la connexion de l'utilisateur : " . $e->getMessage());
        }
    }

    /**
     * Méthode pour enregistrer un nouvel utilisateur
     *
     * @param string $username
     * @param string $password
     * @return void
     * @throws Exception
     */
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

    /**
     * Méthode pour vérifier la disponibilité d'un nom d'utilisateur
     *
     * @return bool True si le nom d'utilisateur est disponible, false sinon
     * @throws Exception
     */
    public function checkDisponibility(): bool {
        try {
            $pdo = connection();
            $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE username = :username");
            $stmt->execute([
                ':username' => $this->username,
            ]);
            $foundUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($foundUser['count(*)'] > 0) {
                return false;
            } else {
                return true; 
            }
            
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de la disponibilité du nom d'utilisateur : " . $e->getMessage());
        }
    }
}