<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                // --- RÉCUPÉRATION DE LA CONFIGURATION ---
                $configFile = dirname(__DIR__, 2) . '/config.php';
                if (!file_exists($configFile)) {
                    die("Fichier de configuration manquant. Veuillez créer le fichier config.php à la racine du projet.");
                }
                $configData = require $configFile;

                // --- DÉTECTION AUTOMATIQUE DE L'ENVIRONNEMENT ---
                if ($_SERVER['HTTP_HOST'] === 'localhost') {
                    $config = $configData['local'];
                } else {
                    $config = $configData['production'];
                }

                $host = $config['host'];
                $db   = $config['db'];
                $user = $config['user'];
                $pass = $config['pass'];

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