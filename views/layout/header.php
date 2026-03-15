<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CafThé - Intranet</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <div class="logo"><strong>CafThé</strong> Intranet</div>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/dashboard-cafthe/public/dashboard">Dashboard</a>
            <a href="/dashboard-cafthe/public/products/list">Produits</a>
            <a href="/dashboard-cafthe/public/clients/list">Clients</a>
            <a href="/dashboard-cafthe/public/orders">Ventes</a>
            <a href="/dashboard-cafthe/public/profile">Mon Profil</a>
            <a href="/dashboard-cafthe/public/auth/logout" style="color:#e74c3c">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">