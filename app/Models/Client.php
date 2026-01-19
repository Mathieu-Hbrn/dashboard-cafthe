<?php
namespace App\Models;

use PDO;

class Client {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère la liste de tous les clients.
     */
    public function findAll() {
        $sql = "SELECT * FROM client ORDER BY nom_prenom_client ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}