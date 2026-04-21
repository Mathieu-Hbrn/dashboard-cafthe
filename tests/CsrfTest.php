<?php
use PHPUnit\Framework\TestCase;
use App\Core\CSRF;
require_once __DIR__ . '/../app/Core/CSRF.php';

class CsrfTest extends TestCase {
    protected function setUp(): void {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
    }

    /**
     * Teste si le champ HTML est bien généré
     */
    public function testCsrfFieldReturnsHtmlInput() {
        $html = CSRF::csrfField();

        // On vérifie que le résultat contient bien "<input type="hidden""
        $this->assertStringContainsString('<input type="hidden"', $html);
        $this->assertStringContainsString('name="csrf_token"', $html);
    }

    /**
     * Teste si un token est bien généré et n'est pas vide
     */
    public function testTokenIsGenerated() {
        $token = CSRF::generateToken();

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }
}