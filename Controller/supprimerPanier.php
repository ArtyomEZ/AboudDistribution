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

if (!$idProduit) {
    die("⚠️ Produit invalide.");
}

$panierDAO->supprimerProduit($idUtilisateur, $idProduit);

header("Location: ../View/panier.php");
exit;
