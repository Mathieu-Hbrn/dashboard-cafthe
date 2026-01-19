<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Clients - CafThé</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<h1>Répertoire Clients</h1>
<p>
    <a href="/dashboard-cafthe/public/products/list">📦 Produits</a> |
    <a href="/dashboard-cafthe/public/orders/list">🛒 Ventes</a> |
    <a href="/dashboard-cafthe/public/auth/logout">Déconnexion</a>
</p>

<table border="1" width="100%">
    <thead>
    <tr>
        <th>Nom & Prénom</th>
        <th>Téléphone</th>
        <th>Email</th>
        <th>Adresse</th>
        <th>Date d'inscription</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($clients)): ?>
        <?php foreach ($clients as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nom_prenom_client']) ?></td>
                <td><?= htmlspecialchars($c['Telephone_client']) ?></td>
                <td><?= htmlspecialchars($c['Mail_client']) ?></td>
                <td><?= htmlspecialchars($c['adresse_client']) ?></td>
                <td><?= date('d/m/Y', strtotime($c['Date_inscription_client'])) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">Aucun client enregistré.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>