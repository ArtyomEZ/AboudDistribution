<?php

namespace Model\DAO;

use CategorieBO;
use Model\BO\ProduitBO;
use Model\BO\SousCategorieBO;
use PDO;

require_once('../Model/BO/CategorieBO.php');
require_once('../Model/BO/SousCategorieBO.php');

class ProduitDAO
{
    private $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllProduits(): array {
        $produits = [];

        try {
            // Requête SQL mise à jour pour récupérer les données nécessaires
            $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                         p.img_prod, p.id_sous_cat, s.nom_sous_cat, s.id_cat 
                  FROM produit p
                  JOIN sous_categorie s ON p.id_sous_cat = s.id_sous_cat";

            $stmt = $this->bdd->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Création de l'objet CategorieBO avec l'id_cat
                $categorie = new CategorieBO($row['id_cat'], 'Nom de la catégorie'); // Exemple de nom de catégorie

                // Création de l'objet SousCategorieBO
                $sousCategorie = new SousCategorieBO($row['id_sous_cat'], $row['nom_sous_cat'], $categorie);

                // Création de l'objet ProduitBO avec l'objet SousCategorieBO
                $produit = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',  // Valeur par défaut si img_prod est null
                    $row['id_sous_cat'] // Passer l'ID au lieu de l'objet
                );

                $produits[] = $produit;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des produits : " . $e->getMessage();
        }

        return $produits;
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
                $produit->getMarProd(),
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
}
