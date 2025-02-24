<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../Model/BDDManager.php');
require_once('../Model/DAO/PanierDAO.php');
require_once('../Model/BO/PanierBO.php');
require_once('../Model/BO/UtilisateurBO.php');

use Model\DAO\PanierDAO;
$a = initialiseConnexionBDD();

if (!isset($_SESSION['id'])) {
    die("⚠️ Vous devez être connecté pour voir votre panier.");
}

$idUtilisateur = $_SESSION['id'] ?? 0;

if ($idUtilisateur === 0) {
    die("⚠️ Problème : ID utilisateur non défini ou invalide !");
}

$panierDAO = new PanierDAO($a);
$panier = $panierDAO->getPanierUtilisateur($idUtilisateur);

include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="css/panier.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>

<h2>Votre Panier</h2>

<?php if (!empty($panier)): ?>
    <div class="cart-items">
        <?php $total = 0; ?>
        <?php foreach ($panier as $item): ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item->getProduit()->getImgProd()); ?>" alt="<?= htmlspecialchars($item->getProduit()->getNomProd()); ?>">
                <div class="cart-item-details">
                    <h3><?= htmlspecialchars($item->getProduit()->getNomProd()); ?></h3>
                    <p>Prix : <?= htmlspecialchars($item->getProduit()->getPrixProd()); ?> €</p>
                    <p>Quantité : <?= $item->getQuantite(); ?></p>

                    <!-- Formulaire pour modifier la quantité -->
                    <form action="../Controller/modifierpanier.php" method="post" class="quantity-form">
                        <input type="hidden" name="id_produit" value="<?= $item->getProduit()->getIdProd(); ?>">
                        <button type="submit" name="action" value="increase">➕</button>
                        <button type="submit" name="action" value="decrease">➖</button>
                    </form>

                    <p>Total : <?= $item->getProduit()->getPrixProd() * $item->getQuantite(); ?> €</p>

                    <!-- Bouton pour supprimer un article -->
                    <form action="../Controller/supprimerPanier.php" method="post">
                        <input type="hidden" name="id_produit" value="<?= $item->getProduit()->getIdProd(); ?>">
                        <button type="submit" class="delete-btn">🗑 Supprimer</button>
                    </form>
                </div>
            </div>
            <?php $total += $item->getProduit()->getPrixProd() * $item->getQuantite(); ?>
        <?php endforeach; ?>
        <h3 class="cart-total">Total : <?= $total; ?> €</h3>

        <!-- Boutons Retour et Payer -->
        <div class="cart-actions">
            <a href="pageProduits.php" class="btn">⬅ Retour</a>
            <a href="paiement.php" class="btn btn-pay">💳 Payer</a>
        </div>
    </div>
<?php else: ?>
    <p>Votre panier est vide.</p>
    <a href="pageProduits.php" class="btn">⬅ Retour</a>
<?php endif; ?>

</body>
</html>
<footer>
    <?php
    include 'footer.php';
    ?>
</footer>
