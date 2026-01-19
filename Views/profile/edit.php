<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - CafThé</title>
</head>
<body>
<h1>Modifier mon mot de passe</h1>
<p><a href="/dashboard-cafthe/public/dashboard">🏠 Retour au Dashboard</a></p>

<?php if($message): ?> <p style="color:green"><?= $message ?></p> <?php endif; ?>
<?php if($error): ?> <p style="color:red"><?= $error ?></p> <?php endif; ?>

<form method="POST">
    <div>
        <label>Nouveau mot de passe :</label><br>
        <input type="password" name="new_password" required>
    </div><br>
    <div>
        <label>Confirmer le nouveau mot de passe :</label><br>
        <input type="password" name="confirm_password" required>
    </div><br>
    <button type="submit">Enregistrer les modifications</button>
</form>
</body>
</html>