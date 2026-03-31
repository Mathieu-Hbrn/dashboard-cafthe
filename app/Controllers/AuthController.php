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
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['Mdp_vendeur'])) {
                $_SESSION['user_id'] = $user['id_vendeur'];
                $_SESSION['user_nom'] = $user['Nom_prenom_vendeur'];
                $_SESSION['user_role'] = $user['role_vendeur'];
                $_SESSION['user_email'] = $user['mail_vendeur'];

                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        require_once ROOT . '/views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}