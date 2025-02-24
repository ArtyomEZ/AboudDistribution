<?php
require_once '../Model/BDDManager.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

use Model\BO\ProduitBO;

session_start();

// Vérifie si la session contient des résultats
$resultats = $_SESSION['resultats'] ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche - Boutique Automobile</title>
    <link rel="stylesheet" href="css/produits.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="container1">
    <h2>Résultats pour : <?= htmlspecialchars($_SESSION['searchTerm'] ?? ''); ?></h2>

    <div class="product-container">
        <?php if (!empty($resultats)): ?>
            <?php
            $count = 0;
            echo '<div class="product-row">'; // Début de la ligne
            foreach ($resultats as $produit):
                ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($produit->getImgProd()); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">
                    <div class="rating">⭐⭐⭐⭐⭐</div>
                    <h3><?= htmlspecialchars($produit->getNomProd()); ?></h3>
                    <p class="product-price"><?= number_format($produit->getPrixProd(), 2, ',', ' '); ?> €</p>
                    <div class="button-container">
                        <button class="buy-btn">🛒 Ajouter au panier</button>
                    </div>
                </div>
                <?php
                $count++;
                if ($count % 3 == 0) {
                    echo '</div><div class="product-row">'; // Nouvelle ligne après chaque 3 produits
                }
            endforeach;
            echo '</div>'; // Fermer la dernière ligne
            ?>
        <?php else: ?>
            <p>Aucun produit trouvé pour cette recherche.</p>
        <?php endif; ?>
    </div>
</div>


</body>
<footer>
    <?php
    include ('footer.php');
    ?>
</footer>
</html>
