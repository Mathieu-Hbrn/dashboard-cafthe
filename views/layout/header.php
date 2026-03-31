<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CafThé - Intranet</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
<header>
    <div class="logo"><strong>CafThé</strong> Intranet</div>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>">Accueil</a>
            <a href="<?= BASE_URL ?>products">Produits</a>
            <a href="<?= BASE_URL ?>clients">Clients</a>
            <a href="<?= BASE_URL ?>orders">Ventes</a>
            <a href="<?= BASE_URL ?>profile">Mon Profil</a>
            <a href="<?= BASE_URL ?>auth/logout" style="color:#e74c3c">Déconnexion</a>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                <li>
                    <a href="<?= BASE_URL ?>vendeurs">
                        Gestion Personnel
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</header>
<div class="container">