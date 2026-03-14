<?php require_once ROOT . '/views/layout/header.php'; ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1>Suivi des Ventes</h1>
            <p>Cliquez sur une ligne pour voir le détail.</p>
        </div>
        <a href="/dashboard-cafthe/public/orders/add" class="btn" style="background-color: #27ae60;">+ Nouvelle Vente Directe</a>
    </div>
    

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Client</th>
            <th>Vendeur</th>
            <th>Statut</th>
            <th>Montant TTC</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $o): ?>
                <tr class="clickable-row" onclick="window.location='/dashboard-cafthe/public/orders/view/<?= $o['id_commande'] ?>'">
                    <td><?= date('d/m/Y', strtotime($o['Date_commande'])) ?></td>
                    <td><?= htmlspecialchars($o['nom_prenom_client']) ?></td>
                    <td><?= htmlspecialchars($o['Nom_prenom_vendeur']) ?></td>
                    <td><span class="stock-badge badge-success"><?= htmlspecialchars($o['status_commande']) ?></span></td>
                    <td><strong><?= number_format($o['montant_ttc'], 2, ',', ' ') ?> €</strong></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Aucune vente enregistrée.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>