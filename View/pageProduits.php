<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


use Model\DAO\ProduitDAO;

require_once('../Model/DAO/ProduitDAO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/BDDManager.php');
require_once('../Model/BO/TypeProduitBO.php');
// Connexion à la base de données
try {
    $a = initialiseConnexionBDD();
    // Création de l'objet DAO
    $produitsDAO = new ProduitDAO($a);

    // Récupération des produits depuis la base de données
    $produits = $produitsDAO->getAllProduits();

} catch (PDOException $e) {
    echo "<p>Erreur lors de la connexion à la base de données : " . $e->getMessage() . "</p>";
}



if (isset($_GET['add_to_cart'])) {
    // Récupérer l'ID du produit
    $product_id = $_GET['add_to_cart'];

    // Ajouter le produit au panier (dans la session)
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Vérifier si le produit existe déjà dans le panier, si oui on incrémente la quantité
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = ['quantity' => 1];
    }


   header("Location: panier.php");
}

include("../View/header.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <link rel="stylesheet" href="css/produits.css">
</head>
<body>
<div class="container1">
    <h2>Nos Produits</h2>
    <div class="product-container">
        <?php
        $count = 0;
        echo '<div class="product-row">'; // Début de la première ligne
        foreach ($produits as $produit):
            ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($produit->getImgProd()); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">
                <h3><?= htmlspecialchars($produit->getNomProd()); ?></h3>
                <p class="product-brand"><?= htmlspecialchars($produit->getMarqProd()); ?></p>
                <p class="product-price"><?= number_format($produit->getPrixProd(), 2, ',', ' '); ?> €</p>
                <div class="button-container">
                    <a href="?add_to_cart=<?= $produit->getIdProd(); ?>" class="buy-btn">🛒 Ajouter au panier</a>
                </div>
            </div>
            <?php
            $count++;
            if ($count % 3 == 0) {
                echo '</div><div class="product-row">'; // Nouvelle ligne après chaque 4 produits
            }
        endforeach;
        echo '</div>'; // Fermer la dernière ligne
        ?>
    </div>
</div>
</body>
</html>

