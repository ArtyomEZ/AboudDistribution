<?php

session_start();

require_once '../Model/DAO/UtilisateurDAO.php';
require_once '../Model/BO/UtilisateurBO.php';
require_once '../Model/BDDManager.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header("Location: ../View/login.php");
    exit;
}

$bdd = initialiseConnexionBDD();
$utilisateurDAO = new UtilisateurDAO($bdd);

$loginActuel = $_SESSION['login']; // Récupération de l'utilisateur connecté

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveauLogin = trim($_POST['login']);
    $nouveauMdp = trim($_POST['mdp']);

    if (empty($nouveauLogin)) {
        $_SESSION['error'] = "Le login ne peut pas être vide.";
        header("Location: ../View/parametre.php");
        exit;
    }

    // Récupération des infos actuelles de l'utilisateur
    $utilisateur = $utilisateurDAO->getUtilisateurByLogin($loginActuel);

    if (!$utilisateur) {
        $_SESSION['error'] = "Utilisateur introuvable.";
        header("Location: ../View/parametre.php");
        exit;
    }

    // Vérification si le login a changé
    if ($nouveauLogin !== $loginActuel) {
        // Vérifier si le nouveau login existe déjà
        if ($utilisateurDAO->getUtilisateurByLogin($nouveauLogin)) {
            $_SESSION['error'] = "Ce login est déjà pris.";
            header("Location: ../View/parametre.php");
            exit;
        }
    }

    // Vérification si le mot de passe a changé
    $nouveauMdpHache = $utilisateur->getMdpUti(); // Garder l'ancien si non modifié
    if ($nouveauMdp !== "********") { // Si l'utilisateur a entré un nouveau mot de passe
        $nouveauMdpHache = password_hash($nouveauMdp, PASSWORD_BCRYPT);
    }

    // Mise à jour des informations
    $updateSuccess = $utilisateurDAO->editUtilisateur($utilisateur->getIdUti(), $nouveauLogin, $nouveauMdpHache);

    if ($updateSuccess) {
        $_SESSION['success'] = "Informations mises à jour avec succès.";
        $_SESSION['login'] = $nouveauLogin; // Mettre à jour la session avec le nouveau login
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour.";
    }

    header("Location: ../View/pageParam.php");
    exit;
}

