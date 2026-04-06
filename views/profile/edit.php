<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="form-container">
        <h2 class="text-center">Sécurité du compte</h2>

        <?php if($error): ?> <div class="alert alert-danger" style="color:red"><?= $error ?></div> <?php endif; ?>

        <form method="POST">
    <?= \App\Core\CSRF::csrfField() ?>
            <div class="form-group">
                <label>Ancien mot de passe</label>
                <input type="password" name="old_password" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label>Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Mettre à jour</button>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>
