<?php
namespace App\Models;

use PDO;
use Exception;

class Order {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Récupère toutes les commandes pour la liste
    public function findAll($status = null) {
        $sql = "SELECT c.*, cl.nom_prenom_client, v.Nom_prenom_vendeur 
            FROM commande c
            JOIN client cl ON c.id_client = cl.id_client
            JOIN vendeur v ON c.id_vendeur = v.id_vendeur";

        // Ajout pour filtrage par status
        if ($status) {
            $sql .= " WHERE c.status_commande = :status";
        }

        $sql .= " ORDER BY c.Date_commande DESC";

        $stmt = $this->db->prepare($sql);

        if ($status) {
            $stmt->execute(['status' => $status]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Récupère une commande spécifique
    public function findById($id) {
        $sql = "SELECT c.*, cl.nom_prenom_client 
                FROM commande c 
                JOIN client cl ON c.id_client = cl.id_client 
                WHERE c.id_commande = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère les articles d'une commande (Ligne Commande)
    public function getItems($orderId) {
        $sql = "SELECT lc.*, p.designation_produit 
                FROM lignecommande lc 
                JOIN produit p ON lc.id_produit = p.id_produit 
                WHERE lc.id_commande = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Enregistre une nouvelle vente avec transaction
    public function save($data) {
        try {
            $this->db->beginTransaction();

            // 1. Insertion de la commande
            $sqlOrder = "INSERT INTO commande (id_client, id_vendeur, Date_commande, status_commande, Montant_ht, montant_ttc) 
                         VALUES (:client, :vendeur, NOW(), 'Validée', :ht, :ttc)";
            $stmtOrder = $this->db->prepare($sqlOrder);
            $stmtOrder->execute([
                'client'  => $data['id_client'],
                'vendeur' => $_SESSION['user_id'],
                'ht'      => $data['total_ht'],
                'ttc'     => $data['total_ttc']
            ]);

            $orderId = $this->db->lastInsertId();

            // 2. Insertion des lignes (PrixUnitLigne et QuantiteProduitLigne selon ta BDD)
            $sqlLine = "INSERT INTO lignecommande (id_commande, id_produit, PrixUnitLigne, QuantiteProduitLigne) 
                        VALUES (:id_o, :id_p, :prix, :qte)";
            $stmtLine = $this->db->prepare($sqlLine);

            foreach ($data['products'] as $item) {
                $stmtLine->execute([
                    'id_o' => $orderId,
                    'id_p' => $item['id'],
                    'prix' => $item['price'],
                    'qte'  => $item['quantity']
                ]);

                // 3. Mise à jour du stock
                $this->db->prepare("UPDATE produit SET stock_produit = stock_produit - :qte WHERE id_produit = :id")
                    ->execute(['qte' => $item['quantity'], 'id' => $item['id']]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function updateStatus($id, $status) {
        // Mise a jour table 'commande'
        $sql = "UPDATE commande SET status_commande = :status WHERE id_commande = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id'     => $id
        ]);
    }
    public function getOrdersByClientId($clientId) {
        $sql = "SELECT * FROM commande 
            WHERE id_client = :id 
            ORDER BY Date_commande DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $clientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Chiffre d'Affaire par Période (Aujourd'hui, Mois, Année)
    public function getRevenueByPeriod($period = 'day') {
        $sql = match($period) {
            'day'   => "SELECT SUM(montant_ttc) as total FROM commande WHERE DATE(Date_commande) = CURDATE()",
            'month' => "SELECT SUM(montant_ttc) as total FROM commande WHERE MONTH(Date_commande) = MONTH(CURDATE()) AND YEAR(Date_commande) = YEAR(CURDATE())",
            'year'  => "SELECT SUM(montant_ttc) as total FROM commande WHERE YEAR(Date_commande) = YEAR(CURDATE())",
        };
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    // Top 5 des produits les plus vendus
    public function getTopProducts() {
        $sql = "SELECT p.designation_produit, SUM(lc.QuantiteProduitLigne) as total_vendu 
            FROM lignecommande lc
            JOIN produit p ON lc.id_produit = p.id_produit
            GROUP BY p.id_produit, p.designation_produit
            ORDER BY total_vendu DESC 
            LIMIT 5";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}