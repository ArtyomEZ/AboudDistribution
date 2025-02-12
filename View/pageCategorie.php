<?php

use Model\DAO\CategorieDAO;

include 'header.php';
require_once '../Model/BDDManager.php';
require_once '../Model/DAO/CategorieDAO.php';

// Connexion à la base de données
$bdd = initialiseConnexionBDD();
$categorieDAO = new CategorieDAO($bdd);

// Vérifier si une catégorie est passée dans l'URL
if (!isset($_GET['categorie'])) {
    echo "<p class='error'>Aucune catégorie sélectionnée.</p>";
    exit;
}

$categorie = htmlspecialchars($_GET['categorie']);

// Récupérer les informations de la catégorie depuis la base de données
$infosCategorie = $categorieDAO->getInfosByCategorie($categorie);
?>

<link type="text/css" rel="stylesheet" href="css/categorie.css">

<div class="main-content">
    <h2>Catégorie : <?= ucfirst(str_replace("-", " ", $categorie)) ?></h2>

    <?php if ($infosCategorie): ?>
        <ul class="categorie-list">
            <?php foreach ($infosCategorie as $info): ?>
                <li>
                    <h3><?= htmlspecialchars($info['nom_piece']) ?></h3>
                    <p><?= htmlspecialchars($info['description']) ?></p>
                    <strong>Prix : <?= htmlspecialchars($info['prix']) ?> €</strong>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune information trouvée pour cette catégorie.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
