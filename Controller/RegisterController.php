<?php

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/UtilisateurDAO.php';

class RegisterController
{
    private $utilisateurDAO;

    public function __construct() {
        $bdd = initialiseConnexionBDD();
        $this->utilisateurDAO = new UtilisateurDAO($bdd);
    }

    public function register(string $login, string $password, string $email): bool {
        echo "RegisterController::register() exécuté !<br>";

        // Vérification si l'utilisateur existe déjà
        $existingUser = $this->utilisateurDAO->getUtilisateurByLogin($login);
        if ($existingUser) {
            echo "⚠ Utilisateur déjà existant !<br>";
            return false;
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Créer un nouvel utilisateur
        $result = $this->utilisateurDAO->createUtilisateur($login, $hashedPassword, $email);

        if ($result) {
            echo "✅ Utilisateur créé avec succès !<br>";
            return true;
        } else {
            echo "❌ Erreur lors de la création de l'utilisateur.<br>";
            return false;
        }
    }
}
?>
