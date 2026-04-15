<?php
namespace App\Models;

use PDO;

class Product {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère tous les produits avec leur catégorie.
     */
    public function findAll() {
        $sql = "SELECT p.*, c.type_categorie 
                FROM produit p 
                JOIN categorie c ON p.id_categorie = c.id_categorie 
                ORDER BY p.id_produit DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Calcule le prix TTC :
     * 5,5% pour thés (1) et cafés (2), 20% pour accessoires (3).
     */
    public function getPriceTTC($priceHT, $categoryId) {
        $rate = ($categoryId == 3) ? 0.20 : 0.055;
        return $priceHT * (1 + $rate);
    }
    /**
     * Récupérer un produit par son ID
     */
    public function findById($id) {
        // On utilise bien 'id_produit' qui est la clé primaire de ta table
        $sql = "SELECT * FROM produit WHERE id_produit = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function create($data) {
        $sql = "INSERT INTO produit (designation_produit, prix_ht_produit, id_categorie, stock_produit, Type_conditionnement, description_produit, Photo) 
            VALUES (:designation, :prix_ht, :id_categorie, :stock, :conditionnement, :description, :photo)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'designation'     => $data['designation'],
            'prix_ht'         => $data['prix_ht'],
            'id_categorie'    => $data['id_categorie'],
            'stock'           => $data['stock'],
            'conditionnement' => $data['conditionnement'],
            'description'     => $data['description'],
            'photo'           => 'default.jpg' // Valeur par défaut demandée par l'existant
        ]);
    }

    /**
     * supprime un produit
     * @param $id
     * @return bool
     */
    public function delete($id) {
        // On cible la table 'produit' et la colonne 'id_produit'
        $stmt = $this->db->prepare("DELETE FROM produit WHERE id_produit = ?");
        return $stmt->execute([$id]);
    }
    public function update($id, $data) {
        // Génération de la requête
        $sql = "UPDATE produit SET 
            designation_produit = :nom, 
            prix_ht_produit = :prix, 
            stock_produit = :stock, 
            id_categorie = :cat 
            WHERE id_produit = :id";

        // Préparation par PDO
        $stmt = $this->db->prepare($sql);

        // Exécution sécurisée avec association des valeurs
        return $stmt->execute([
            'nom'   => $data['designation_produit'],
            'prix'  => $data['prix_ht_produit'],
            'stock' => $data['stock_produit'],
            'cat'   => $data['id_categorie'],
            'id'    => $id
        ]);
    }
    // Alerte Stock Bas
    public function getLowStockAlert($threshold = 5) {
        $sql = "SELECT designation_produit, stock_produit 
            FROM produit 
            WHERE stock_produit <= :threshold 
            ORDER BY stock_produit ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['threshold' => $threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}