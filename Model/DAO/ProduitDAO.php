<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use PDO;
use function Sodium\add;

class ProduitDAO
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getAllProduits(): array
    {
        $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                     p.img_prod, tp.id_typ_prod, tp.lib_typ_prod
              FROM Produit p
              INNER JOIN TYPE_PRODUIT tp ON p.id_typ_prod = tp.id_typ_prod";

        $stmt = $this->bdd->prepare($query);
        $stmt->execute();

        $produits = [];
        while ($row = $stmt->fetch()) {
            // Construire l'objet TypeProduitBO
            $typeProduit = new TypeProduitBO(
                $row['id_typ_prod'],
                $row['lib_typ_prod']
            );

            // Construire l'objet ProduitBO avec le TypeProduitBO associé
            $produit = new ProduitBO(
                $row['id_prod'],
                $row['nom_prod'],
                $row['desc_prod'],
                $row['marq_prod'],
                $row['prix_prod'],
                $row['img_prod'] ?? 'pas d\'image',
                $typeProduit // Associer l'objet TypeProduitBO
            );

            $produits[] = $produit;
        }

        return $produits;
    }

    public function createProduit(ProduitBO $produit): bool {
        try {
            $query = "INSERT INTO produit (nom_prod, desc_prod, marq_prod, prix_prod, img_prod, id_typ_prod) 
                  VALUES (?, ?, ?, ?, ?, ?)";
            // Préparation de la requête
            $stmt = $this->bdd->prepare($query);

            // Exécution de la requête avec les données du produit
            $res = $stmt->execute([
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getIdTypProd()->getIdTypProd()
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


    public function deleteProduit($id_prod) {
        $query = "DELETE FROM produit WHERE id_prod = ?"; // Utilisation de ? pour le paramètre

        
        $stmt = $this->bdd->prepare($query);

        
        $stmt->execute([$id_prod]);
    }

    public function getProduitsByType(int $id_typ_prod): array
    {
        $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, 
                     p.img_prod, tp.id_typ_prod, tp.lib_typ_prod
              FROM Produit p
              INNER JOIN TYPE_PRODUIT tp ON p.id_typ_prod = tp.id_typ_prod
              WHERE tp.id_typ_prod = ?";

        $stmt = $this->bdd->prepare($query);
        $stmt->execute([$id_typ_prod]);

        $produits = [];
        while ($row = $stmt->fetch()) {
            $typeProduit = new TypeProduitBO(
                $row['id_typ_prod'],
                $row['lib_typ_prod']
            );

            $produit = new ProduitBO(
                $row['id_prod'],
                $row['nom_prod'],
                $row['desc_prod'],
                $row['marq_prod'],
                $row['prix_prod'],
                $row['img_prod'] ?? 'pas d\'image',
                $typeProduit
            );

            $produits[] = $produit;
        }

        return $produits;
    }

}