<?php
session_start();
include('header.php');
use Model\DAO\ProduitDAO;

require_once('../Model/DAO/ProduitDAO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/BDDManager.php');
require_once('../Model/BO/TypeProduitBO.php');

try {
    $a = initialiseConnexionBDD();
    $produitsDAO = new ProduitDAO($a);
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
        <title>Votre Panier - Boutique Automobile</title>
        <link rel="stylesheet" href="css/panier.css">
        <link rel="stylesheet" href="css/header.css">
        <style>
            .container1 {
                text-align: center;
                max-width: 800px;
                margin: auto;
            }
            .cart-items {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            .cart-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                border: 1px solid #ddd;
                padding: 10px;
                border-radius: 10px;
                background-color: #fff;
                width: 100%;
            }
            .cart-item img {
                width: 100px;
                height: auto;
            }
            .quantity-form {
                display: flex;
                justify-content: center;
                gap: 10px;
            }
            .cart-total {
                margin-top: 20px;
                font-size: 20px;
                font-weight: bold;
            }
            .buttons {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 20px;
            }
            .btn {
                background-color: #28a745;
                color: white;
                border: none;
                padding: 10px 15px;
                cursor: pointer;
                border-radius: 5px;
                font-size: 18px;
            }
            .btn:hover {
                background-color: #218838;
            }
            .back-btn {
                background-color: #6c757d;
            }
            .back-btn:hover {
                background-color: #5a6268;
            }
        </style>
    </head>
    <body>

    <div class="container1">
        <h2>Votre Panier</h2>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <div class="cart-items">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $item):
                    $product = null;
                    foreach ($produits as $p) {
                        if ($p->getIdProd() == $product_id) {
                            $product = $p;
                            break;
                        }
                    }
                    if ($product):
                        $item_total = $product->getPrixProd() * $item['quantity'];
                        $total += $item_total;
                        ?>
                        <div class="cart-item">
                            <img src="<?= $product->getImgProd(); ?>" alt="<?= htmlspecialchars($product->getNomProd()); ?>">
                            <h3><?= htmlspecialchars($product->getNomProd()); ?></h3>
                            <p>Prix : <?= htmlspecialchars($product->getPrixProd()); ?> €</p>
                            <form method="POST" action="../Controller/panierController.php" class="quantity-form">
                                <input type="hidden" name="id_produit" value="<?= $product_id; ?>">
                                <button type="submit" name="action" value="diminuer" class="btn">➖</button>
                                <span class="quantity"><?= $item['quantity']; ?></span>
                                <button type="submit" name="action" value="augmenter" class="btn">➕</button>
                            </form>
                            <p>Total : <?= $item_total; ?> €</p>
                            <form method="POST" action="../Controller/panierController.php">
                                <input type="hidden" name="id_produit" value="<?= $product_id; ?>">
                                <button type="submit" name="action" value="supprimer" class="btn delete-btn">❌ Supprimer</button>
                            </form>
                        </div>
                    <?php endif; endforeach; ?>
                <div class="cart-total">
                    <h3>Total : <?= $total; ?> €</h3>
                </div>
                <div class="buttons">
                    <a href="checkout.php" class="btn">Passer à la caisse</a>
                    <a href="pageAccueil.php" class="btn back-btn">Retour</a>
                </div>
            </div>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>

    </body>
    </html>

<?php include('footer.php'); ?>