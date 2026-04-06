<?php
namespace App\Controllers;

use App\Models\User;
use PDO;

class ProfileController {
    private $userModel;

    public function __construct(PDO $db) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        $this->userModel = new User($db);
    }

    public function edit() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Core\CSRF::validate();
            $oldPass = $_POST['old_password'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            $user = $this->userModel->findByEmail($_SESSION['user_email']);

            // 1. Vérification de la correspondance des nouveaux mots de passe
            if ($newPass !== $confirmPass) {
                $error = "Les nouveaux mots de passe ne correspondent pas.";
            }
            // 2. Vérification de l'ancien mot de passe avec password_verify
            // On ne compare plus avec !== mais avec la fonction de hachage
            elseif (!password_verify($oldPass, $user['Mdp_vendeur'])) {
                $error = "L'ancien mot de passe est incorrect.";
            }
            // 3. Si tout est bon, on hache et on met à jour
            else {
                // Hachage du nouveau mot de passe avec un coût de 10
                $hashedPassword = password_hash($newPass, PASSWORD_BCRYPT, ['cost' => 10]);

                if ($this->userModel->updatePassword($_SESSION['user_id'], $hashedPassword)) {
                    $_SESSION['flash_success'] = "Votre mot de passe a été modifié avec succès.";
                    header('Location: ' . BASE_URL . 'dashboard');
                    exit;
                } else {
                    $error = "Une erreur technique est survenue.";
                }
            }
        }

        require_once ROOT . '/views/profile/edit.php';
    }
}