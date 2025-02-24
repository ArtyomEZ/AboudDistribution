<?php

namespace Model\DAO;

use CategorieBO;
use Exception;
use Model\BO\ProduitBO;
use Model\BO\SousCategorieBO;
use PDO;

require_once('../Model/BO/CategorieBO.php');
require_once('../Model/BO/SousCategorieBO.php');
require_once('../Model/BO/ProduitBO.php');
require_once('../Model/DAO/PanierDAO.php');

class ProduitDAO
{
    private $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getInfosByCategorie(string $sousCategorie): array {
        try {
            $sql = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.prix_prod, p.marq_prod, p.img_prod, p.id_sous_cat
                FROM Produit p
                JOIN sous_categorie sc ON p.id_sous_cat = sc.id_sous_cat
                WHERE sc.nom_sous_cat = ?";

            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$sousCategorie]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $produits = [];
            foreach ($result as $row) {
                $produit = new \Model\BO\ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'],
                    $row['id_sous_cat'] ?? 0 // Ajout d'une valeur par défaut
                );

                $produits[] = $produit;
            }

            return $produits;
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return [];
        }
    }

    public function getAllProduits(): array {
        $produits = [];

        try {
            $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                         p.img_prod, p.id_sous_cat, s.nom_sous_cat, s.id_cat 
                  FROM produit p
                  JOIN sous_categorie s ON p.id_sous_cat = s.id_sous_cat";

            $stmt = $this->bdd->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer les résultats sous forme de tableau associatif

            foreach ($result as $row) {
                $produits[] = new \Model\BO\ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '', // Gérer le cas où l'image est NULL
                    $row['id_sous_cat']
                );
            }
        } catch (\Exception $e) {
            error_log("Erreur lors de la récupération des produits : " . $e->getMessage());
        }

        return $produits;
    }

    // Nouvelle méthode getProduitById
    public function getProduitById(int $id_prod): ?ProduitBO {
        try {
            $sql = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.prix_prod, p.marq_prod, p.img_prod, p.id_sous_cat
                    FROM produit p
                    WHERE p.id_prod = ?";

            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$id_prod]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new \Model\BO\ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',
                    $row['id_sous_cat']
                );
            } else {
                return null; // Produit non trouvé
            }
        } catch (\Exception $e) {
            error_log("Erreur SQL lors de la récupération du produit par ID : " . $e->getMessage());
            return null; // Retourner null en cas d'erreur
        }
    }

    public function createProduit(ProduitBO $produit): bool {
        try {
            $query = "INSERT INTO produit (id_prod, nom_prod, desc_prod, marq_prod, prix_prod, img_prod, id_sous_cat) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->bdd->prepare($query);

            // Passer l'ID de la sous-catégorie au lieu de l'objet complet
            $res = $stmt->execute([
                $produit->getIdProd(),
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarqProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getIdTypProd() // Passer l'ID de SousCategorieBO
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }

    public function searchProduits(string $searchTerm): array {
        $produits = [];

        try {
            $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                         p.img_prod, p.id_sous_cat, s.nom_sous_cat 
                  FROM produit p
                  JOIN sous_categorie s ON p.id_sous_cat = s.id_sous_cat
                  WHERE p.nom_prod LIKE :searchTerm";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['searchTerm' => "%$searchTerm%"]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Passer uniquement l'ID de la sous-catégorie dans l'objet ProduitBO
                $produit = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',
                    $row['id_sous_cat'] // Passer l'ID de la sous-catégorie
                );
                $produits[] = $produit;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la recherche des produits : " . $e->getMessage();
        }

        return $produits;
    }

    public function deleteProduit($id_prod) {
        try {
            $query = "DELETE FROM produit WHERE id_prod = ?";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([$id_prod]);
        } catch (\Exception $e) {
            echo "Erreur lors de la suppression du produit : " . $e->getMessage();
        }
    }
    public function modifierQuantite($idUtilisateur, $idProduit, $increment) {
        // Vérifie si la quantité actuelle est 1 et l'utilisateur clique sur "decrease"
        $sqlCheck = "SELECT quantite FROM panier WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
        $stmtCheck = $this->bdd->prepare($sqlCheck);
        $stmtCheck->execute(['idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        $quantiteActuelle = $stmtCheck->fetchColumn();

        // Si la quantité devient 0, on supprime l'article du panier
        if ($quantiteActuelle + $increment <= 0) {
            $sqlDelete = "DELETE FROM panier WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
            $stmtDelete = $this->bdd->prepare($sqlDelete);
            $stmtDelete->execute(['idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        } else {
            $sqlUpdate = "UPDATE panier SET quantite = quantite + :increment WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
            $stmtUpdate = $this->bdd->prepare($sqlUpdate);
            $stmtUpdate->execute(['increment' => $increment, 'idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        }
    }
}
