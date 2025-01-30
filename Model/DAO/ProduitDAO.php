<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO; // Import de TypeProduitBO
use PDO;

require_once('../Model/BO/TypeProduitBO.php'); // Inclure TypeProduitBO si nécessaire

class ProduitDAO
{
    private $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllProduits(): array {
        $produits = [];

        try {
            $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                         p.img_prod, p.id_typ_prod, t.lib_typ_prod 
                  FROM produit p
                  JOIN type_produit t ON p.id_typ_prod = t.id_typ_prod"; // 🔥 Correction ici

            $stmt = $this->bdd->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produit = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['marq_prod'],
                    $row['prix_prod'],
                    $row['img_prod'] ?? '',
                    new TypeProduitBO($row['id_typ_prod'], $row['lib_typ_prod']) // 🔥 Correction ici
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
            $query = "INSERT INTO produit (id_prod, nom_prod, desc_prod, marq_prod, prix_prod, img_prod, id_typ_prod) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->bdd->prepare($query);

            $res = $stmt->execute([
                $produit->getIdProd(),
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getIdProd() // Récupération de l’ID du TypeProduitBO
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
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
