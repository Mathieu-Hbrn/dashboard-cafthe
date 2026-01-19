<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - CafThé</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<h1>Intranet CafThé</h1>
<?php if(!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>
</body>
</html>