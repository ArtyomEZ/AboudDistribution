<?php

use Model\DAO\PanierDAO;

session_start();
require_once('../Model/BDDManager.php');
require_once('../Model/DAO/PanierDAO.php');

if (!isset($_SESSION['id'])) {
    die("⚠️ Vous devez être connecté.");
}

$a = initialiseConnexionBDD();
$panierDAO = new PanierDAO($a);

$idUtilisateur = $_SESSION['id'];
$idProduit = $_POST['id_produit'] ?? null;
$action = $_POST['action'] ?? '';

if (!$idProduit) {
    die("⚠️ Produit invalide.");
}

// Vérifier l'action
if ($action === "increase") {
    $panierDAO->modifierQuantite($idUtilisateur, $idProduit, 1); // Ajoute 1
} elseif ($action === "decrease") {
    $panierDAO->modifierQuantite($idUtilisateur, $idProduit, -1); // Supprime 1
}

// Redirection vers la page panier après modification
header("Location: ../View/panier.php");
exit;
