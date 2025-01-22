<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use PDO;

class ProduitsDAO
{

    private $bdd;
    private PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProduits(): array {
        try {
            $query = "SELECT * FROM produit";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $produits = [];
            foreach ($result as $row) {
                $produits[] = new ProduitBO(
                    $row['id_prod'],
                    $row['nom_prod'],
                    $row['desc_prod'],
                    $row['mar_prod'],
                    $row['prix_prod'],
                    $row['img_prod'],
                );
            }

            return $produits;
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des produits : " . $e->getMessage();
            return [];
        }
    }


    public function create(ProduitBO $produit): bool {
        try {
            $query = "INSERT INTO produit (id_prod, nom_prod, desc_prod, mar_prod, prix_prod, img_prod) 
                  VALUES (?, ?, ?, ?, ?, ?)";
            // Préparation de la requête
            $stmt = $this->pdo->prepare($query);

            // Exécution de la requête avec les données du produit
            $res = $stmt->execute([
                $produit->getIdProd(),
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }


    public function updateProduit(ProduitBO $entity) {
        $query = "UPDATE produit 
              SET nom_prod = ?, desc_prod = ?, mar_prod = ?, prix_prod = ? 
              WHERE id_prod = ?"; // Utilisation de ? pour les paramètres

        // Préparation de la requête
        $stmt = $this->bdd->prepare($query);

        // Exécution de la requête avec les données mises à jour du produit
        $res = $stmt->execute([
            $entity->getNomProd(),
            $entity->getDescProd(),
            $entity->getMarProd(),
            $entity->getPrixProd(),
            $entity->getIdProd(),
        ]);

        // Retourner l'objet produit si la mise à jour a réussi
        return $res ? $entity : false;
    }



    public function deleteProduit($id_prod) {
        $query = "DELETE FROM produit WHERE id_prod = ?"; // Utilisation de ? pour le paramètre

        
        $stmt = $this->bdd->prepare($query);

        
        $stmt->execute([$id_prod]);
    }






}