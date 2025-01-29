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
            $query = "SELECT * FROM produit p
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
                $produit->getMarqProd(),
                $produit->getPrixProd(),
                $produit->getImgProd(),
                $produit->getTypProd()->getIdTypProd() // Récupération de l’ID du TypeProduitBO
            ]);

            return $res;
        } catch (\Exception $e) {
            echo "Erreur lors de la création du produit : " . $e->getMessage();
            return false;
        }
    }

    public function updateAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "UPDATE Administrateur SET login_admin = ?, mdp_admin = ? WHERE id_admin = ?";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $administrateur->getIdAdmin(),
                $administrateur->getLoginAdmin(),
                $administrateur->getMdpAdmin()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la mise à jour de l'administrateur : " . $e->getMessage();
            return false;
        }
    }public function updateProduit(ProduitBO $produit): bool
{
    try {
        $query = "UPDATE Produit SET nom_prod = ?, desc_prod = ?, marq_prod = ?, prix_prod = ?, img_prod = ?, id_typ_prod = ? WHERE id_prod = ?";
        $stmt = $this->bdd->prepare($query);

        $result = $stmt->execute([
            $produit->getNomProd(),
            $produit->getDescProd(),
            $produit->getMarqProd(),
            $produit->getPrixProd(),
            $produit->getImgProd(),
            $produit->getTypProd()->getIdTypProd(),
            $produit->getIdProd()
        ]);

        return $result;
    } catch (\Exception $e) {
        echo "Erreur lors de la mise à jour de l'administrateur : " . $e->getMessage();
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

    public function getProduitById($id_prod)
    {
        try {
            $query = "SELECT * FROM Produit WHERE id_prod = ?";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(
                [$id_prod]
            );

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return new ProduitBO(
                    $result['id_prod'],
                    $result['nom_prod'],
                    $result['desc_prod'],
                    $result['marq_prod'],
                    $result['prix_prod'],
                    $result['img_prod'] ?? 'pas d\'image',
                    new TypeProduitBO(
                        $result['id_typ_prod'], ''
                    )
                );
            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération du produit : " . $e->getMessage();
        }
    }
}

