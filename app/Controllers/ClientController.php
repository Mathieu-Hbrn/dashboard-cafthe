<?php
namespace App\Controllers;

use App\Models\Client;
use PDO;

class ClientController {
    private $clientModel;

    // Ton index.php fait "new ClientController($db)", donc on reçoit $db ici
    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        // On passe la connexion reçue au Modèle
        $this->clientModel = new Client($db);
    }

    public function list() {
        $searchTerm = $_GET['search'] ?? '';

        if (!empty($searchTerm)) {
            $clients = $this->clientModel->searchClients($searchTerm);
        } else {
            $clients = $this->clientModel->getAll();
        }

        require_once ROOT . '/views/clients/list.php';
    }
    public function edit($id) {
        // 1. Récupérer les données du client
        $client = $this->clientModel->getClientById($id);

        if (!$client) {
            header('Location: ' . BASE_URL . 'clients/list');
            exit;
        }

        // 2. Si le formulaire est soumis (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->clientModel->updateClient($id, $_POST);
            header('Location: ' . BASE_URL . 'clients/list');
            exit;
        }

        // 3. Afficher la vue
        require_once ROOT . '/views/clients/edit.php';
    }
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->clientModel->createClient($_POST)) {
                header('Location: ' . BASE_URL . 'clients/list');
                exit;
            }
        }

        require_once ROOT . '/views/clients/add.php';
    }
}