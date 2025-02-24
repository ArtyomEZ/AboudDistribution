<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
use Model\DAO\CategorieDAO;
use Model\DAO\ProduitDAO;

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/DAO/CategorieDAO.php';

// Connexion à la base de données
$bdd = initialiseConnexionBDD();
$produitDAO = new ProduitDAO($bdd);
$categorieDAO = new CategorieDAO($bdd);

// Vérifier si une sous-catégorie est passée dans l'URL
if (!isset($_GET['categorie'])) {
    echo "<p class='error'>Aucune sous-catégorie sélectionnée.</p>";
    exit;
}

$sousCategorie = htmlspecialchars($_GET['categorie']);

// Récupérer les produits liés à cette sous-catégorie
$pieces = $produitDAO->getInfosByCategorie($sousCategorie);

// Gestion de l'ajout au panier

// Vérification du rôle administrateur
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
    <title>Sous-Catégorie : <?= ucfirst(str_replace("-", " ", $sousCategorie)) ?></title>
    <link rel="stylesheet" href="css/categorie.css">
    <link rel="stylesheet" href="css/header.css">
    <style>
        /* Styles globaux */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Conteneur principal */
        .container1 {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            text-align: center;
        }

        /* Grille des produits */
        .product-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Ligne de produits (4 par ligne) */
        .product-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Style des produits */
        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            width: calc(25% - 20px); /* Pour 4 produits par ligne, en tenant compte de l'espacement */
            min-width: 250px;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px; /* Taille uniforme */
            max-width: 300px;
        }

        /* Image produit */
        .product-card img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        /* Nom du produit */
        .product-card h3 {
            font-size: 1rem;
            color: #343a40;
            margin: 10px 0;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Prix */
        .product-card .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        /* Marque */
        .product-brand {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
        }

        /* Bouton */
        .button-container {
            margin-top: auto;
        }

        .buy-btn {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .buy-btn:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
<div class="main-content">
    <h2>Sous-Catégorie : <?= ucfirst(str_replace("-", " ", $sousCategorie)) ?></h2>

    <?php if (!empty($pieces)): ?>
        <div class="product-container">
            <?php

            foreach ($pieces as $piece):
                $piece = (object) $piece;
                ?>
                <div class="product-card">
                    <!-- Utiliser la méthode getImgProd() pour afficher l'image -->
                    <img src="<?= htmlspecialchars($piece->getImgProd()); ?>" alt="<?= htmlspecialchars($piece->getNomProd()); ?>">
                    <h3><?= htmlspecialchars($piece->getNomProd()); ?></h3>
                    <p><?= htmlspecialchars($piece->getDescProd()); ?></p>
                    <strong class="product-price"><?= number_format($piece->getPrixProd(), 2, ',', ' ') ?> €</strong>
                    <div class="button-container">
                        <a href="?add_to_cart=<?= $piece->getIdProd(); ?>" class="buy-btn">🛒 Ajouter au panier</a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <p>Aucune pièce disponible pour cette sous-catégorie.</p>
    <?php endif; ?>
</div>

<footer>
    <?php include('footer.php'); ?>
</footer>

</body>
</html>
