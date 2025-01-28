<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue de Pièces Automobiles</title>
<link rel="stylesheet" href="css/header.css">
</head>
<body>
<h1 style="text-align: center; margin: 20px 0;">Catalogue de Pièces Automobiles</h1>
<div class="container">*
    <?php
    include('header.php');
    use Model\DAO\ProduitDAO;


    include_once('../Model/DAO/ProduitDAO.php');
    include_once('../Model/BO/ProduitBO.php');
    require_once('../Model/BDDManager.php');
re
    // Connexion à la base de données
    try {
        $a = initialiseConnexionBDD();
        // Création de l'objet DAO
        $produitsDAO = new ProduitDAO($a);

        // Récupération des produits depuis la base de données
        $produits = $produitsDAO->getAllProduits();

    } catch (PDOException $e) {
        echo "<p>Erreur lors de la connexion à la base de données : " . $e->getMessage() . "</p>";
        $produits = [];
    }
?>
<?php if (!empty($produits)): ?>
    <?php foreach ($produits as $produit): ?>

            <h3><?= htmlspecialchars($produit->getNomProd()); ?></h3>
            <p><?= htmlspecialchars($produit->getDescProd()); ?></p>
            <button>Ajouter au panier</button>

        <!-- Image à droite -->
        <img src="<?= htmlspecialchars($produit->getImgProd()); ?>" alt="<?= htmlspecialchars($produit->getNomProd()); ?>">

    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun produit disponible pour le moment.</p>
    <?php endif; ?>
    ?>



</div>
</body>
</html>
