<?php

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/UtilisateurDAO.php';

use Model\DAO\AdministrateurDAO;
use Model\DAO\UtilisateurDAO;

class LoginController
{
    private UtilisateurDAO $utilisateurDAO;
    public function __construct() {
        $bdd = initialiseConnexionBDD();
        $this->utilisateurDAO = new UtilisateurDAO($bdd);
    }

    public function login(string $login, string $password): bool {

        echo "LoginController::login() exécuté !<br>";
        echo "Login reçu : " . htmlspecialchars($login) . "<br>";
        echo "Mot de passe reçu : " . htmlspecialchars($password) . "<br>";

        session_start();

        try {
            $utilisateur = $this->utilisateurDAO->getUtilisateurByLogin($login);

            if ($utilisateur) {
                echo "Utilisateur trouvé : " . htmlspecialchars($utilisateur->getLoginUti()) . "<br>";

                if (password_verify($password, $utilisateur->getMdpUti())) {
                    echo "Mot de passe correct !<br>";
                }
            }

            if ($utilisateur && password_verify($password, $utilisateur->getMdpUti())) {
                $_SESSION['user_id'] = $utilisateur->getIdUti();
                $_SESSION['login_uti'] = $utilisateur->getLoginUti();
                header("Location: ../View/pageProduits.php");
                exit;
            } else {
                $_SESSION['error'] = "Identifiants incorrects.";
                return false;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur serveur.";
            return false;
        }
    }
}