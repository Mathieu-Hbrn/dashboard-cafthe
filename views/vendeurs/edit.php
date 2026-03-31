<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="edit-container">
        <h1>Modifier le membre : <?= htmlspecialchars($vendeur['Nom_prenom_vendeur']) ?></h1>

        <form method="POST" class="edit-form">
            <label>Nom et Prénom :</label>
            <input type="text" name="Nom_prenom_vendeur" value="<?= htmlspecialchars($vendeur['Nom_prenom_vendeur']) ?>" required>

            <label>Email professionnel :</label>
            <input type="email" name="mail_vendeur" value="<?= htmlspecialchars($vendeur['mail_vendeur']) ?>" required>

            <label>Téléphone :</label>
            <input type="text" name="Telephone_vendeur" value="<?= htmlspecialchars($vendeur['Telephone_vendeur']) ?>">

            <label>Rôle au sein de CafThé :</label>
            <select name="role_vendeur" style="padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-size: 1rem;">
                <option value="Vendeur" <?= $vendeur['role_vendeur'] === 'Vendeur' ? 'selected' : '' ?>>Vendeur</option>
                <option value="Admin" <?= $vendeur['role_vendeur'] === 'Admin' ? 'selected' : '' ?>>Administrateur</option>
            </select>

            <button type="submit">Enregistrer les modifications</button>
            <a href="<?= BASE_URL ?>vendeurs" class="btn-back">Annuler</a>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>