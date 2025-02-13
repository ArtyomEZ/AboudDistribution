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

    public function getAllCategories()
    {
        $query = "SELECT * FROM categorie";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute();

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new CategorieBO(
                $row['id_cat'],
                $row['nom_cat']
            );
        }

        return $categories;
    }

}