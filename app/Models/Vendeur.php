<?php
namespace App\Models;
use PDO;

class Vendeur {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllPersonnel() {
        $sql = "SELECT id_vendeur, role_vendeur, Nom_prenom_vendeur, mail_vendeur, Telephone_vendeur 
                FROM vendeur 
                ORDER BY role_vendeur ASC, Nom_prenom_vendeur ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un vendeur précis
    public function getVendeurById($id) {
        $stmt = $this->db->prepare("SELECT * FROM vendeur WHERE id_vendeur = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Mettre à jour les informations
    public function updateVendeur($id, $data) {
        $sql = "UPDATE vendeur SET 
            Nom_prenom_vendeur = :nom, 
            mail_vendeur = :mail, 
            Telephone_vendeur = :tel, 
            role_vendeur = :role 
            WHERE id_vendeur = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom'   => $data['Nom_prenom_vendeur'],
            'mail'  => $data['mail_vendeur'],
            'tel'   => $data['Telephone_vendeur'],
            'role'  => $data['role_vendeur'],
            'id'    => $id
        ]);
    }

    // Supprimer un membre du personnel
    public function deleteVendeur($id) {
        $stmt = $this->db->prepare("DELETE FROM vendeur WHERE id_vendeur = ?");
        return $stmt->execute([$id]);
    }

    // Ajouter un nouveau membre du personnel
    public function createVendeur($data) {
        $sql = "INSERT INTO vendeur (role_vendeur, Nom_prenom_vendeur, mail_vendeur, Telephone_vendeur, Mdp_vendeur) 
            VALUES (:role, :nom, :mail, :tel, :mdp)";

        $stmt = $this->db->prepare($sql);

        // On hache le mot de passe avant l'insertion
        $hashedPassword = password_hash($data['Mdp_vendeur'], PASSWORD_DEFAULT);

        return $stmt->execute([
            'role' => $data['role_vendeur'],
            'nom'  => $data['Nom_prenom_vendeur'],
            'mail' => $data['mail_vendeur'],
            'tel'  => $data['Telephone_vendeur'],
            'mdp'  => $hashedPassword
        ]);
    }
}