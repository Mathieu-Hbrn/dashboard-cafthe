<?php
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase {

    public function testAddition() {
        $resultat = 10 + 10;
        // On vérifie que 10 + 10 fait bien 20
        $this->assertEquals(20, $resultat);
    }

    public function testFichierViewsExiste() {
        // On vérifie que votre dossier views est bien là où il faut
        $path = 'c:/xampp/htdocs/dashboard-cafthe/views';
        $this->assertDirectoryExists($path);
    }
}