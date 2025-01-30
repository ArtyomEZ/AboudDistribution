<?php
require_once '../Model/BDDManager.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

use Model\DAO\ProduitDAO;

$bdd = initialiseConnexionBDD();

// Vérifie si une recherche a été soumise
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = htmlspecialchars($_GET['search']);

    $produitDAO = new ProduitDAO($bdd);
    $resultats = $produitDAO->searchProduits($searchTerm);

    // Stocker les résultats et le terme de recherche en session
    session_start();
    $_SESSION['searchTerm'] = $searchTerm;

    if (!empty($resultats)) {
        // Stocker les résultats en session et rediriger vers la page d'affichage
        $_SESSION['resultats'] = $resultats;
        header("Location: ../view/resultatproduits.php");
        exit;
    } else {
        // Si aucun produit n'est trouvé, rediriger avec un message d'erreur
        $_SESSION['error_message'] = "Aucun produit trouvé pour la recherche : " . $searchTerm;
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirection vers la page précédente
        exit;
    }
} else {
    // Si aucun terme de recherche n'est spécifié, rediriger avec un message d'erreur
    session_start();
    $_SESSION['error_message'] = "Veuillez entrer un terme de recherche.";
    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirection vers la page précédente
    exit;
}
