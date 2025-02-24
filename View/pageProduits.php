<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use Model\DAO\PanierDAO;
use Model\DAO\ProduitDAO;
use Model\BO\PanierBO;
use Model\BO\UtilisateurBO;
use Model\BO\ProduitBO;
require_once('../Model/DAO/ProduitDAO.php');
require_once('../Model/DAO/PanierDAO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/BO/UtilisateurBO.php');
require_once('../Model/BO/PanierBO.php');
require_once('../Model/BDDManager.php');

if (isset($_GET['add_to_cart'])) {
    // Vérifiez si l'utilisateur est connecté
    if (isset($_SESSION['id'])) {
        // Récupérer l'ID du produit et de l'utilisateur
        $product_id = $_GET['add_to_cart'];
        $user_id = $_SESSION['id'];

        // Récupérer les informations du produit
        try {
            $a = initialiseConnexionBDD();
            $produitsDAO = new ProduitDAO($a);
            $produit = $produitsDAO->getProduitById($product_id);

            if ($produit) {
                // Créer une instance de PanierDAO
                $panierDAO = new PanierDAO($a);
                $login = $_SESSION['login'];
                $mdp = 'null';
                $adr = null;

                // Vérifier si le produit est déjà dans le panier de l'utilisateur
                $panier = new PanierBO(new UtilisateurBO($user_id,$login,$mdp,$adr), $produit, 1,0);
                $panierDAO->ajouterAuPanier($panier); // Ajouter ou mettre à jour le produit dans le panier

                // Rediriger vers la page panier
                header("Location: panier.php");
                exit(); // Assurez-vous de sortir après la redirection
            } else {
                echo "Produit non trouvé.";
            }
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout au panier : " . $e->getMessage();
        }
    } else {
        echo "Vous devez être connecté pour ajouter un produit au panier.";
    }
}


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
                    <a href="produit_detail.php?id=<?= $produit->getIdProd(); ?>" class="buy-btn">🔍 Voir le produit</a>
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
<footer>
    <?php
    include ('footer.php');
    ?>
</footer>
</html>
