<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - CafThé</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body style="background-color: #f0f2f5; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;">

<div class="form-wrapper" style="width: 100%; max-width: 400px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="color: #27ae60; margin: 0;">CafThé</h1>
        <p style="color: #7f8c8d;">Intranet de gestion</p>
    </div>

    <?php if(!empty($error)): ?>
        <div class="alert" style="background: #fdeaea; color: #c0392b; border: 1px solid #f5c6cb; margin-bottom: 15px; padding: 10px; border-radius: 4px;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Adresse Email</label>
            <input type="email" name="email" placeholder="vendeur@cafthe.fr" required autofocus>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-block">Se connecter</button>
    </form>
</div>

</body>
</html>