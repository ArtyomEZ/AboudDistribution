<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue de Pièces Automobiles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            width: calc(25% - 20px);
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: auto;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .card h3 {
            margin: 15px 0;
            font-size: 18px;
            color: #333;
        }
        .card a {
            display: block;
            text-decoration: none;
            color: #007BFF;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<h1 style="text-align: center; margin: 20px 0;">Catalogue de Pièces Automobiles</h1>
<div class="container">*
    <?php
    include('header.php');
    use Model\DAO\ProduitsDAO;


    include_once('../Model/DAO/ProduitsDAO.php');
    include_once('../Model/BO/ProduitBO.php');
    require_once('../Model/BDDManager.php');

    // Connexion à la base de données
    try {
        $a = initialiseConnexionBDD();
        // Création de l'objet DAO
        $produitsDAO = new ProduitsDAO($a);

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
