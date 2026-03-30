<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="edit-container">
        <h1>Ajouter un nouveau membre</h1>
        <p>Créez un compte pour un nouvel administrateur ou vendeur.</p>

        <form method="POST" class="edit-form">
            <label>Nom et Prénom :</label>
            <input type="text" name="Nom_prenom_vendeur" placeholder="Ex: Jean Dupont" required>

            <label>Email professionnel :</label>
            <input type="email" name="mail_vendeur" placeholder="jean.dupont@caf-the.com" required>

            <label>Téléphone :</label>
            <input type="text" name="Telephone_vendeur">

            <label>Rôle :</label>
            <select name="role_vendeur">
                <option value="Vendeur">Vendeur</option>
                <option value="Admin">Administrateur</option>
            </select>

            <label>Mot de passe provisoire :</label>
            <input type="password" name="Mdp_vendeur" required>
            <small style="color: #7f8c8d;">Le vendeur pourra le modifier plus tard.</small>

            <button type="submit">Créer le compte</button>
            <a href="/dashboard-cafthe/public/vendeurs" class="btn-back">Annuler</a>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>