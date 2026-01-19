<?php
namespace App\Models;

use PDO;

class User {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM vendeur WHERE mail_vendeur = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Nouvelle méthode pour mettre à jour le mot de passe
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE vendeur SET Mdp_vendeur = :mdp WHERE id_vendeur = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'mdp' => $newPassword,
            'id' => $id
        ]);
    }
}