

<?php

use Model\DAO\ProduitDAO;
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO\TypeProduitBO.php';
require_once '../Model/BDDManager.php';
$bdd = initialiseConnexionBDD();
$daoProduit = new ProduitDAO($bdd);
$typesProduits = $daoProduit->getAllProduits();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=AboudDistribution;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupérer tous les types de produits pour la liste déroulante
$typeProduitDAO = new Model\DAO\TypeProduitDAO($bdd);
$typesProduits = $typeProduitDAO->getAllTypeProduits();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom_prod = $_POST['nom_prod'] ?? '';
    $desc_prod = $_POST['desc_prod'] ?? '';
    $marq_prod = $_POST['marq_prod'] ?? '';
    $prix_prod = $_POST['prix_prod'] ?? 0;
    $img_prod = $_POST['img_prod'] ?? '';
    $id_typ_prod = $_POST['id_typ_prod'] ?? 0;

    // Vérification des champs
    if (!empty($nom_prod) && !empty($desc_prod) && !empty($marq_prod) && $prix_prod > 0 && $id_typ_prod > 0) {
        // Création de l'objet TypeProduitBO
        $typeProduit = new Model\BO\TypeProduitBO($id_typ_prod, '');

        // Création de l'objet ProduitBO
        $produit = new Model\BO\ProduitBO(0, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $typeProduit);

        // Enregistrement dans la base de données
        $produitDAO = new Model\DAO\ProduitDAO($bdd);
        $success = $produitDAO->createProduit($produit);

        if ($success) {
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

        <label for="id_typ_prod">Type de Produit :</label>
        <select id="id_typ_prod" name="id_typ_prod" required>
            <option value="">-- Sélectionnez un Type --</option>
            <?php foreach ($typesProduits as $type): ?>
                <option value="<?= $type->getIdTypProd(); ?>"><?= $type->getLibTypProd(); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Créer le Produit</button>
    </form>
</div>
</body>
</html>
<?php

include 'footer.php';
?>