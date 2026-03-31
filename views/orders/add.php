<?php require_once ROOT . '/views/layout/header.php'; ?>

    <div class="form-wrapper" style="max-width: 800px;">
        <h2>Nouvelle Vente Directe</h2>

        <form method="POST" id="order-form">
            <div class="form-group">
                <label for="id_client">Sélectionner le client :</label>
                <select name="id_client" id="id_client" required class="form-control">
                    <option value="">-- Choisir un client --</option>
                    <?php foreach ($clients as $c): ?>
                        <option value="<?= $c['id_client'] ?>">
                            <?= htmlspecialchars($c['nom_prenom_client']) ?> — [<?= htmlspecialchars($c['Mail_client']) ?>]
                        </option>
                    <?php endforeach; ?>
                </select>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h1>Répertoire Clients</h1>
                    <a href="<?= BASE_URL ?>clients/add"
                       style="background: #27ae60; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">
                        + Nouveau Client
                    </a>
                </div>
            </div>

            <hr>
            <h3>Produits</h3>
            <div id="product-list">
                <div class="product-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <select name="products[0][id]" class="product-select" style="flex: 2;" required onchange="calculateTotals()">
                        <option value="" data-price="0" data-category="0">Choisir un produit...</option>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p['id_produit'] ?>"
                                    data-price="<?= $p['prix_ht_produit'] ?>"
                                    data-category="<?= $p['id_categorie'] ?>">
                                <?= htmlspecialchars($p['designation_produit'] ?? $p['Nom_produit']) ?> (<?= number_format($p['prix_ht_produit'], 2) ?>€)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="products[0][quantity]" class="product-qty" placeholder="Qté" style="flex: 1;" min="1" value="1" required oninput="calculateTotals()">
                </div>
            </div>

            <button type="button" class="btn" onclick="addRow()" style="background: #34495e; margin-bottom: 20px;">+ Ajouter un article</button>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #ddd; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Total HT :</span>
                    <span id="display-ht">0,00 €</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.2em; font-weight: bold; color: #27ae60;">
                    <span>Total TTC :</span>
                    <span id="display-ttc">0,00 €</span>
                </div>
            </div>

            <button type="submit" class="btn btn-block" style="margin-top: 20px;">Finaliser la vente</button>
        </form>
    </div>

    <script>
        let rowCount = 1;

        // Fonction pour ajouter une ligne de produit
        function addRow() {
            const container = document.getElementById('product-list');
            const newRow = document.createElement('div');
            newRow.className = 'product-row';
            newRow.style = 'display: flex; gap: 10px; margin-bottom: 10px;';
            newRow.innerHTML = `
        <select name="products[${rowCount}][id]" class="product-select" style="flex: 2;" required onchange="calculateTotals()">
            <option value="" data-price="0" data-category="0">Choisir un produit...</option>
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id_produit'] ?>" data-price="<?= $p['prix_ht_produit'] ?>" data-category="<?= $p['id_categorie'] ?>">
                    <?= htmlspecialchars($p['designation_produit'] ?? $p['Nom_produit']) ?> (<?= number_format($p['prix_ht_produit'], 2) ?>€)
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="products[${rowCount}][quantity]" class="product-qty" placeholder="Qté" style="flex: 1;" min="1" value="1" required oninput="calculateTotals()">
    `;
            container.appendChild(newRow);
            rowCount++;
        }

        // Fonction de calcul en temps réel
        function calculateTotals() {
            let totalHT = 0;
            let totalTTC = 0;

            const rows = document.querySelectorAll('.product-row');

            rows.forEach(row => {
                const select = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.product-qty');

                const selectedOption = select.options[select.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const categoryId = parseInt(selectedOption.getAttribute('data-category')) || 0;
                const quantity = parseInt(qtyInput.value) || 0;

                const subtotalHT = price * quantity;
                totalHT += subtotalHT;

                // Logique de TVA : 20% si Accessoires (catégorie 3), sinon 5.5%
                const tvaRate = (categoryId === 3) ? 1.20 : 1.055;
                totalTTC += subtotalHT * tvaRate;
            });

            // Affichage formaté
            document.getElementById('display-ht').innerText = totalHT.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + " €";
            document.getElementById('display-ttc').innerText = totalTTC.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + " €";
        }
    </script>

<?php require_once ROOT . '/views/layout/footer.php'; ?>