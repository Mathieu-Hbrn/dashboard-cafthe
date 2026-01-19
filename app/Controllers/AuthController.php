<?php
namespace App\Controllers;

use App\Models\User;
use PDO;

class AuthController {
    private $userModel;

    public function __construct(PDO $db) {
        $this->userModel = new User($db);
    }

    public function login() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            // Vérification (ici en clair car ton SQL est ainsi)
            if ($user && $password === $user['Mdp_vendeur']) {
                $_SESSION['user_id'] = $user['id_vendeur'];
                $_SESSION['user_nom'] = $user['Nom_prenom_vendeur'];
                $_SESSION['user_role'] = $user['role_vendeur'];

                header('Location: /dashboard-cafthe/public/products/list');
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        require_once ROOT . '/views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /dashboard-cafthe/public/auth/login');
        exit;
    }
}