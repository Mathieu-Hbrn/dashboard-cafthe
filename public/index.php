<?php
session_start();

// --- Racine du projet ---
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

// --- Autoloader ---
spl_autoload_register(function ($class) {
    $classPath = str_replace(['App\\', '\\'], ['', DIRECTORY_SEPARATOR], $class);
    $file = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// --- Connexion BDD ---
try {
    $db = \App\Core\Database::getConnection();
} catch (\Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// --- Analyse de l'URL ---
$urlParam = $_GET['url'] ?? '';
$url = explode('/', filter_var(rtrim($urlParam, '/'), FILTER_SANITIZE_URL));

if (empty($url[0])) {
    $url = ['products', 'list'];
}

// --- Routeur (MVC) ---
if ($url[0] === 'products') {
    $controller = new \App\Controllers\ProductController($db);
    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    } else {
        $controller->list();
    }
}
elseif ($url[0] === 'auth') {
    $controller = new \App\Controllers\AuthController($db);
    if (isset($url[1]) && $url[1] === 'logout') {
        $controller->logout();
    } else {
        $controller->login();
    }
}
elseif ($url[0] === 'orders') {
    $controller = new \App\Controllers\OrderController($db);
    $controller->list();
}
elseif ($url[0] === 'clients') {
    $controller = new \App\Controllers\ClientController($db);
    $controller->list();
}
elseif ($url[0] === 'dashboard') {
    $controller = new \App\Controllers\DashboardController($db);
    $controller->index();
}
elseif ($url[0] === 'profile') {
    $controller = new \App\Controllers\ProfileController($db);
    $controller->edit();
}
else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - Page non trouvée</h1>";
}