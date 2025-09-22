# 📚 Système de Gestion de Médiathèque

Une application web PHP de gestion de médiathèque permettant la gestion des livres, albums, films et chansons avec un système d'authentification et d'emprunt.

## ✨ Fonctionnalités

### 🔐 Authentification
- **Inscription** : Création de compte utilisateur avec validation sécurisée
- **Connexion** : Système de login avec sessions
- **Sécurité** : Mots de passe hachés avec BCrypt
- **Validation** : Critères de mot de passe robustes (8+ caractères, majuscule, minuscule, chiffre, caractère spécial)

### 📖 Gestion des Médias
- **Livres** : Ajout, modification et consultation des livres
- **Albums** : Gestion des albums musicaux avec nombre de pistes et éditeur
- **Films** : Gestion des films avec durée et genre
- **Chansons** : Ajout de chansons aux albums avec système de notation

### 🔍 Fonctionnalités Avancées
- **Recherche** : Recherche par titre ou auteur avec tolérance orthographique
- **Tri** : Tri par titre, auteur et disponibilité
- **Système d'emprunt** : Gestion de la disponibilité des médias
- **Interface responsive** : Design moderne avec Tailwind CSS

## 🛠️ Technologies Utilisées

- **Backend** : PHP 8.3.9
- **Base de données** : MySQL
- **Frontend** : HTML5, Tailwind CSS 2.2.19
- **Architecture** : MVC (Model-View-Controller)
- **Sécurité** : PDO avec requêtes préparées, hachage BCrypt

## 📋 Prérequis

- PHP 8.3 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx) avec mod_rewrite
- Composer (optionnel)

## 🚀 Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/AllanDe9/Poc-PHP-O.git
   cd Poc-PHP-O
   ```

2. **Configuration de la base de données**
   - Créer une base de données MySQL nommée `pocmvc`
   - Modifier les paramètres de connexion dans `connection.php` :
   ```php
   $host = 'localhost';
   $db   = 'pocmvc';
   $user = 'votre_utilisateur';
   $pass = 'votre_mot_de_passe';
   ```

3. **Créer la structure de base de données**
   ```sql
   CREATE DATABASE pocmvc;
   USE pocmvc;

   -- Table des utilisateurs
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(255) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL
   );

   -- Table principale des médias
   CREATE TABLE media (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       author VARCHAR(255) NOT NULL,
       available BOOLEAN DEFAULT TRUE
   );

   -- Table des livres
   CREATE TABLE book (
       media_id INT PRIMARY KEY,
       pages INT,
       isbn VARCHAR(13),
       FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
   );

   -- Table des albums
   CREATE TABLE album (
       media_id INT PRIMARY KEY,
       track_number INT,
       editor VARCHAR(255),
       FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
   );

   -- Table des films
   CREATE TABLE movie (
       media_id INT PRIMARY KEY,
       duration INT,
       genre VARCHAR(255),
       FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
   );

   -- Table des chansons
   CREATE TABLE song (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       notation INT,
       album_id INT,
       FOREIGN KEY (album_id) REFERENCES album(media_id) ON DELETE CASCADE
   );
   ```

4. **Configuration du serveur web**
   - Configurer le DocumentRoot vers le dossier du projet
   - S'assurer que mod_rewrite est activé
   - Le fichier `.htaccess` est déjà configuré

## 💻 Utilisation

1. **Accéder à l'application**
   - Ouvrir `http://localhost/Poc-PHP-O/` dans votre navigateur

2. **Première utilisation**
   - Créer un compte via le lien "S'inscrire"
   - Se connecter avec vos identifiants

3. **Gestion des médias**
   - Ajouter des livres, albums et films via les boutons d'ajout
   - Rechercher et trier les médias
   - Emprunter/rendre des médias
   - Modifier les informations des médias

## 📁 Structure du Projet

```
Poc-PHP-O/
├── controllers/           # Contrôleurs MVC
│   ├── UserController.php
│   ├── MediaController.php
│   ├── BookController.php
│   ├── AlbumController.php
│   ├── MovieController.php
│   └── SongController.php
├── models/               # Modèles de données
│   ├── User.php
│   ├── Media.php
│   ├── Book.php
│   ├── Album.php
│   ├── Movie.php
│   └── Song.php
├── views/                # Vues/Templates
│   ├── Dashboard.php
│   ├── LoginView.php
│   ├── RegisterView.php
│   ├── MediaView.php
│   ├── MediaForm.php
│   ├── SongForm.php
│   └── Navbar.php
├── connection.php        # Configuration base de données
├── index.php            # Point d'entrée et routeur
├── .htaccess           # Configuration Apache
└── README.md
```

## 🔧 Fonctionnalités Techniques

### Architecture MVC
- **Modèles** : Gestion des données et logique métier
- **Vues** : Interface utilisateur avec Tailwind CSS
- **Contrôleurs** : Logique applicative et routage

### Sécurité
- Protection contre les injections SQL avec PDO
- Hachage sécurisé des mots de passe
- Validation côté serveur
- Gestion des sessions

### Base de Données
- Conception relationnelle avec clés étrangères
- Héritage des médias (livre, album, film)
- Intégrité référentielle

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork du projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit des changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 État du Projet

### ✅ Fonctionnalités Implémentées
- ✅ Connexion à la base de données
- ✅ Système d'authentification complet
- ✅ Gestion CRUD des médias (livres, albums, films)
- ✅ Système d'emprunt/retour
- ✅ Recherche et tri
- ✅ Interface utilisateur responsive

### 🚧 Améliorations Possibles
- Système de réservation
- Historique des emprunts
- Notifications par email
- API REST
- Tests unitaires
- Panel d'administration

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

**Version PHP** : 8.3.9  
**Développeur** : AllanDe9