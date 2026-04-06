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
            \App\Core\CSRF::validate();
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
                header('Location: ' . BASE_URL . 'orders');
                exit;
            }
        }

        $clients = $clientModel->getAll();
        $products = $productModel->findAll();
        require_once ROOT . '/views/orders/add.php';
    }
    public function list() {
        $filter = $_GET['status'] ?? null;

        $orders = $this->orderModel->findAll($filter);

        require_once ROOT . '/views/orders/list.php';
    }
    public function view($id) {
        $order = $this->orderModel->findById($id);
        $items = $this->orderModel->getItems($id);

        if (!$order) {
            header('Location: ' . BASE_URL . 'orders');
            exit;
        }

        require_once ROOT . '/views/orders/detail.php';
    }
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
            \App\Core\CSRF::validate();
            $newStatus = $_POST['status'];
            if ($this->orderModel->updateStatus($id, $newStatus)) {
                header('Location: ' . BASE_URL . 'orders');
                exit;
            }
        }
    }
    public function clientOrders($clientId) {
        // On a besoin du modèle Client pour afficher le nom du client en titre
        $clientModel = new \App\Models\Client($this->db);
        $client = $clientModel->getClientById($clientId);

        if (!$client) {
            header('Location: ' . BASE_URL . 'clients/list');
            exit;
        }

        $orders = $this->orderModel->getOrdersByClientId($clientId);

        require_once ROOT . '/views/orders/client_orders.php';
    }
}