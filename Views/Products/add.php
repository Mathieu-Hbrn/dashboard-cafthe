<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit - CafThé</title>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<h1>Ajouter un nouveau produit</h1>
<p><a href="/dashboard-cafthe/public/products/list">← Retour à la liste</a></p>

<form method="POST">
    <label>Désignation :</label><br>
    <input type="text" name="designation" required><br><br>

    <label>Catégorie :</label><br>
    <select name="id_categorie" required>
        <option value="1">Thé (TVA 5.5%)</option>
        <option value="2">Café (TVA 5.5%)</option>
        <option value="3">Accessoires (TVA 20%)</option>
    </select><br><br>

    <label>Prix HT :</label><br>
    <input type="number" step="0.01" name="prix_ht" required><br><br>

    <label>Stock initial :</label><br>
    <input type="number" name="stock" required><br><br>

    <label>Conditionnement :</label><br>
    <input type="text" name="conditionnement" placeholder="ex: Boîte de 100g" required><br><br>

    <label>Description :</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Enregistrer le produit</button>
</form>
</body>