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

    public function ajoutProduitPage()
    {
        try {
            $this->ensureLoggedInAs('administrateur');

            $bdd = initialiseConnexionBDD();

            include "../View/header.phop";
            include "../View/ajoutProduit.php";
            include  "../View/footer.php";
        } catch (\Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }
    public function ajoutProduitBDD()
    {
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->ensureLoggedInAs('administrateur');
                $bdd = initialiseConnexionBDD();
                $produitDAO = new ProduitDAO($bdd);

                $nom = htmlspecialchars($_POST['nom']);
                $desc = htmlspecialchars($_POST['desc']);
                $prix = htmlspecialchars($_POST['prix']);
                $image = htmlspecialchars($_POST['image']);
                $marque = htmlspecialchars($_POST['marque']);

                $produit = new Produit(0, $nom, $desc, $prix, $image, $marque);
                $success = $produitDAO->createProduit($produit);

                if($success) {
                    header('Location: ?action=gestionProduit');
                } else {
                    throw new \Exception("Erreur lors de l'ajout du produit.");
                }
            }
        } catch (\Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    public function suppProduitPage()
    {
        try {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->ensureLoggedInAs('administrateur');

            $bdd = initialiseConnexionBDD();

            include "../View/header.php";
            include "../View/suppProduit.php";
            include "../View/footer.php";
        }
    } catch (\Exception $e) {
        $this->redirectWithError($e->getMessage());}
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] ===  'ajoutProduitBDD') {
    $controller = new AdminController();
    $controller->ajoutProduitBDD();
}

?>