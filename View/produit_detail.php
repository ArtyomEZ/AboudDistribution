<?php
session_start();

use Model\DAO\ProduitDAO;
use Model\BO\ProduitBO;
require_once('../Model/DAO/ProduitDAO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/BDDManager.php');

if (!isset($_GET['id'])) {
    echo "Produit non spécifié.";
    exit();
}

try {
    $a = initialiseConnexionBDD();
    $produitsDAO = new ProduitDAO($a);
    $produit = $produitsDAO->getProduitById($_GET['id']);

    if (!$produit) {
        echo "Produit introuvable.";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Erreur lors de la récupération du produit : " . $e->getMessage() . "</p>";
    exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if ($isAdmin) {
    include('headerAdmin.php');
} else {
    include('header.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit->getNomProd()); ?></title>
    <link rel="stylesheet" href="css/produit_detail.css">
</head>
<body>
<div class="product-detail-container">
    <img src="<?= htmlspecialchars($produit->getImgProd()); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">
    <div class="product-info">
        <h2><?= htmlspecialchars($produit->getNomProd()); ?></h2>
        <p class="product-brand"><?= htmlspecialchars($produit->getMarqProd()); ?></p>
        <p class="product-price"><?= number_format($produit->getPrixProd(), 2, ',', ' '); ?> €</p>
        <p class="product-description"><?= htmlspecialchars($produit->getDescProd()); ?></p>

        <!-- Bouton Ajouter au panier -->
        <a href="panier.php" class="buy-btn">🛒 Ajouter au panier</a>
    </div>
</div>
</body>
<footer>
    <?php include('footer.php'); ?>
</footer>
</html>
