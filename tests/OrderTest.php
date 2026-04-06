<?php
use PHPUnit\Framework\TestCase;
use App\Models\Order;
use App\Core\Database;

require_once __DIR__ . '/../app/Models/Order.php';
require_once __DIR__ . '/../app/Core/Database.php';

class OrderTest extends TestCase {

    protected $db;
    protected $orderModel;

    protected function setUp(): void {
        $_SERVER['HTTP_HOST'] = 'localhost';
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['user_id'] = 1;

        $this->db = Database::getConnection();
        $this->orderModel = new Order($this->db);
    }

    public function testSaveOrderSimple() {
        $data = [
            'id_client' => 1,
            'total_ht'  => 100,
            'total_ttc' => 120,
            'products'  => [
                ['id' => 1, 'price' => 100, 'quantity' => 1]
            ]
        ];

        // On exécute la sauvegarde
        $result = $this->orderModel->save($data);

        // On vérifie juste si ça a renvoyé true (succès)
        $this->assertTrue($result, "Le modèle Order->save() a échoué.");

        // Optionnel : on vérifie manuellement si une ligne a été ajoutée aujourd'hui
        $stmt = $this->db->query("SELECT id_commande FROM commande ORDER BY id_commande DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();

        $this->assertNotEmpty($lastId, "Aucun ID trouvé en base après l'insertion.");

        echo "\n[INFO] Dernière commande en base : " . $lastId;
    }
}