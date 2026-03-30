<?php require_once ROOT . '/views/layout/header.php'; ?>

<div class="container">
    <h1>Commandes de <?= htmlspecialchars($client['nom_prenom_client']) ?></h1>

    <table class="order-table">
        <thead>
        <tr>
            <th>N° Commande</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Montant TTC</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td>#<?= $o['id_commande'] ?></td>
                    <td><?= date('d/m/Y', strtotime($o['Date_commande'])) ?></td>
                    <td>
                            <span class="badge-status">
                                <?= htmlspecialchars($o['status_commande']) ?>
                            </span>
                    </td>
                    <td style="font-weight: bold;">
                        <?= number_format($o['montant_ttc'], 2, ',', ' ') ?> €
                    </td>
                    <td>
                        <a href="/dashboard-cafthe/public/orders/view/<?= $o['id_commande'] ?>">Détails</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Aucune commande pour ce client.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="/dashboard-cafthe/public/clients/list" class="btn-back">← Retour aux clients</a>
</div>