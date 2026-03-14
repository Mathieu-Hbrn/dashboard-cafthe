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
    public function findAll() {
        $sql = "SELECT c.*, cl.nom_prenom_client, v.Nom_prenom_vendeur 
                FROM commande c 
                JOIN client cl ON c.id_client = cl.id_client 
                JOIN vendeur v ON c.id_vendeur = v.id_vendeur
                ORDER BY c.Date_commande DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}