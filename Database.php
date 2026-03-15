<?php
class Database {
    private static $instance = null;
    private $connexion;

    // Paramètres de connexion
    private $host = 'localhost';
    private $db_name = 'MHOUBRON_';
    private $username = 'Mathieu-Hbrn';
    private $password = '4t1qY*8f4';

    private function __construct() {
        try {
            $this->connexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnexion() {
        return $this->connexion;
    }
}