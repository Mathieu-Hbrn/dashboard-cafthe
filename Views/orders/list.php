<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes - CafThé</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<h1>Suivi des Ventes</h1>
<p><a href="/dashboard-cafthe/public/products/list">📦 Voir les produits</a> |
    <a href="/dashboard-cafthe/public/auth/logout">Déconnexion</a></p>

<table border="1" width="100%">
    <thead>
    <tr>
        <th>Date</th>
        <th>Client</th>
        <th>Vendeur</th>
        <th>Statut</th>
        <th>Montant HT</th>
        <th>Montant TTC</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($o['Date_commande'])) ?></td>
                <td><?= htmlspecialchars($o['nom_prenom_client']) ?></td>
                <td><?= htmlspecialchars($o['Nom_prenom_vendeur']) ?></td>
                <td><?= htmlspecialchars($o['status_commande']) ?></td>
                <td><?= number_format($o['Montant_ht'], 2, ',', ' ') ?> €</td>
                <td><strong><?= number_format($o['montant_ttc'], 2, ',', ' ') ?> €</strong></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">Aucune commande trouvée.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>