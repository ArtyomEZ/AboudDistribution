<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use Model\BO\SousCategorieBO;
use Model\BO\CategorieBO;
use PDO;


class ProduitDAO
{
    private $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllProduits(): array {
        $produits = [];

        try {
            $query = "SELECT * FROM Produit";

            $stmt = $this->bdd->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produit = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',
                    new SousCategorieBO($row['id_sous_cat'], '', '')
                );
                $produits[] = $produit;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des produits : " . $e->getMessage();
        }
        return $produits;
    }

    public function getProduitById(int $id_prod): ?ProduitBO
    {
        try {
            // Récupération du produit
            $query = "SELECT * FROM produit WHERE id_prod = ?";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([$id_prod]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null; // Aucun produit trouvé
            }

            // Récupération de la sous-catégorie
            $querySousCat = "SELECT * FROM sous_categorie WHERE id_sous_cat = ?";
            $stmtSousCat = $this->bdd->prepare($querySousCat);
            $stmtSousCat->execute([$row['id_sous_cat']]);
            $rowSousCat = $stmtSousCat->fetch(PDO::FETCH_ASSOC);

            if (!$rowSousCat) {
                return null; // Sous-catégorie introuvable
            }

            // Récupération de la catégorie
            $queryCat = "SELECT * FROM categorie WHERE id_cat = ?";
            $stmtCat = $this->bdd->prepare($queryCat);
            $stmtCat->execute([$rowSousCat['id_cat']]);
            $rowCat = $stmtCat->fetch(PDO::FETCH_ASSOC);

            if (!$rowCat) {
                return null; // Catégorie introuvable
            }

            // Création de l'objet CategorieBO
            $categorie = new CategorieBO($rowCat['id_cat'], $rowCat['nom_cat']);

            // Création de l'objet SousCategorieBO
            $souscat = new SousCategorieBO($rowSousCat['id_sous_cat'], $rowSousCat['nom_sous_cat'], $rowSousCat['id_cat']);

            // Création et retour de l'objet ProduitBO
            return new ProduitBO(
                $row['id_prod'],
                $row['nom_prod'],
                $row['desc_prod'],
                $row['marq_prod'],
                $row['prix_prod'],
                $row['img_prod'],
                $souscat
            );

        } catch (\Exception $e) {
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
            return null;
        }
    }



    public function createProduit(ProduitBO $produit): bool {
        try {
            $query = "INSERT INTO produit (id_prod, nom_prod, desc_prod, marq_prod, prix_prod, img_prod, id_sous_cat) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->bdd->prepare($query);

            $res = $stmt->execute([
                $produit->getIdProd(),
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getSouscat()->getIdSouscat()
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }

    public function updateProduit(ProduitBO $produit): bool {
        try {
            $query = "UPDATE produit 
                  SET nom_prod = ?, desc_prod = ?, marq_prod = ?, prix_prod = ?, img_prod = ?, id_sous_cat = ? 
                  WHERE id_prod = ?";
            $stmt = $this->bdd->prepare($query);

            $res = $stmt->execute([
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getSouscat()->getIdSousCat(),
                $produit->getIdProd()
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la mise à jour du produit : " . $e->getMessage();
            return false;
        }
    }

    public function searchProduits(string $searchTerm): array {
        $produits = [];

        try {
            $query = "SELECT * FROM produit
                  JOIN type_produit t ON p.id_typ_prod = t.id_typ_prod
                  WHERE p.nom_prod LIKE :searchTerm";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['searchTerm' => "%$searchTerm%"]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produit = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',
                    new SousCategorieBO($row['id_sous_cat'], '')
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
}