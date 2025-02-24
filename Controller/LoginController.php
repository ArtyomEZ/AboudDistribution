<?php

use Model\DAO\AdministrateurDAO;

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/UtilisateurDAO.php';
require_once '../Model/DAO/AdministrateurDAO.php';

class LoginController
{
    private $utilisateurDAO;
    private $administrateurDAO;

    public function __construct() {
        $bdd = initialiseConnexionBDD();
        $this->utilisateurDAO = new UtilisateurDAO($bdd);
        $this->administrateurDAO = new AdministrateurDAO($bdd);
    }

    public function login(string $login, string $password): void {
        session_start();
        echo "🔍 Tentative de connexion...<br>";

        try {
            // 🔎 Vérifie si c'est un administrateur
            $user = $this->administrateurDAO->loginAdmin($login, $password);
            if ($user) {
                $this->startSession($user, "administrateur");
                return;
            }

            // 🔎 Vérifie si c'est un utilisateur normal
            $utilisateur = $this->utilisateurDAO->getUtilisateurByLogin($login);

            if (!$utilisateur) {
                $this->redirectWithError("❌ Aucun utilisateur trouvé.");
            }

            echo "✅ Utilisateur trouvé : " . htmlspecialchars($utilisateur->getLoginUti()) . "<br>";
            echo "🔑 Mot de passe stocké (hash) : " . $utilisateur->getMdpUti() . "<br>";

            // 🔑 Vérification du mot de passe
            if (password_verify($password, $utilisateur->getMdpUti())) {
                echo "✅ Mot de passe correct !<br>";
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

        echo "✅ Connexion réussie en tant que $role !<br>";
        header("Location: ../View/pageProduits.php");
        exit;
    }

    private function redirectWithError($message)
    {
        header("Location: ../View/pageProduits.php?error=" . urlencode($message));
        exit;
    }
}

// 🔥 Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"] ?? '';
    $mdp = $_POST["mdp"] ?? '';

    if (empty($login) || empty($mdp)) {
        header("Location: ../index.php?error=Veuillez remplir tous les champs.");
        exit;
    }

    $controller = new LoginController();
    $controller->login($login, $mdp);
} else {
    header("Location: ../index.php?error=Requête invalide.");
    exit;
}
