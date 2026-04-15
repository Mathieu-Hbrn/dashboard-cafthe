<?php
namespace App\Core;
class CSRF {
    /**
     * Génèration d'un nouveau token CSRF et stockage en session.
     */
    public static function generateToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['csrf_token'])) {
            try {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (\Exception $e) {
                // Fallback de sécurité si random_bytes échoue
                $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }
        return $_SESSION['csrf_token'];
    }
    /**
     * Validation du token CSRF avec celui de la session
     * sinon die()
     */
    public static function validate() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_POST['csrf_token'] ?? '';
        
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            die("Jeton CSRF invalide ou expiré. Veuillez retourner en arrière et rafraîchir la page.");
        }
    }
    /**
     * Retourne le code HTML de l'input hidden contenant le token CSRF.
     */
    public static function csrfField() {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
