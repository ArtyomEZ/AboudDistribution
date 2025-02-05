<?php

use Model\DAO\AdministrateurDAO;

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/AdministrateurDAO.php';
require_once '../Model/DAO/UtilisateurDAO.php';

class LoginController
{
    private $bdd;
    private $utilisateurDAO;
    private $administrateurDAO;

    public function __construct() {
        $this->bdd = initialiseConnexionBDD();
        if (!$this->bdd) {
            $this->redirectWithError("Impossible de se connecter à la base de données.");
        }

        $this->utilisateurDAO = new UtilisateurDAO($this->bdd);
        $this->administrateurDAO = new AdministrateurDAO($this->bdd);
    }

    public function login(string $login, string $password): void {
        session_start();

        try {
            // Vérification administrateur
            $user = $this->administrateurDAO->loginAdmin($login, $password);
            if ($user) {
                $this->startSession($user, "administrateur");
                return;
            }

            // Vérification utilisateur normal
            $utilisateur = $this->utilisateurDAO->getUtilisateurByLogin($login);

            if (!$utilisateur) {
                $this->redirectWithError("❌ Aucun utilisateur trouvé avec ce login.");
            }

            // Vérification du mot de passe
            if (password_verify($password, $utilisateur->getMdpUti())) {
                $this->startSession($utilisateur, "utilisateur");
            } else {
                $this->redirectWithError("❌ Mot de passe incorrect.");
            }
        } catch (Exception $e) {
            $this->redirectWithError("❌ Erreur serveur : " . $e->getMessage());
        }
    }

    private function startSession($user, $role)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['id'] = ($role === "administrateur") ? $user->getAdminId() : $user->getIdUti();
        $_SESSION['login'] = ($role === "administrateur") ? $user->getAdminLogin() : $user->getLoginUti();
        $_SESSION['role'] = $role;

        header("Location: ../View/pageProduits.php");
        exit;
    }

    private function redirectWithError($message)
    {
        header("Location: ../View/pageConnexion.php?error=" . urlencode($message));
        exit;
    }
}

// Vérification du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"] ?? '';
    $mdp = $_POST["mdp"] ?? '';

    if (empty($login) || empty($mdp)) {
        header("Location: ../View/pageConnexion.php?error=Veuillez remplir tous les champs.");
        exit;
    }

    $controller = new LoginController();
    $controller->login($login, $mdp);
} else {
    header("Location: ../View/pageConnexion.php?error=Requête invalide.");
    exit;
}
