<?php
namespace App\Controllers;

use App\Models\Client;
use PDO;

class ClientController {
    private $clientModel;

    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard-cafthe/public/auth/login');
            exit;
        }
        $this->clientModel = new Client($db);
    }

    public function list() {
        $clients = $this->clientModel->findAll();
        require_once ROOT . '/views/clients/list.php';
    }
}