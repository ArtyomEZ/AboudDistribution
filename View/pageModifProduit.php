<?php

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;

require_once '../Controller/ProduitController.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/BDDManager.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

$bdd = initialiseConnexionBDD();
$controller = new ProduitController();
$produitDAO = new ProduitDAO($bdd);
$typeProduitDAO = new TypeProduitDAO($bdd);
$produits = $produitDAO->getAllProduits();
$typesProduits = $typeProduitDAO->getAllTypeProduits();

$produitActuel = null;
if (isset($_GET['id_prod']) && !empty($_GET['id_prod'])) {
    $id_prod = (int) $_GET['id_prod'];
    $produitActuel = $produitDAO->getProduitById($id_prod);
}

include 'headerAdmin.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit</title>
    <link rel="stylesheet" href="css/ajout.css">
</head>
<body>
<div class="container">
    <h1>Modifier un Produit</h1>

    <!-- Sélection du produit -->
    <form method="GET">
        <label for="id_prod">Choisir un produit :</label>
        <select id="id_prod" name="id_prod" onchange="this.form.submit()">
            <option value="">-- Sélectionnez un produit --</option>
            <?php foreach ($produits as $produit): ?>
                <option value="<?= $produit->getIdProd(); ?>" <?= (isset($produitActuel) && $produit->getIdProd() == $produitActuel->getIdProd()) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($produit->getNomProd()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($produitActuel): ?>
        <!-- Formulaire de modification -->
        <form method="POST" action="pageModifProduit.php?action=modifProduitBDD" class="contact-form">
            <input type="hidden" name="id_prod" value="<?= $produitActuel->getIdProd(); ?>">

            <label for="nom_prod">Nom du Produit :</label>
            <input type="text" id="nom_prod" name="nom_prod" value="<?= htmlspecialchars($produitActuel->getNomProd()); ?>" required>

            <label for="desc_prod">Description :</label>
            <textarea id="desc_prod" name="desc_prod" required><?= htmlspecialchars($produitActuel->getDescProd()); ?></textarea>

            <label for="marq_prod">Marque :</label>
            <input type="text" id="marq_prod" name="marq_prod" value="<?= htmlspecialchars($produitActuel->getMarqProd()); ?>" required>

            <label for="prix_prod">Prix :</label>
            <input type="number" id="prix_prod" name="prix_prod" value="<?= $produitActuel->getPrixProd(); ?>" min="0" required>

            <label for="img_prod">Image (URL) :</label>
            <input type="text" id="img_prod" name="img_prod" value="<?= htmlspecialchars($produitActuel->getImgProd()); ?>">

            <label for="id_typ_prod">Type de Produit :</label>
            <select id="id_typ_prod" name="id_typ_prod" required>
                <option value="">-- Sélectionnez un Type --</option>
                <?php foreach ($typesProduits as $type): ?>
                    <option value="<?= $type->getIdTypProd(); ?>" <?= ($produitActuel->getTypProd()->getIdTypProd() == $type->getIdTypProd()) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($type->getLibTypProd()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="modifier">Modifier le Produit</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

<?php include 'footer.php'; ?>

