<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use PDO;

class ProduitDAO
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllProduits(): array {
        try {
            $query = "SELECT * FROM produit";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $produits = 0;

            return $produits;
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des produits : " . $e->getMessage();
            return 0;
        }
    }
    public function createProduit(ProduitBO $produit): bool {
        try {
            $query = "INSERT INTO produit (id_prod, nom_prod, desc_prod, marque_prod, prix_prod, image_prod) 
                  VALUES (?, ?, ?, ?, ?, ?)";
            // Préparation de la requête
            $stmt = $this->bdd->prepare($query);

            // Exécution de la requête avec les données du produit
            $res = $stmt->execute([
                $produit->getIdProd(),
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImageProd()
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }

   /* public function updateProduit(ProduitBO $entity) {
        $query = "UPDATE produit 
              SET nom_prod = ?, desc_prod = ?, mar_prod = ?, prix_prod = ? 
              WHERE id_prod = ?"; // Utilisation de ? pour les paramètres

        // Préparation de la requête
        $stmt = $this->bdd->prepare($query);

        // Exécution de la requête avec les données mises à jour du produit
        $res = $stmt->execute([
            $entity->getIdProd(),
            $entity->getNomProd(),
            $entity->getDescProd(),
            $entity->getMarProd(),
            $entity->getPrixProd(),
            $entity->getIdProd(),
        ]);

        // Retourner l'objet produit si la mise à jour a réussi
        return $res ? $entity : false;
    }

*/
    public function deleteProduit($id_prod) {
        $query = "DELETE FROM produit WHERE id_prod = ?"; // Utilisation de ? pour le paramètre

        
        $stmt = $this->bdd->prepare($query);

        
        $stmt->execute([$id_prod]);
    }






}