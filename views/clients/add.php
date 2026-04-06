<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="edit-container">
        <h1>Ajouter un nouveau client</h1>
        <p>Remplissez les informations pour créer la fiche client.</p>

        <form method="POST" class="edit-form">
    <?= \App\Core\CSRF::csrfField() ?>
            <label>Nom et Prénom :</label>
            <input type="text" name="nom_prenom_client" placeholder="Ex: Alice Martin" required>

            <label>Email :</label>
            <input type="email" name="Mail_client" placeholder="alice@exemple.com" required>

            <label>Téléphone :</label>
            <input type="text" name="Telephone_client" placeholder="06 00 00 00 00">

            <label>Adresse complète :</label>
            <textarea name="adresse_client" rows="3" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>

            <label>Mot de passe (pour son espace client) :</label>
            <input type="password" name="mdp_client" required>

            <button type="submit">Créer le client</button>
            <a href="<?= BASE_URL ?>clients/list" class="btn-back">Annuler</a>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
