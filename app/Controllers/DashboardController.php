<?php
namespace App\Controllers;

use PDO;

class DashboardController {
    private $db;

    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard-cafthe/public/auth/login');
            exit;
        }
        $this->db = $db;
    }

    public function index() {
        // Récupération des statistiques
        $nbProducts = $this->db->query("SELECT COUNT(*) FROM produit")->fetchColumn() ?: 0;
        $nbClients  = $this->db->query("SELECT COUNT(*) FROM client")->fetchColumn() ?: 0;
        $totalSales = $this->db->query("SELECT SUM(montant_ttc) FROM commande")->fetchColumn() ?: 0;

        // Récupération des dernières ventes
        $sql = "SELECT co.*, cl.nom_prenom_client 
                FROM commande co 
                JOIN client cl ON co.id_client = cl.id_client 
                ORDER BY co.id_commande DESC LIMIT 5";
        $recentOrders = $this->db->query($sql)->fetchAll();

        require_once ROOT . '/views/dashboard/index.php';
    }
}