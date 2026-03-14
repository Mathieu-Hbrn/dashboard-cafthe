<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div style="margin-bottom: 20px;">
        <a href="/dashboard-cafthe/public/products/list">⬅️ Retour au stock</a>
    </div>

    <div class="form-wrapper">
        <h2>Nouveau Produit</h2>

        <form action="/dashboard-cafthe/public/products/add" method="POST">
            <div class="form-group">
                <label>Désignation du produit</label>
                <input type="text" name="designation" placeholder="ex: Thé Vert Sencha" required>
            </div>

            <div class="form-group" style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Catégorie</label>
                    <select name="id_categorie" required>
                        <option value="1">Thé</option>
                        <option value="2">Café</option>
                        <option value="3">Accessoires</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label>Prix HT (€)</label>
                    <input type="number" step="0.01" name="prix_ht" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Stock initial</label>
                <input type="number" name="stock" value="0" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Informations complémentaires..."></textarea>
            </div>

            <div class="form-group">
                <label>Type de conditionnement</label>
                <input type="text" name="conditionnement" placeholder="ex: Sachet 100g, Boîte...">
            </div>

            <button type="submit" class="btn btn-block">Enregistrer le produit</button>
        </form>
    </div>

<?php require_once ROOT . '/views/layout/footer.php'; ?>