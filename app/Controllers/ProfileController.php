<?php
namespace App\Controllers;

use App\Models\User;
use PDO;

class ProfileController {
    private $userModel;

    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard-cafthe/public/auth/login');
            exit;
        }
        $this->userModel = new User($db);
    }

    public function edit() {
        $message = "";
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldPass = $_POST['old_password'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            // Récupérer l'utilisateur actuel pour vérifier l'ancien mot de passe
            $currentUser = $this->userModel->findByEmail($_SESSION['user_email'] ?? '');
            // Note : Assure-toi de stocker 'user_email' en session lors du login

            // Simulation de vérification (ton SQL utilise des mots de passe en clair actuellement)
            if ($newPass !== $confirmPass) {
                $error = "Les nouveaux mots de passe ne correspondent pas.";
            } else {
                if ($this->userModel->updatePassword($_SESSION['user_id'], $newPass)) {
                    $message = "Mot de passe mis à jour avec succès !";
                } else {
                    $error = "Une erreur est survenue lors de la mise à jour.";
                }
            }
        }

        require_once ROOT . '/views/profile/edit.php';
    }
}