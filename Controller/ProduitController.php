<?php

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/BO/TypeProduitBO.php';
require_once '../Model/BDDManager.php';

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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // 💾 Récupération des données du formulaire
                    $nom_prod = $_POST['nom_prod'] ?? '';
                    $desc_prod = $_POST['desc_prod'] ?? '';
                    $marq_prod = $_POST['marq_prod'] ?? '';
                    $prix_prod = (float)($_POST['prix_prod'] ?? 0);
                    $id_typ_prod = (int)($_POST['id_typ_prod'] ?? 0);
                    $img_prod = $_FILES['img_prod']['name'] ?? 'pas d\'image';

                    // 🖼️ Upload de l'image
                    if ($_FILES['img_prod']['error'] === UPLOAD_ERR_OK) {
                        $targetDir = "uploads/";
                        $targetFile = $targetDir . basename($_FILES["img_prod"]["name"]);
                        move_uploaded_file($_FILES["img_prod"]["tmp_name"], $targetFile);
                    }

                    // 🛠️ Création des objets BO
                    $typeProduit = new TypeProduitBO($id_typ_prod, '');
                    $produit = new ProduitBO(0, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $typeProduit);

                    // 🔥 Appel au DAO
                    $bdd = initialiseConnexionBDD();
                    $produitDAO = new ProduitDAO($bdd);
                    $result = $this->$produitDAO()->createProduit($produit);
                    return $result ? "✅ Produit ajouté avec succès !" : "❌ Erreur lors de l'ajout du produit.";
                } catch (\Exception $e) {
                    return "❌ Erreur : " . $e->getMessage();
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
            //$this->ensureLoggedInAs('administrateur');

            $bdd = initialiseConnexionBDD();

            include "../View/header.php";
            include "../View/suppProduit.php";
            include "../View/footer.php";
        }
    } catch (\Exception $e) {
        $this->redirectWithError($e->getMessage());}
    }

    public function suppProduitBDD()
    {
        try {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                //$this->ensureLoggedInAs('administrateur');

                $id_prod = $_POST['id_prod'];

                $bdd = initialiseConnexionBDD();
                $produitDAO = new ProduitDAO($bdd);
                $result = $this->$produitDAO()->suppProduit($id_prod);
                return $result ? "✅ Produit suppprimé avec succès !" : "❌ Erreur lors de la suppression du produit.";
            }
        } catch (\Exception $e) {
            return "❌ Erreur : " . $e->getMessage();
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] ===  'ajoutProduitBDD') {
    $controller = new ProduitController();
    $controller->ajoutProduitBDD();
}


?>