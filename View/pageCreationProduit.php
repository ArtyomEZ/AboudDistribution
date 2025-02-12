<?php
use Model\DAO\ProduitDAO;
use Model\DAO\SousCategorieDAO;
use Model\DAO\CategorieDAO;
use Model\BO\ProduitBO;
use Model\BO\SousCategorieBO;
use Model\BO\CategorieBO;
use Model\BDDManager;

require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/DAO/CategorieDAO.php';
require_once '../Model/DAO/SousCategorieDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/CategorieBO.php';
require_once '../Model/BO/SousCategorieBO.php';
require_once '../Model/BDDManager.php';

// Connexion à la base de données
$bdd = initialiseConnexionBDD();
$categorieDAO = new CategorieDAO($bdd);
$souscategorieDAO = new SousCategorieDAO($bdd);
$produitDAO = new ProduitDAO($bdd);

// Récupérer toutes les catégories
$categoriesProduit = $categorieDAO->getAllCategories();

// Récupération de la catégorie sélectionnée
$id_cat_selectionnee = $_POST['id_cat'] ?? '';

// Récupération des sous-catégories correspondantes à la catégorie sélectionnée
$souscategories = [];
if (!empty($id_cat_selectionnee)) {
    // Test de récupération des sous-catégories avec var_dump pour déboguer
    $souscategories = $souscategorieDAO->getSousCategoriesByCategorieId($id_cat_selectionnee);
    var_dump($souscategories);  // Debugging ici
}

// Traitement du formulaire d'ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_produit'])) {
    $nom_prod = $_POST['nom_prod'] ?? '';
    $desc_prod = $_POST['desc_prod'] ?? '';
    $marq_prod = $_POST['marq_prod'] ?? '';
    $prix_prod = $_POST['prix_prod'] ?? 0;
    $img_prod = $_POST['img_prod'] ?? '';
    $id_sous_cat = $_POST['id_sous_cat'] ?? 0;

    if (!empty($nom_prod) && !empty($desc_prod) && !empty($marq_prod) && $prix_prod > 0 && $id_sous_cat > 0) {
        $souscatProduit = new SousCategorieBO($id_sous_cat, '', $id_cat_selectionnee);
        $produit = new ProduitBO(0, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $souscatProduit);

        if ($produitDAO->createProduit($produit)) {
            echo "<p style='color:green;'>Produit créé avec succès !</p>";
        } else {
            echo "<p style='color:red;'>Erreur lors de la création du produit.</p>";
        }
    } else {
        echo "<p style='color:red;'>Veuillez remplir tous les champs correctement.</p>";
    }
}

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
    <form method="POST" class="contact-form">
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

        <label for="id_cat">Catégorie :</label>
        <select id="id_cat" name="id_cat" required onchange="this.form.submit()">
            <option value="">-- Sélectionnez une catégorie --</option>
            <?php foreach ($categoriesProduit as $cat): ?>
                <option value="<?= $cat->getIdCat(); ?>" <?= ($id_cat_selectionnee == $cat->getIdCat()) ? 'selected' : '' ?>>
                    <?= $cat->getNomCat(); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="id_sous_cat">Sous-Catégorie :</label>
        <select id="id_sous_cat" name="id_sous_cat" required>
            <option value="">-- Sélectionnez une sous-catégorie --</option>
            <?php if (count($souscategories) > 0): ?>
                <?php foreach ($souscategories as $souscat): ?>
                    <option value="<?= $souscat->getIdSousCat(); ?>">
                        <?= $souscat->getNomSousCat(); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">Aucune sous-catégorie disponible</option>
            <?php endif; ?>
        </select>

        <button type="submit" name="submit_produit">Créer le Produit</button>
    </form>
</div>
</body>
</html>

<?php include 'footer.php'; ?>