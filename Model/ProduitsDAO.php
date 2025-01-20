<?php

namespace Model;

use Model\BO\ProduitBO;
use PDO;

class ProduitsDAO
{

    private $bdd;
    private PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProduits() {
        $resultSet = null;
        $query = "SELECT * FROM produit";
        $stmt = $this->bdd->query($query);
        if ($stmt) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt as $row) {
                $resultSet[] = new ProduitBO($row['id_prod'], $row['nom_prod'], $row['desc_prod'], $row['mar_prod'], $row['prix_prod']);
            }
        }

        return $resultSet;
    }


    public function insertProduit(ProduitBO $entity): ?ProduitBO {
        $resultSet = NULL;
        $query = "INSERT INTO produit (nom_prod, desc_prod, mar_prod, prix_prod) 
              VALUES (?, ?, ?, ?)";
        // Préparation de la requête
        $stmt = $this->bdd->prepare($query);

        // Exécution de la requête avec les données du produit
        $res = $stmt->execute([
            $entity->getNomProd(),
            $entity->getDescProd(),
            $entity->getMarProd(),
            $entity->getPrixProd(),
        ]);


        if ($res) {
            $entity->setIdProd($this->bdd->lastInsertId());
            $resultSet = $entity;
        }

        return $resultSet;
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