<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CafThé</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        .stats { display: flex; gap: 20px; margin: 20px 0; }
        .card { border: 1px solid #ddd; padding: 20px; flex: 1; text-align: center; border-radius: 5px; background: #fdfdfd; }
        .card h3 { margin: 0; font-size: 0.9em; color: #555; }
        .card p { font-size: 1.5em; font-weight: bold; margin: 10px 0 0; color: #2c3e50; }
    </style>
</head>
<body>
<h1>Tableau de Bord</h1>
<p>Bonjour, <?= htmlspecialchars($_SESSION['user_nom']) ?> ! | <a href="/dashboard-cafthe/public/auth/logout">Déconnexion</a></p>

<nav>
    <a href="/dashboard-cafthe/public/products/list">📦 Produits</a> |
    <a href="/dashboard-cafthe/public/clients/list">👥 Clients</a> |
    <a href="/dashboard-cafthe/public/orders/list">🛒 Ventes</a>
</nav>

<div class="stats">
    <?php
    /**
     * @var int $nbProducts Nombre total de produits
     * @var int $nbClients Nombre total de clients
     * @var float $totalSales Chiffre d'affaires total
     * @var array $recentOrders Liste des dernières commandes
     */
    ?>
    <div class="card">
        <h3>Produits au catalogue</h3>
        <p><?= $nbProducts ?></p>
    </div>
    <div class="card">
        <h3>Clients enregistrés</h3>
        <p><?= $nbClients ?></p>
    </div>
    <div class="card">
        <h3>Chiffre d'Affaires total</h3>
        <p><?= number_format($totalSales, 2, ',', ' ') ?> €</p>
    </div>
</div>

<h2>Activités Récentes</h2>
<table border="1" width="100%">
    <thead>
    <tr>
        <th>Date</th>
        <th>Client</th>
        <th>Montant TTC</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($recentOrders)): ?>
        <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($order['Date_commande'])) ?></td>
                <td><?= htmlspecialchars($order['nom_prenom_client']) ?></td>
                <td><?= number_format($order['montant_ttc'], 2, ',', ' ') ?> €</td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="3" style="text-align:center;">Aucune donnée disponible.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>