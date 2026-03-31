<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                // --- DÉTECTION AUTOMATIQUE DE L'ENVIRONNEMENT ---
                if ($_SERVER['HTTP_HOST'] === 'localhost') {
                    // Paramètres XAMPP local
                    $host = 'localhost';
                    $db   = 'MHOUBRON_';
                    $user = 'root';
                    $pass = '';
                } else {
                    // Paramètres Serveur Distant
                    $host = 'localhost';
                    $db   = 'MHOUBRON_';
                    $user = 'Mathieu-Hbrn';
                    $pass = '4t1qY*8f4';
                }

                $charset = 'utf8mb4';
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);

            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données.");
            }
        }
        return self::$instance;
    }
}