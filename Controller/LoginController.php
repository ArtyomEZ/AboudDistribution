<?php

<<<<<<< Updated upstream
use Model\DAO\AdministrateurDAO;

class LoginController
{
    public function login($login, $mdp): void
    {

=======
use Model\BO\UtilisateurBO;

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/UtilisateurDAO.php';

class LoginController
{
    private UtilisateurDAO $utilisateurDAO;

    public function __construct() {
>>>>>>> Stashed changes
        $bdd = initialiseConnexionBDD();
        if (!$bdd) {
            $this->redirectWithError("Impossible de se connecter à la base de données.");
        }

<<<<<<< Updated upstream
        $user = null;
        $role = null;

        try {
            $administrateurDAO = new AdministrateurDAO($bdd);
            $user = $administrateurDAO->loginAdmin($login, $mdp);
            if ($user) {
                $role = "administrateur";
=======
    public function login(string $login, string $password): bool {
        echo "LoginController::login() exécuté !<br>";

        session_start();

        try {
            echo "🔍 Recherche de l'utilisateur dans la base...<br>";
            $utilisateur = $this->utilisateurDAO->getUtilisateurByLogin($login);

            if (!$utilisateur) {
                echo "❌ Aucun utilisateur trouvé avec ce login.<br>";
                return false;
>>>>>>> Stashed changes
            }
        } catch (\Exception $e) {
            $this->redirectWithError("Erreur lors de l'authentification : " . $e->getMessage());
        }

<<<<<<< Updated upstream
        if ($user && $role) {
            $this->startSession($user, $role);
        } else {
            $this->redirectWithError("Identifiants incorrects ou utilisateur introuvable.");
        }
    }

    private function StartSession($user, $role)
    {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['id'] = $user->getAdminId();
        $_SESSION['login'] = $user->getAdminLogin();
        $_SESSION['mdp'] = $user->getAdminMdp();
        $_SESSION['role'] = $role;

        header("Location: ../Controller/ProduitController.php?action=dashboard");
    }

    private function redirectWithError($message)
    {
        header("Location: ../../index.php?error=" . urlencode($message));
        exit;
    }
}

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST["login"];
        $mdp = $_POST["mdp"];

        if(empty($login)) {
            header("Location: ../index.php?error=Le champ login est obligatoire.");
        }

        if(empty($mdp)) {
            header("Location: ../index.php?error=Le champ mdp est obligatoire.");
        }

        $controller = new LoginController();
        $controller->login($login, $mdp);
    } else {
        header("Location: ../index.php?error=Requête invalide.");
        exit;
    }
=======
            echo "✅ Utilisateur trouvé : " . htmlspecialchars($utilisateur->getLoginUti()) . "<br>";

            // Affichage du mot de passe haché stocké en base pour comparer
            echo "🔑 Mot de passe stocké (hash) : " . $utilisateur->getMdpUti() . "<br>";

            if (password_verify($password, $utilisateur->getMdpUti())) {
                echo "✅ Mot de passe correct !<br>";
                $_SESSION['user_id'] = $utilisateur->getIdUti();
                $_SESSION['login_uti'] = $utilisateur->getLoginUti();
                header("Location: ../View/pageProduits.php");
                exit;
            } else {
                echo "❌ Mot de passe incorrect.<br>";
                return false;
            }
        } catch (Exception $e) {
            echo "❌ Erreur serveur : " . $e->getMessage() . "<br>";
            return false;
        }
    }

}
>>>>>>> Stashed changes
