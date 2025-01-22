<?php

class AdminController
{
    public function dashboard()
    {
        try {
            $this->ensureLoggedInAs('administrateur');

            $login = ($_SESSION['login']);
            $mdp = ($_SESSION['mdp']);

            include "../View/header.php";
            include "../View/gestion.php";
        } catch (\Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    private function ensureLoggedInAs($role)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
            throw new \Exception("Vous devez être connecté en tant que $role pour accéder à cette page.");
        }
    }

    private function redirectWithError($message)
    {
        header("Location: ../../index.php?error=" . urlencode($message));
        exit;
    }


    public function ajoutProduit()
    {
        try {
            $this->ensureLoggedInAs('administrateur');
            $bdd = initialiseConnexionBDD();

        } catch (\Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }
}

?>