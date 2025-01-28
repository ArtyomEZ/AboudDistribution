<?php

use Model\BO\ProduitBO;
use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;

class ProduitController
{
    private $bdd;

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

            include "../View/header.php";
            include "../View/pageCreationProduit.php";
            include  "../View/footer.php";
        } catch (\Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }
    public function ajoutProduitBDD()
    {
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                //$this->ensureLoggedInAs('administrateur');
                $bdd = initialiseConnexionBDD();
                $produitDAO = new ProduitDAO($bdd);

                $nom = htmlspecialchars($_POST['nom_prod']);
                $desc = htmlspecialchars($_POST['desc_prod']);
                $marque = htmlspecialchars($_POST['marq_prod']);
                $prix = htmlspecialchars($_POST['prix_prod']);
                $img = htmlspecialchars($_POST['img_prod']);
                $id_typ_prod = htmlspecialchars($_POST['id_typ_prod']);

                $typeProduitDAO = new TypeProduitDAO($this->bdd);
                $typeProduit = $typeProduitDAO->getTypeProduitById($id_typ_prod);

                if (!$typeProduit) {
                    throw new \Exception("Le type de produit sélectionné est invalide !");
                }

                $produit = new ProduitBO(0, $nom, $desc, $marque, $prix, $img, $typeProduit);
                $success = $produitDAO->createProduit($produit);

                if($success) {
                   // header('Location: ?action=gestionProduit');
                    echo('AJOUT REUSSI');
                } else {
                    throw new \Exception("Erreur lors de l'ajout du produit.");
                }
            } else {
                echo "Méthode non autorisée";
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
    $controller = new ProduitController();
    $controller->ajoutProduitBDD();
}

?>