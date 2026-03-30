<?php require_once ROOT . '/views/layout/header.php'; ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1>Suivi des Ventes</h1>
            <p>Cliquez sur une ligne pour voir le détail.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <form method="GET" action="/dashboard-cafthe/public/orders" style="background: #eee; padding: 10px; border-radius: 5px;">
                <input type="hidden" name="url" value="orders"> <select name="status" onchange="this.form.submit()" style="padding: 5px;">
                    <option value="">Tous les statuts</option>
                    <option value="En préparation" <?= ($_GET['status'] ?? '') == 'En préparation' ? 'selected' : '' ?>>En préparation</option>
                    <option value="En cours" <?= ($_GET['status'] ?? '') == 'En cours' ? 'selected' : '' ?>>En cours</option>
                    <option value="Livrée" <?= ($_GET['status'] ?? '') == 'Livrée' ? 'selected' : '' ?>>Livrée</option>
                </select>
            </form>

            <a href="/dashboard-cafthe/public/orders/add" class="btn" style="background-color: #27ae60;">+ Nouvelle Vente Directe</a>
        </div>
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
                <tr class="clickable-row"
                    style="cursor: pointer;"
                    onclick="window.location='/dashboard-cafthe/public/orders/view/<?= $o['id_commande'] ?>'">

                    <td><?= date('d/m/Y', strtotime($o['Date_commande'])) ?></td>
                    <td><?= htmlspecialchars($o['nom_prenom_client']) ?></td>
                    <td><?= htmlspecialchars($o['Nom_prenom_vendeur']) ?></td>

                    <td onclick="event.stopPropagation();">
                        <form action="/dashboard-cafthe/public/orders/updateStatus/<?= $o['id_commande'] ?>" method="POST">
                            <select name="status" onchange="this.form.submit()" class="status-dropdown">
                                <option value="En préparation" <?= $o['status_commande'] == 'En préparation' ? 'selected' : '' ?>>En préparation</option>
                                <option value="En cours" <?= $o['status_commande'] == 'En cours' ? 'selected' : '' ?>>En cours</option>
                                <option value="Livrée" <?= $o['status_commande'] == 'Livrée' ? 'selected' : '' ?>>Livrée</option>
                            </select>
                        </form>
                    </td>

                    <td><strong><?= number_format($o['montant_ttc'], 2, ',', ' ') ?> €</strong></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Aucune vente enregistrée.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>