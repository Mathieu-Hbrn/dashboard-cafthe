<?php require_once ROOT . '/views/layout/header.php'; ?>

    <h1>Répertoire Clients</h1>
    <p>Consultez la liste des clients fidèles de CafThé.</p>

    <table>
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
                    <td><strong><?= htmlspecialchars($c['nom_prenom_client']) ?></strong></td>
                    <td><?= htmlspecialchars($c['Telephone_client']) ?></td>
                    <td><?= htmlspecialchars($c['Mail_client']) ?></td>
                    <td><?= htmlspecialchars($c['adresse_client']) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['Date_inscription_client'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Aucun client enregistré.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>