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
}