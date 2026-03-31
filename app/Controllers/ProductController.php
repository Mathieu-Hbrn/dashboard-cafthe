<?php
namespace App\Controllers;

use App\Models\Product;
use PDO;

class ProductController {
    private $productModel;

    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        // Connexion BDD pour le modèle
        $this->productModel = new Product($db);
    }

    /**
     * Action : Afficher la liste des produits
     */
    public function list() {
        // 1. Récupérer les données
        $products = $this->productModel->findAll();

        // 2. Préparer les données pour la vue
        foreach ($products as &$p) {
            $p['prix_ttc'] = $this->productModel->getPriceTTC($p['prix_ht_produit'], $p['id_categorie']);
        }

        // 3. Charger la vue
        require_once __DIR__ . '/../../views/products/list.php';
    }

    public function add() {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->create($_POST)) {
                // Redirection vers la liste après succès
                header('Location: ' . BASE_URL . 'products/list');
                exit;
            } else {
                $message = "Erreur lors de l'ajout du produit.";
            }
        }

        require_once ROOT . '/views/products/add.php';
    }
    /**
     * supprimer un produit
     */
    public function delete($id) {
        if ($this->productModel->delete($id)) {
            // Redirection vers la liste après suppression
            header('Location: ' . BASE_URL . 'products');
            exit;
        } else {
            die("Erreur lors de la suppression du produit.");
        }
    }
    public function edit($id) {
        // Récupèration du produit
        $product = $this->productModel->findById($id);

        if (!$product) {
            die("Produit introuvable.");
        }

        // Verification et update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productModel->update($id, $_POST)) {
                header('Location: ' . BASE_URL . 'products');
                exit;
            }
        }

        // 3. On affiche la vue avec les données du produit
        require_once ROOT . '/views/products/edit.php';
    }
}