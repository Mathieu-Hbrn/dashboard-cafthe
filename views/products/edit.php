<?php require_once ROOT . '/views/layout/header.php'; ?>

<div class="edit-container">
    <h1>Modifier le produit : <?= $product['designation_produit'] ?></h1>

    <form method="POST" class="edit-form">
        <label>Nom du produit :</label>
        <input type="text" name="designation_produit" value="<?= $product['designation_produit'] ?>" required>

        <label>Prix HT :</label>
        <input type="number" step="0.01" name="prix_ht_produit" value="<?= $product['prix_ht_produit'] ?>" required>

        <label>Stock :</label>
        <input type="number" name="stock_produit" value="<?= $product['stock_produit'] ?>" required>

        <label>Catégorie (1: Thé, 2: Café, 3: Accessoires) :</label>
        <input type="number" name="id_categorie" value="<?= $product['id_categorie'] ?>" required>

        <button type="submit">Enregistrer les modifications</button>
        <a href="<?= BASE_URL ?>products/list" class="btn-back">Retour à la liste</a>
    </form>
</div>