<?php
use PHPUnit\Framework\TestCase;
use App\Core\Database;

require_once __DIR__ . '/../app/Core/Database.php';

class DatabaseTest extends TestCase {

    protected $db;

    protected function setUp(): void {
        // Simulation de l'environnement pour ta classe Database
        $_SERVER['HTTP_HOST'] = 'localhost';

        try {
            $this->db = Database::getConnection();
        } catch (\Exception $e) {
            $this->fail("La connexion a échoué : " . $e->getMessage());
        }
    }

    /**
     * Vérifie que la connexion PDO est bien établie
     */
    public function testDatabaseConnectionIsValid() {
        $this->assertInstanceOf(\PDO::class, $this->db);
    }

    /**
     * Vérifie qu'on peut lire la table 'vendeur'
     */
    public function testCanSelectFromVendeur() {
        // On interroge la table que l'on voit sur ton screen
        $stmt = $this->db->query("SELECT COUNT(*) FROM vendeur");

        $this->assertNotFalse($stmt, "La requête sur la table 'vendeur' a échoué.");

        $count = $stmt->fetchColumn();
        $this->assertIsNumeric($count, "Le nombre de vendeurs doit être une valeur numérique.");

        echo "\n[INFO] Nombre de vendeurs trouvés : " . $count;
    }
}