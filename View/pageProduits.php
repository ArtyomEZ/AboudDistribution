<?php
include('header.php');
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



?>


    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nos Produits - Boutique Automobile</title>
        <link rel="stylesheet" href="css/produits.css">
    </head>
    <body>
    <?php
    session_start();
    if (isset($_SESSION['error_message'])) {
        echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
        unset($_SESSION['error_message']); // Supprime le message après l'affichage
    }
    ?>
    <div class="container1">
        <h2>Nos Produits</h2>
        <div class="product-grid">
            <?php foreach ($produits as $produit): ?>
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
        </div>


    </div>



    </body>
    </html>

    <?php include('footer.php'); ?>

    </body>
    </html>
