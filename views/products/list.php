<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Gestion du Stock</h1>
        <a href="<?= BASE_URL ?>products/add" class="btn">+ Ajouter un produit</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Catégorie</th>
            <th>Prix (TTC)</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
            <?php
            $isLow = ($p['stock_produit'] <= 5);
            // Logique TVA : 20% Accessoires, sinon 5.5%
            $tva = ($p['id_categorie'] == 3) ? 1.20 : 1.055;
            $prixTTC = $p['prix_ht_produit'] * $tva;
            ?>
            <tr class="<?= $isLow ? 'stock-warning' : '' ?>">
                <td><?= htmlspecialchars($p['designation_produit'] ?? 'Sans nom') ?></td>
                <td><?= htmlspecialchars($p['type_categorie'] ?? 'Inconnue') ?></td>

                <td><?= number_format($prixTTC, 2, ',', ' ') ?> €</td>
                <td>
                    <span class="stock-badge <?= $isLow ? 'badge-danger' : 'badge-success' ?>">
                        <?= $p['stock_produit'] ?> en stock
                    </span>
                    <?= $isLow ? ' ⚠️' : '' ?>
                </td>
                <td><a href="<?= BASE_URL ?>products/edit/<?= $p['id_produit'] ?>" class="btn btn-warning">
                        Modifier
                    </a>
                    <a href="<?= BASE_URL ?>products/delete/<?= $p['id_produit'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                        Supprimer
                    </a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>