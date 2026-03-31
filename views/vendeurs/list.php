<?php require_once ROOT . '/views/layout/header.php'; ?>

    <h1>Gestion du Personnel</h1>
    <p>Liste des membres de l'entreprise.</p>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="<?= BASE_URL ?>vendeurs/add"
           style="background: #27ae60; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">
            + Ajouter un membre
        </a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Rôle</th>
            <th>Nom & Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($personnel as $p): ?>
            <tr>
                <td>
                    <span class="badge <?= $p['role_vendeur'] === 'Admin' ? 'badge-admin' : 'badge-vendeur' ?>">
                        <?= htmlspecialchars($p['role_vendeur']) ?>
                    </span>
                </td>
                <td><strong><?= htmlspecialchars($p['Nom_prenom_vendeur']) ?></strong></td>
                <td><?= htmlspecialchars($p['mail_vendeur']) ?></td>
                <td><?= htmlspecialchars($p['Telephone_vendeur']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>vendeurs/edit/<?= $p['id_vendeur'] ?>">Modifier</a>
                    <a href="<?= BASE_URL ?>vendeurs/delete/<?= $p['id_vendeur'] ?>"
                       style="color: #e74c3c; margin-left: 10px;"
                       onclick="return confirm('Êtes-vous sûr ? Cette action est irréversible.');">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>