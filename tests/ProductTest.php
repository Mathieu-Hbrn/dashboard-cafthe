<?php
use PHPUnit\Framework\TestCase;
use App\Models\Product;
use App\Core\Database;

require_once __DIR__ . '/../app/Models/Product.php';
require_once __DIR__ . '/../app/Core/Database.php';

class ProductTest extends TestCase {

    protected $db;
    protected $productModel;

    protected function setUp(): void {
        // On simule l'environnement pour Database.php
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->db = Database::getConnection();

        // On injecte la connexion dans le modèle
        $this->productModel = new Product($this->db);
    }

    /**
     * TEST DE LOGIQUE (Unitaire)
     * On vérifie que la règle métier des taxes est respectée.
     */
    public function testVatCalculation() {
        // Catégorie 1 (Thé) -> 5.5%
        $priceThe = $this->productModel->getPriceTTC(100, 1);
        $this->assertEquals(105.5, $priceThe, "Le thé devrait avoir une TVA de 5.5%");

        // Catégorie 3 (Accessoires) -> 20%
        $priceAccessoire = $this->productModel->getPriceTTC(100, 3);
        $this->assertEquals(120, $priceAccessoire, "L'accessoire devrait avoir une TVA de 20%");
    }

    /**
     * TEST D'INTÉGRATION (Base de données)
     * On vérifie que findAll() renvoie bien un tableau.
     */
    public function testFindAllReturnsData() {
        $products = $this->productModel->findAll();

        $this->assertIsArray($products, "findAll() doit retourner un tableau.");

        // Si tu as déjà des produits en base, on peut vérifier qu'il y en a au moins un
        if (count($products) > 0) {
            $this->assertArrayHasKey('designation_produit', $products[0]);
        }
    }
}