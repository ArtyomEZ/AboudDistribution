<?php

namespace Model\DAO;

use Model\BO\TypeProduitBO;
use PDO;

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

    public function getAllTypeProduits(): array
    {
        $query = "SELECT id_typ_prod, lib_typ_prod FROM TYPE_PRODUIT";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute();

        $typesProduits = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $typeProduit = new TypeProduitBO(
                $row['id_typ_prod'],
                $row['lib_typ_prod']
            );

            $typesProduits[] = $typeProduit;
        }

        return $typesProduits;
    }

    public function getTypeProduitById(int $id_typ_prod): ?TypeProduitBO
    {
        $query = "SELECT id_typ_prod, lib_typ_prod FROM TYPE_PRODUIT WHERE id_typ_prod = ?";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([$id_typ_prod]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new TypeProduitBO(
                $row['id_typ_prod'],
                $row['lib_typ_prod']
            );
        }

        return null;
    }
}