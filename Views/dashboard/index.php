<?php require_once ROOT . '/views/layout/header.php'; ?>

    <h1>Tableau de Bord</h1>
    <p>Bienvenue, <strong><?= htmlspecialchars($_SESSION['user_nom']) ?></strong></p>

<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
<?php endif; ?>

    <div class="stats">
        <div class="card"><h3>Produits</h3><p><?= $nbProducts ?></p></div>
        <div class="card"><h3>Clients</h3><p><?= $nbClients ?></p></div>
        <div class="card"><h3>Chiffre d'Affaires</h3><p><?= number_format($totalSales, 2, ',', ' ') ?> €</p></div>
    </div>

    <h2>Dernières Ventes</h2>
    <table>
        <thead>
        <tr><th>Date</th><th>Client</th><th>Montant TTC</th></tr>
        </thead>
        <tbody>
        <?php foreach ($recentOrders as $order): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($order['Date_commande'])) ?></td>
                <td><?= htmlspecialchars($order['nom_prenom_client']) ?></td>
                <td><?= number_format($order['montant_ttc'], 2, ',', ' ') ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>