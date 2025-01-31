<?php

namespace Model\DAO;

use Model\BO\ProduitBO;
use Model\BO\TypeProduitBO;
use PDO;
use PDOException;

require_once('../Model/BO/TypeProduitBO.php');

class ProduitDAO
{
    private PDO $bdd;

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
            $query = "INSERT INTO produit (nom_prod, desc_prod, marq_prod, prix_prod, img_prod, id_typ_prod) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->bdd->prepare($query);

            $res = $stmt->execute([
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarqProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getTypProd()->getIdTypProd()
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }

    public function updateProduit(ProduitBO $produit): bool {
        try {
            $query = "UPDATE produit SET nom_prod = ?, desc_prod = ?, marq_prod = ?, prix_prod = ?, img_prod = ?, id_typ_prod = ?
                  WHERE id_prod = ?";

            $stmt = $this->bdd->prepare($query);

            $res = $stmt->execute([
                $produit->getNomProd(),
                $produit->getDescProd(),
                $produit->getMarqProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getTypProd()->getIdTypProd(),
                $produit->getIdProd(),
            ]);

            return $res;
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour du produit : " . $e->getMessage());
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

    public function getProduitById(int $id_prod): ?ProduitBO {
        try {
            $query = "SELECT p.id_prod, p.nom_prod, p.desc_prod, p.marq_prod, p.prix_prod, p.img_prod, 
                         t.id_typ_prod, t.lib_typ_prod
                  FROM produit p
                  INNER JOIN type_produit t ON p.id_typ_prod = t.id_typ_prod
                  WHERE p.id_prod = :id_prod";

            $stmt = $this->bdd->prepare($query);
            $stmt->bindValue(':id_prod', $id_prod, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Création de l'objet TypeProduitBO
                $typeProduit = new TypeProduitBO(
                    $result['id_typ_prod'],
                    $result['lib_typ_prod']
                );

                // Création de l'objet ProduitBO avec les informations récupérées
                return new ProduitBO(
                    $result['id_prod'],
                    $result['nom_prod'],
                    $result['desc_prod'],
                    $result['marq_prod'],
                    $result['prix_prod'],
                    $result['img_prod'] ?? 'pas d\'image',
                    $typeProduit
                );
            } else {
                return null; // Aucun produit trouvé
            }
        } catch (PDOException $e) {
            die("Erreur lors de la récupération du produit : " . $e->getMessage());
        }
    }

}