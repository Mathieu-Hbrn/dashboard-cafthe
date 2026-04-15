<?php
namespace App\Controllers;

use PDO;

class DashboardController
{
    private $db;

    public function __construct(PDO $db)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        $this->db = $db;
    }

    public function index()
    {
        $productModel = new \App\Models\Product($this->db);
        $orderModel = new \App\Models\Order($this->db);

        $data = [
            'low_stock' => $productModel->getLowStockAlert(5),
            'rev_today' => $orderModel->getRevenueByPeriod('day'),
            'rev_month' => $orderModel->getRevenueByPeriod('month'),
            'top_products' => $orderModel->getTopProducts()
        ];
        extract($data);

        require_once ROOT . '/views/dashboard/index.php';
    }

}