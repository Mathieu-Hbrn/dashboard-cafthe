<?php require_once ROOT . '/views/layout/header.php'; ?>

<div class="dashboard-grid">
    <?php if (!empty($low_stock)): ?>
        <div class="card alert-card">
            <h3>⚠️ Alertes Stock Bas</h3>
            <ul>
                <?php foreach ($low_stock as $item): ?>
                    <li><strong><?= $item['designation_produit'] ?></strong> : seulement <?= $item['stock_produit'] ?> restants !</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="stats-row">
        <div class="stat-box">
            <span>CA Aujourd'hui</span>
            <p><?= number_format($rev_today, 2) ?> €</p>
        </div>
        <div class="stat-box">
            <span>CA du Mois</span>
            <p><?= number_format($rev_month, 2) ?> €</p>
        </div>
    </div>

    <div class="card">
        <h3>🏆 Top 5 Produits</h3>
        <table>
            <?php foreach ($top_products as $p): ?>
                <tr>
                    <td><?= $p['designation_produit'] ?></td>
                    <td><strong><?= $p['total_vendu'] ?></strong> ventes</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>