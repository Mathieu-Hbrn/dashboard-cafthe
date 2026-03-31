<?php require_once ROOT . '/views/layout/header.php'; ?>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix Unitaire HT</th>
            <th>Total HT</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <?php
            $qte = $item['QuantiteProduitLigne'] ?? 0;
            $prix = $item['PrixUnitLigne'] ?? 0;
            $totalLigne = $qte * $prix;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['designation_produit'] ?? 'Produit inconnu') ?></td>
                <td><?= $qte ?></td>
                <td><?= number_format($prix, 2, ',', ' ') ?> €</td>
                <td><?= number_format($totalLigne, 2, ',', ' ') ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <a href="<?= BASE_URL ?>orders/list" class="btn-back">Retour à la liste</a>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>