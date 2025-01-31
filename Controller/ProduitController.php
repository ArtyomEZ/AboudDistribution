<?php /*

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;

require_once '../Model/BDDManager.php';
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/DAO/ProduitDAO.php';

class ProduitController
{
    private $produitDAO;
    private $typeProduitDAO;

    public function __construct() {
        $bdd = initialiseConnexionBDD();
        $this->produitDAO = new ProduitDAO($bdd);
        $this->typeProduitDAO = new TypeProduitDAO($bdd);
    }

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

            $daoProduit = new ProduitDAO($bdd);
            $typesProduits = $daoProduit->getAllProduits();
            $typeProduitDAO = new TypeProduitDAO($bdd);
            $typesProduits = $typeProduitDAO->getAllTypeProduits();

            include "../View/header.php";
            include "../View/pageAjoutProduit.php";
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

    public function modifProduitPage() {
        $produits = $this->produitDAO->getAllProduits();
        $typesProduits = $this->typeProduitDAO->getAllTypeProduits();
        $produitActuel = null;

        if (isset($_GET['id_prod'])) {
            $id_prod = (int) $_GET['id_prod'];
            $produitActuel = $this->produitDAO->getProduitById($id_prod);
        }

        include '../View/header.php';
        include '../Views/pageModifProduit.php';
        include "../View/footer.php";
    }

    public function modifProduitBDD()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifProduit'])) {
                //$this->ensureLoggedInAs('administrateur');

                $id_prod = $_POST['id_prod'];
                $nom_prod = $_POST['nom_prod'] ?? '';
                $desc_prod = $_POST['desc_prod'] ?? '';
                $marq_prod = $_POST['marq_prod'] ?? 'pas d\'image';
                $prix_prod = $_POST['prix_prod'] ?? 0;
                $img_prod = $_POST['img_prod'] ?? '';
                $id_typ_prod = (int)$_POST['id_typ_prod'];

                if (!empty($nom_prod) && !empty($desc_prod) && !empty($marq_prod) && $prix_prod > 0 && $id_typ_prod > 0) {
                    $typeProduit = new TypeProduitBO($id_typ_prod, '');
                    $produitModifie = new ProduitBO($id_prod, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $typeProduit);

                    if ($this->produitDAO->updateProduit($produitModifie)) {
                        header("Location: modifierProduit.php?id_prod=$id_prod&success=1");
                        exit();
                    } else {
                        header("Location: modifierProduit.php?id_prod=$id_prod&error=1");
                        exit();
                    }

                    return $result ? "✅ Produit suppprimé avec succès !" : "❌ Erreur lors de la suppression du produit.";
                }
            } return "Erreur de méthode";
        } catch (\Exception $e) {
            return "❌ Erreur : " . $e->getMessage();
        }
    }


if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ProduitController();
    try {
        switch ($_GET['action']) {
            case 'pageAjoutProduit':
                $controller->ajoutProduitPage();
                break;
            case 'pageModifProduit':
                $controller->modifProduitPage();
                break;
            case 'pageSupprimerProduit':
                $controller->suppProduitPage();
                break;
        }
    } catch (\Exception $e) {
        $this->redirectWithError($e->getMessage());
        exit;
    }

}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] ===  'ajoutProduitBDD') {
    $controller = new ProduitController();
    $controller->ajoutProduitBDD();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'suppProduitBDD') {
    $controller = new ProduitController();
    $controller->suppProduitBDD();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'modifProduitBDD') {
    $controller = new ProduitController();
    $controller->modifProduitBDD();
}

*/?>

<?php

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use Model\DAO\ProduitDAO;
use Model\DAO\TypeProduitDAO;

require_once '../Model/DAO/ProduitDAO.php';
require_once '../Model/DAO/TypeProduitDAO.php';
require_once '../Model/BDDManager.php';
require_once '../Model/BO/ProduitBO.php';
require_once '../Model/BO/TypeProduitBO.php';

class ProduitController {
    private $produitDAO;
    private $typeProduitDAO;

    public function __construct() {
        $bdd = initialiseConnexionBDD();
        $this->produitDAO = new ProduitDAO($bdd);
        $this->typeProduitDAO = new TypeProduitDAO($bdd);
    }

    public function pageModifProduit() {
        $produits = $this->produitDAO->getAllProduits();
        $typesProduits = $this->typeProduitDAO->getAllTypeProduits();
        $produitActuel = null;

        if (isset($_GET['id_prod'])) {
            $id_prod = (int) $_GET['id_prod'];
            $produitActuel = $this->produitDAO->getProduitById($id_prod);
        }

        include '../View/pageModifProduit.php';
    }

    public function modifProduitBDD() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_prod = (int) $_POST['id_prod'];
            $nom_prod = $_POST['nom_prod'] ?? '';
            $desc_prod = $_POST['desc_prod'] ?? '';
            $marq_prod = $_POST['marq_prod'] ?? '';
            $prix_prod = $_POST['prix_prod'] ?? 0;
            $img_prod = $_POST['img_prod'] ?? '';
            $id_typ_prod = (int) $_POST['id_typ_prod'];

            if (!empty($nom_prod) && !empty($desc_prod) && !empty($marq_prod) && $prix_prod > 0 && $id_typ_prod > 0) {
                $typeProduit = new TypeProduitBO($id_typ_prod, '');
                $produitModifie = new ProduitBO($id_prod, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $typeProduit);

                $success = $this->produitDAO->updateProduit($produitModifie);

                if ($success) {
                    header("Location: pageModifProduit.php?id_prod=$id_prod&success=1");
                    exit();
                } else {
                    header("Location: pageModifProduit.php?id_prod=$id_prod&error=1");
                    exit();
                }
            }
        }
    }

    public function pageAjoutProduit() {
        $typesProduits = $this->typeProduitDAO->getAllTypeProduits();

        include '../View/header.php';
        include '../View/pageModifProduit.php';
        include '../View/footer.php';
    }

    public function ajoutProduitBDD() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_prod = $_POST['nom_prod'] ?? '';
            $desc_prod = $_POST['desc_prod'] ?? '';
            $marq_prod = $_POST['marq_prod'] ?? '';
            $prix_prod = isset($_POST['prix_prod']) ? (float) $_POST['prix_prod'] : 0;
            $img_prod = $_POST['img_prod'] ?? 'pas d\'image';
            $id_typ_prod = isset($_POST['id_typ_prod']);

            if (!empty($nom_prod) && !empty($desc_prod) && !empty($marq_prod) && $prix_prod > 0 && $id_typ_prod > 0) {
                try {
                    $typeProduit = new TypeProduitBO($id_typ_prod, '');

                    $produit = new ProduitBO(0, $nom_prod, $desc_prod, $marq_prod, $prix_prod, $img_prod, $typeProduit);

                    $success = $this->produitDAO->createProduit($produit);

                    if ($success) {
                        header("Location: ../View/pageAjoutProduit.php?success=1");
                        exit();
                    } else {
                        header("Location: pageAjoutProduit.php?error=1");
                        exit();
                    }
                } catch (Exception $e) {
                    die("Erreur lors de l'ajout du produit : " . $e->getMessage());
                }
            } else {
                header("Location: pageAjoutProduit.php?error=1");
                exit();
            }
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new ProduitController();

    if ($_GET['action'] === 'modifProduit') {
        $controller->pageModifProduit();
    } elseif ($_GET['action'] === 'modifProduitBDD') {
        $controller->modifProduitBDD();
    }

    else if ($_GET['action'] === 'pageAjoutProduit') {
        $controller->pageAjoutProduit();
    } else if ($_GET['action'] === 'ajoutProduitBDD') {
        $controller->ajoutProduitBDD();
    }
}
?>