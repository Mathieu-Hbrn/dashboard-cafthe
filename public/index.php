<?php
// On définit la racine du projet
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

// L'AUTOLOADER : Pour charger automatiquement tes classes App\Core, App\Models, etc.
spl_autoload_register(function ($class) {
    $classPath = str_replace('App\\', '', $class);
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
    $file = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $classPath . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Connexion à la base de données
try {
    $db = \App\Core\Database::getConnection();
} catch (\Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération de l'URL pour le routage
$urlParam = isset($_GET['url']) ? $_GET['url'] : '';
$url = explode('/', filter_var(rtrim($urlParam, '/'), FILTER_SANITIZE_URL));

// Page par défaut si l'URL est vide
if (empty($url[0])) {
    $url = ['products', 'list'];
}

if ($url[0] === 'auth') {
    $controller = new \App\Controllers\AuthController($db);

    if (isset($url[1]) && $url[1] === 'logout') {
        $controller->logout();
    } else {
        $controller->login();
    }
}

// ROUTAGE : Envoi vers le bon contrôleur
if ($url[0] === 'products') {
    $controller = new \App\Controllers\ProductController($db);

    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    } else {
        $controller->list();
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - Page non trouvée</h1>";
}