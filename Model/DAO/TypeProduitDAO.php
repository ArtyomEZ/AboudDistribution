<?php

namespace Model\DAO;

use Model\BO\TypeProduitBO;

class TypeProduitDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function createTypeProduit(TypeProduitBO $typeproduit): bool
    {
        try {
            $query = "INSERT INTO TypeProduit (lib_typ_prod) VALUES (?)";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $typeproduit->getLibTypProd()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du type de produit : " . $e->getMessage();
            return false;
        }
    }

    public function updateTypeProduit(TypeProduitBO $typeproduit): bool
    {
        try {
            $query = "UPDATE TypeProduit SET lib_typ_prod = ? WHERE id_typ_prod = ?";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $typeproduit->getIdTypProd(),
                $typeproduit->getLibTypProd()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la mise à jour du type du produit : " . $e->getMessage();
            return false;
        }
    }

    public function deleteTypeProduit(TypeProduitBO $typeproduit): bool
    {
        try {
            $query = "DELETE FROM TypeProduit WHERE id_typ_prod = ?";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $typeproduit->getIdTypProd()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la suppression du type du produit : " . $e->getMessage();
            return false;
        }
    }
}