<?php
session_start();

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

$is_local = ($_SERVER['HTTP_HOST'] === 'localhost');
$base_url = $is_local ? '/dashboard-cafthe/public/' : '/';
define('BASE_URL', $base_url);

spl_autoload_register(function ($class) {
    $classPath = str_replace(['App\\', '\\'], ['', DIRECTORY_SEPARATOR], $class);
    $file = ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    $db = \App\Core\Database::getConnection();
} catch (\Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = $requestUri;
if (BASE_URL !== '/' && strpos($requestUri, BASE_URL) === 0) {
    $requestPath = substr($requestUri, strlen(BASE_URL));
}
$requestPath = explode('?', $requestPath)[0];
$requestPath = trim($requestPath, '/');
$url = explode('/', $requestPath);

if (empty($url[0]) || $requestPath === '' || $requestPath === '/') {
    $url = ['dashboard', 'index'];
}

// --- Dispatcher (MVC) ---
if ($url[0] === 'dashboard') {
    $controller = new \App\Controllers\DashboardController($db);
    $controller->index();
}
elseif ($url[0] === 'products') {
    $controller = new \App\Controllers\ProductController($db);
    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    } elseif (isset($url[1]) && $url[1] === 'delete' && isset($url[2])) {
        $controller->delete($url[2]);
    } elseif (isset($url[1]) && $url[1] === 'edit' && isset($url[2])) {
        $controller->edit($url[2]);
    }else {
        $controller->list();
    }
}
elseif ($url[0] === 'auth' || $url[0] === 'login') {
    $controller = new \App\Controllers\AuthController($db);

    if (isset($url[1]) && $url[1] === 'logout') {
        $controller->logout();
    }
    else {
        $controller->login();
    }
}
elseif ($url[0] === 'orders') {
    $controller = new \App\Controllers\OrderController($db);

    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    } elseif (isset($url[1]) && $url[1] === 'client' && isset($url[2])) {
        $controller->clientOrders($url[2]);
    }elseif (isset($url[1]) && $url[1] === 'updateStatus' && isset($url[2])) {
        $controller->updateStatus($url[2]);
    } elseif (isset($url[1]) && $url[1] === 'view' && isset($url[2])) {
        $controller->view($url[2]);
    } else {
        $controller->list();
    }
}
elseif ($url[0] === 'clients') {
    $controller = new \App\Controllers\ClientController($db);

    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    } elseif (isset($url[1]) && $url[1] === 'edit' && isset($url[2])) {
        $controller->edit($url[2]);
    } else {
        $controller->list();
    }
}
elseif ($url[0] === 'vendeurs') {
    $controller = new \App\Controllers\VendeurController($db);

    if (isset($url[1]) && $url[1] === 'edit' && isset($url[2])) {
        $controller->edit($url[2]);
    }
    if (isset($url[1]) && $url[1] === 'add') {
        $controller->add();
    }
    elseif (isset($url[1]) && $url[1] === 'delete' && isset($url[2])) {
        $controller->delete($url[2]);
    }
    else {
        $controller->list();
    }
}
elseif ($url[0] === 'profile') {
    $controller = new \App\Controllers\ProfileController($db);
    $controller->edit();
}
else {
    header("HTTP/1.0 404 Not Found");
    require_once ROOT . '/views/404.php'; // Optionnel : créer une jolie vue 404
}