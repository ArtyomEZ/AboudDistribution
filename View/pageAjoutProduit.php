<?php

use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;

require_once '../Controller/ProduitController.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/BDDManager.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

$bdd = initialiseConnexionBDD();
$typeProduitDAO = new TypeProduitDAO($bdd);
$typesProduits = $typeProduitDAO->getAllTypeProduits();

include 'headerAdmin.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Produit</title>
    <link rel="stylesheet" href="css/ajout.css">
</head>
<body>
<div class="container">
    <h1>Créer un Nouveau Produit</h1>
    <form method="POST" action="../Controller/ProduitController.php?action=ajoutProduitBDD" class="contact-form">
        <label for="nom_prod">Nom du Produit :</label>
        <input type="text" id="nom_prod" name="nom_prod" required>

        <label for="desc_prod">Description :</label>
        <textarea id="desc_prod" name="desc_prod" required></textarea>

        <label for="marq_prod">Marque :</label>
        <input type="text" id="marq_prod" name="marq_prod" required>

        <label for="prix_prod">Prix :</label>
        <input type="number" id="prix_prod" name="prix_prod" min="0" required>

        <label for="img_prod">Image (URL) :</label>
        <input type="text" id="img_prod" name="img_prod">

        <label for="id_typ_prod">Type de Produit :</label>
        <select id="id_typ_prod" name="id_typ_prod" required>
            <option value="">-- Sélectionnez un Type --</option>
            <?php foreach ($typesProduits as $type): ?>
                <option value="<?= $type->getIdTypProd(); ?>"><?= $type->getLibTypProd(); ?></option>
            <?php endforeach; ?>
        </select>

        <button>Créer le Produit</button>
    </form>
</div>
</body>
</html>
<?php
include 'footer.php';
?>