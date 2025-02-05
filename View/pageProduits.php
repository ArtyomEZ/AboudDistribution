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

session_start();

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

    // Rediriger vers la page panier
    header('Location: panier.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - Boutique Automobile</title>
    <link rel="stylesheet" href="css/produits.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>

<?php
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
    unset($_SESSION['error_message']);
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
                    <!-- Passer l'ID du produit à la page panier via URL -->
                    <a href="?add_to_cart=<?= $produit->getIdProd(); ?>" class="buy-btn">🛒 Ajouter au panier</a>
                </div>
<<<<<<< Updated upstream
            </div>
        <?php endforeach; ?>


        </div>


    </div>
</div>


</body>
</html>

<?php include('footer.php'); ?>

    </body>
    </html>

    <?php include('footer.php'); ?>

    </body>
</html>
