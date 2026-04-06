<?php
use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase {

    /**
     * Vérifie que la page d'accueil du dashboard répond bien
     */
    public function testDashboardPageIsAccessible() {
        $url = "http://localhost/dashboard-cafthe/public/auth/login";

        // On utilise get_headers pour vérifier le statut de la page
        $headers = @get_headers($url);

        // On vérifie que le serveur répond "200 OK"
        $this->assertStringContainsString('200', $headers[0], "La page d'accueil est inaccessible (Erreur 404 ou 500)");
    }

    /**
     * Vérifie que la liste des commandes existe
     */
    public function testOrdersListPageExists() {
        $file = 'c:/xampp/htdocs/dashboard-cafthe/views/orders/list.php';

        $this->assertFileExists($file, "Le fichier list.php est manquant !");
    }
}