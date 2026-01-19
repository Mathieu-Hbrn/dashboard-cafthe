<?php
namespace App\Models;

use PDO;

class User {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Trouver un vendeur par son email
    public function findByEmail($email) {
        $sql = "SELECT * FROM vendeur WHERE mail_vendeur = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}