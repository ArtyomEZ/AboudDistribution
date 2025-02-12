<?php

namespace Model\DAO;
use Model\BO\CategorieBO;
use PDO;

class CategorieDAO
{
    private $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function createCategorie(CategorieBO $categorie): bool
    {
        try {
            $query = "INSERT INTO Categorie (id_cat, nom_cat) VALUES (?, ?)";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $categorie->getIdCat(),
                $categorie->getNomCat()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la création de la catégorie : " . $e->getMessage();
            return false;
        }
    }

    public function getAllCategories(): array {
        $categories = [];

        try {
            $query = "SELECT * FROM Categorie";

            $stmt = $this->bdd->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorie = new CategorieBO(
                    $row['id_cat'],
                    $row['nom_cat'],
                );
                $categories[] = $categorie;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des catégories : " . $e->getMessage();
        }
        return $categories;
    }

}