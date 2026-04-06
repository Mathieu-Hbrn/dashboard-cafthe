<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="edit-container">
        <h1>Modifier le client : <?= htmlspecialchars($client['nom_prenom_client']) ?></h1>

        <form method="POST" class="edit-form">
    <?= \App\Core\CSRF::csrfField() ?>
            <label>Nom et Prénom :</label>
            <input type="text" name="nom_prenom_client" value="<?= $client['nom_prenom_client'] ?>" required>

            <label>Email :</label>
            <input type="email" name="Mail_client" value="<?= $client['Mail_client'] ?>" required>

            <label>Téléphone :</label>
            <input type="text" name="Telephone_client" value="<?= $client['Telephone_client'] ?>">

            <label>Adresse :</label>
            <textarea name="adresse_client" rows="3" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"><?= $client['adresse_client'] ?></textarea>

            <button type="submit">Enregistrer les modifications</button>
            <a href="<?= BASE_URL ?>clients/list" class="btn-back">Annuler et retourner à la liste</a>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
