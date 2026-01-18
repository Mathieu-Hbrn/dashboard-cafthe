<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CafThé - Intranet Vendeur</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<h1>Gestion du Catalogue</h1>
<p><a href="/dashboard-cafthe/public/products/add">➕ Ajouter un produit</a></p>

<table border="1" width="100%">
    <thead>
    <tr>
        <th>Désignation</th>
        <th>Catégorie</th>
        <th>Prix HT</th>
        <th>Prix TTC</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['designation_produit']) ?></td>
                <td><?= htmlspecialchars($p['type_categorie']) ?></td>
                <td><?= number_format($p['prix_ht_produit'], 2, ',', ' ') ?> €</td>
                <td><strong><?= number_format($p['prix_ttc'], 2, ',', ' ') ?> €</strong></td>
                <td>
                    <?= $p['stock_produit'] ?>
                    <?php if ($p['stock_produit'] <= 5): ?>
                        <span style="color:red; font-weight:bold;">⚠️ Stock bas</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6" style="text-align:center;">Aucun produit trouvé dans le catalogue.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>