<?php

class LoginController
{
    public function login($login, $mdp)
    {

        $bdd = initialiseConnexionBDD();
        if (!$bdd) {
            $this->redirectWithError("Impossible de se connecter à la base de données.");
        }

        $user = null;
        $role = null;

        try {
            $administrateurDAO = new AdministrateurDAO($bdd);
            $user = $administrateurDAO->authentification($login, $mdp);
            if ($user) {
                $role = "administrateur";
            }
        } catch (\Exception $e) {
            $this->redirectWithError("Erreur lors de l'authentification : " . $e->getMessage());
        }

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

        header("Location: ../Controller/AdminController.php?action=dashboard");
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
