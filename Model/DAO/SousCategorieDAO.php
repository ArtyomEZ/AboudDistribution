<?php

namespace Model\DAO;

use Model\BO\SousCategorieBO;
use PDO;

class SousCategorieDAO
{
    private $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function createSousCategorie(SousCategorieBO $souscategorie): bool
    {
        try {
            $query = "INSERT INTO Sous_Categorie (id_sous_cat, nom_sous_cat, id_cat) VALUES (?, ?, ?)";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $souscategorie->getIdSousCat(),
                $souscategorie->getNomSousCat(),
                $souscategorie->getCat()->getIdCat()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la création de la sous catégorie : " . $e->getMessage();
            return false;
        }
    }

    public function getAllSousCategories(): array {
        $souscategories = [];

        try {
            $query = "SELECT * FROM Sous_Categorie";

            $stmt = $this->bdd->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $souscategorie = new SousCategorieBO(
                    $row['id_sous_cat'],
                    $row['nom_sous_cat'],
                    $row['id_cat']
                );
                $souscategories[] = $souscategorie;
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération des sous catégories : " . $e->getMessage();
        }
        return $souscategories;
    }

    public function getSousCategoriesByCategorieId(int $id_cat): array
    {
        $query = "SELECT * FROM sous_categorie WHERE id_cat = ?";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([$id_cat]);  // Utilise un tableau, pas un tableau associatif

        $sousCategories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Vérifie ce qui est récupéré depuis la base de données
            var_dump($row);  // Ajoute cette ligne pour déboguer

            $sousCategories[] = new SousCategorieBO(
                $row['id_sous_cat'],
                $row['nom_sous_cat'],
                $row['id_cat']
            );
        }

        return $sousCategories;
    }


}