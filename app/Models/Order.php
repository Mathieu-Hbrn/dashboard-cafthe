<?php
namespace App\Models;

use PDO;

class Order {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère les commandes récentes avec le nom du client et du vendeur.
     */
    public function findAll() {
        $sql = "SELECT co.*, cl.nom_prenom_client, v.Nom_prenom_vendeur 
                FROM commande co
                JOIN client cl ON co.id_client = cl.id_client
                JOIN vendeur v ON co.id_vendeur = v.id_vendeur
                ORDER BY co.Date_commande DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}