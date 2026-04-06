<?php
use PHPUnit\Framework\TestCase;
use App\Models\Vendeur;
use App\Core\Database;

require_once __DIR__ . '/../app/Models/Vendeur.php';
require_once __DIR__ . '/../app/Core/Database.php';

class VendeurTest extends TestCase {

    protected $db;
    protected $vendeurModel;

    protected function setUp(): void {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $this->db = Database::getConnection();
        $this->vendeurModel = new Vendeur($this->db);
    }

    /**
     * Test de récupération de la liste
     */
    public function testGetAllPersonnelReturnsArray() {
        $personnel = $this->vendeurModel->getAllPersonnel();
        $this->assertIsArray($personnel, "La méthode doit retourner un tableau.");
    }

    /**
     * Test du cycle de vie : Création -> Lecture -> Suppression
     */
    public function testFullVendeurCycle() {
        $testData = [
            'role_vendeur'       => 'test_role',
            'Nom_prenom_vendeur' => 'Unité Test',
            'mail_vendeur'       => 'test-unitaire@example.com',
            'Telephone_vendeur'  => '0102030405',
            'Mdp_vendeur'        => 'password123'
        ];

        // 1. CRÉATION
        $result = $this->vendeurModel->createVendeur($testData);
        $this->assertTrue($result, "La création du vendeur a échoué.");

        // On récupère l'ID généré pour la suite
        $id = $this->db->lastInsertId();
        $this->assertNotEmpty($id, "L'ID du vendeur créé est vide.");

        // 2. LECTURE
        $vendeur = $this->vendeurModel->getVendeurById($id);
        $this->assertEquals('Unité Test', $vendeur['Nom_prenom_vendeur']);
        $this->assertEquals('test-unitaire@example.com', $vendeur['mail_vendeur']);

        // On vérifie aussi que le mot de passe est bien haché (ne doit pas être en clair)
        $this->assertNotEquals('password123', $vendeur['Mdp_vendeur']);
        $this->assertTrue(password_verify('password123', $vendeur['Mdp_vendeur']));

        // 3. SUPPRESSION (Nettoyage de la base de données)
        $deleteResult = $this->vendeurModel->deleteVendeur($id);
        $this->assertTrue($deleteResult, "La suppression du vendeur de test a échoué.");

        // On vérifie qu'il n'existe plus
        $this->assertFalse($this->vendeurModel->getVendeurById($id));
    }
}