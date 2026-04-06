<?php
namespace App\Controllers;

use App\Models\Vendeur;
use PDO;

class VendeurController {
    private $vendeurModel;

    public function __construct(PDO $db) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
            header('Location: ' . BASE_URL . 'dashboard/index');
            exit;
        }

        $this->vendeurModel = new \App\Models\Vendeur($db);
    }

    public function list() {
        $personnel = $this->vendeurModel->getAllPersonnel();
        require_once ROOT . '/views/vendeurs/list.php';
    }

    public function edit($id) {
        $vendeur = $this->vendeurModel->getVendeurById($id);

        if (!$vendeur) {
            header('Location: ' . BASE_URL . 'vendeurs');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Core\CSRF::validate();
            // Optionnel : On pourrait ajouter une vérification ici pour empêcher
            // un admin de se retirer ses propres droits par erreur.
            $this->vendeurModel->updateVendeur($id, $_POST);
            header('Location: ' . BASE_URL . 'vendeurs');
            exit;
        }

        require_once ROOT . '/views/vendeurs/edit.php';
    }

    public function delete($id) {
        // SÉCURITÉ : On empêche l'admin connecté de supprimer son propre compte
        if ($id == $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . 'vendeurs?error=self_delete');
            exit;
        }

        $this->vendeurModel->deleteVendeur($id);
        header('Location: ' . BASE_URL . 'vendeurs?success=deleted');
        exit;
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Core\CSRF::validate();
            // On pourrait ajouter une vérification si l'email existe déjà ici
            $this->vendeurModel->createVendeur($_POST);
            header('Location: ' . BASE_URL . 'vendeurs');
            exit;
        }

        require_once ROOT . '/views/vendeurs/add.php';
    }
}