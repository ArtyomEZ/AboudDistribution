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
        <div class="product">
            <?php
            try {
            // Connexion à la base de données
            $pdo = new PDO('mysql:host=localhost;dbname=abouddistribution', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Création du DAO
            $produitDAO = new ProduitDAO($pdo);

            // Appel de la méthode
            $produits = $produitDAO->getAllProduits();

            // Affichage des produits
            foreach ($produits as $produit) {
            echo "Nom : " . $produit->getNomProd() . "<br>";
            echo "Description : " . $produit->getDescProd() . "<br>";
            echo "Marque : " . $produit->getMarProd() . "<br>";
            echo "Prix : " . $produit->getPrixProd() . "€<br>";
            }
            } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            }
            ?>

<?php include('footer.php'); ?>