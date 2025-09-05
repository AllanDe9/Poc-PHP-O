<?php  
$host = 'localhost';
$db   = 'pocmvc';
$user = 'root';
$pass = 'root';

function connection() {
    global $host, $db, $user, $pass;
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}