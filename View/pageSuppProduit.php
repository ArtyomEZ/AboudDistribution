<?php

use Model\DAO\ProduitDAO;

require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';
require_once '../Model/DAO/TypeProduitDAO.php';


// Connexion à la base de données (remplace par tes propres paramètres)
$dsn = 'mysql:host=localhost;dbname=abouddistribution;charset=utf8';
$username = 'root'; // Change si nécessaire
$password = ''; // Change si nécessaire

try {
    $bdd = new PDO($dsn, $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $produitDAO = new ProduitDAO($bdd);

    // Si le formulaire est soumis, suppression du produit
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_prod'])) {
        $id_prod = (int) $_POST['id_prod'];
        $produitDAO->deleteProduit($id_prod);
        $message = "Le produit a bien été supprimé !";
    }

    // Récupérer tous les produits pour l'afficher dans la liste déroulante
    $produits = $produitDAO->getAllProduits();
} catch (Exception $e) {
    die("Erreur de connexion à la base : " . $e->getMessage());
}
include 'headerAdmin.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        button {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #d32f2f;
        }
        .message {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Supprimer un produit</h1>
    <?php if (isset($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="id_prod">Choisissez un produit à supprimer :</label>
        <select name="id_prod" id="id_prod" required>
            <option value="">-- Sélectionnez un produit --</option>
            <?php foreach ($produits as $produit): ?>
                <option value="<?= $produit->getIdProd() ?>">
                    <?= htmlspecialchars($produit->getNomProd()) ?> - <?= htmlspecialchars($produit->getPrixProd()) ?> €
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Supprimer</button>
    </form>
</div>
</body>
</html>

