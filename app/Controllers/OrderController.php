<?php
namespace App\Controllers;

use App\Models\Order;
use PDO;

class OrderController {
    private $orderModel;

    public function __construct(PDO $db) {
        // Sécurité : accès réservé aux connectés
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard-cafthe/public/auth/login');
            exit;
        }
        $this->orderModel = new Order($db);
    }

    public function list() {
        $orders = $this->orderModel->findAll();
        require_once ROOT . '/views/orders/list.php';
    }
}