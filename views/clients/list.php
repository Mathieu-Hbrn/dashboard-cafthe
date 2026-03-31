<?php require_once ROOT . '/views/layout/header.php'; ?>

    <h1>Répertoire Clients</h1>
    <p>Consultez la liste des clients fidèles de CafThé.</p>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Répertoire Clients</h1>
        <a href="<?= BASE_URL ?>clients/add"
           style="background: #27ae60; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">
            + Nouveau Client
        </a>
    </div>
    <div class="search-container">
        <form action="<?= BASE_URL ?>clients/list" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Rechercher un client (nom, email...)" value="<?= $_GET['search'] ?? '' ?>">
            <button type="submit"
                    class="btn btn-warning">
                Rechercher
            </button>
            <?php if(isset($_GET['search'])): ?>
                <a href="<?= BASE_URL ?>clients/list" class="btn-clear">Effacer</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <thead>
        <tr>
            <th>Nom & Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Date d'inscription</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($clients)): ?>
            <?php foreach ($clients as $c): ?>
                <tr class="clickable-row" onclick="window.location='<?= BASE_URL ?>orders/client/<?= $c['id_client'] ?>'">
                    <td><strong><?= htmlspecialchars($c['nom_prenom_client']) ?></strong></td>
                    <td><?= htmlspecialchars($c['Telephone_client']) ?></td>
                    <td><?= htmlspecialchars($c['Mail_client']) ?></td>
                    <td><?= htmlspecialchars($c['adresse_client']) ?></td>
                    <td><?= date('d/m/Y', strtotime($c['Date_inscription_client'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>clients/edit/<?= $c['id_client'] ?>" onclick="event.stopPropagation();">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Aucun client enregistré.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

<?php require_once ROOT . '/views/layout/footer.php'; ?>