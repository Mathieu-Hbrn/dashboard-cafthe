<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CafThé - Intranet</title>
    <link rel="stylesheet" href="/dashboard-cafthe/public/css/style.css">
</head>
<body>
<header>
    <div class="logo"><strong>CafThé</strong> Intranet</div>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/dashboard-cafthe/public/dashboard">Dashboard</a>
            <a href="/dashboard-cafthe/public/products">Produits</a>
            <a href="/dashboard-cafthe/public/clients">Clients</a>
            <a href="/dashboard-cafthe/public/orders">Ventes</a>
            <a href="/dashboard-cafthe/public/profile">Mon Profil</a>
            <a href="/dashboard-cafthe/public/auth/logout" style="color:#e74c3c">Déconnexion</a>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                <li>
                    <a href="/dashboard-cafthe/public/vendeurs">
                        Gestion Personnel
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>
<div class="container">