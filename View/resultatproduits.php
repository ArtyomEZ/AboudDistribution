<?php
require_once '../Model/BDDManager.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

use Model\BO\ProduitBO;

// Start the session to access session data
session_start();

// Ensure 'resultats' exists in the session
if (isset($_SESSION['resultats']) && !empty($_SESSION['resultats'])) {
    $resultats = $_SESSION['resultats'];
} else {
    $resultats = [];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche - Boutique Automobile</title>
    <link rel="stylesheet" href="css/produits.css"> <!-- Lien vers le CSS -->
</head>
<body>

<?php include('header.php'); ?>

<div class="container1">
    <h2>Résultats pour : <?= htmlspecialchars($_SESSION['searchTerm'] ?? ''); ?></h2>

    <div class="product-grid">
        <?php if (!empty($resultats)): ?>
            <?php foreach ($resultats as $produit): ?>
                <div class="product-card">
                    <img src="<?= $produit->getImgProd(); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">
                    <div class="rating">⭐⭐⭐⭐⭐</div>
                    <h3><?= htmlspecialchars($produit->getNomProd()); ?></h3>
                    <p class="product-price"><?= htmlspecialchars($produit->getPrixProd()); ?> €</p>
                    <div class="button-container">
                        <button class="buy-btn">🛒 Ajouter au panier</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit trouvé pour cette recherche.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
