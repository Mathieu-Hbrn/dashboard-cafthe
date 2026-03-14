<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Product;
use PDO;

class OrderController {
    private $db; // C'est cette ligne qui manquait !
    private $orderModel;

    public function __construct(PDO $db) {
        $this->db = $db; // On stocke la connexion ici
        $this->orderModel = new Order($db);
    }

    public function add() {
        // Maintenant $this->db n'est plus NULL
        $clientModel = new Client($this->db);
        $productModel = new Product($this->db);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $totalHT = 0;
            $orderData = [
                'id_client' => $_POST['id_client'],
                'products' => []
            ];

            foreach ($_POST['products'] as $item) {
                // Utilisation sécurisée de $this->db
                $sql = "SELECT prix_ht_produit FROM produit WHERE id_produit = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(['id' => $item['id']]);
                $p = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($p) {
                    $priceHT = $p['prix_ht_produit'];
                    $totalHT += $priceHT * $item['quantity'];

                    $orderData['products'][] = [
                        'id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $priceHT
                    ];
                }
            }

            $orderData['total_ht'] = $totalHT;
            $orderData['total_ttc'] = $totalHT * 1.20;

            if ($this->orderModel->save($orderData)) {
                $_SESSION['flash_success'] = "Vente enregistrée avec succès !";
                header('Location: /dashboard-cafthe/public/orders');
                exit;
            }
        }

        $clients = $clientModel->findAll();
        $products = $productModel->findAll();
        require_once ROOT . '/views/orders/add.php';
    }
    public function list() {
        $orders = $this->orderModel->findAll();
        require_once ROOT . '/views/orders/list.php';
    }
    public function view($id) {
        $order = $this->orderModel->findById($id);
        $items = $this->orderModel->getItems($id);

        if (!$order) {
            header('Location: /dashboard-cafthe/public/orders');
            exit;
        }

        require_once ROOT . '/views/orders/detail.php';
    }
}