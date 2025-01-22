<?php
include('header.php');
use Model\DAO\ProduitDAO;


require_once('../Model/DAO/ProduitDAO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/BDDManager.php');

// Connexion à la base de données
try {
    $a = initialiseConnexionBDD();
    // Création de l'objet DAO
    $produitsDAO = new ProduitDAO($a);

    // Récupération des produits depuis la base de données
    $produits = $produitsDAO->getAllProduits();

} catch (PDOException $e) {
    echo "<p>Erreur lors de la connexion à la base de données : " . $e->getMessage() . "</p>";
    //$produits = [];
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


<div class="container">
    <h2>Nos Produits</h2>
    <div class="product-list">
        <?php  ?>
            <?php foreach ($produits as $produit): ?>
                <div class="product">
                    <!-- Texte à gauche -->
                    <div class="product-details">
                        <h3><?php ?> /* htmlspecialchars($produit->getNomProd()); */</h3>
                        <p><?php /* htmlspecialchars($produit->getDescProd()); */ ?></p>
                        <button>Ajouter au panier</button>
                    </div>
                    <!-- Image à droite -->
                    <img src="<?= htmlspecialchars($produit->getImageProd()); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">
                </div>
            <?php endforeach; ?>
        <?php  ?>
            <p>Aucun produit disponible pour le moment.</p>
        <?php ; ?>
    </div>
</div>
</body>
</html>
<?php
include('footer.php');
?>