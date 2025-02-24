<?php

namespace Model\DAO;

use Exception;
use PDO;

class CategorieDAO
{
private $bdd;
    public function __construct($bdd) {
        if ($bdd === null) {
            die("La connexion à la base de données a échoué.");
        }
        $this->bdd = $bdd;
    }
    public function getInfosByCategorie(string $categorie): array {
        try {
            $sql = "SELECT p.* FROM Produit p
                JOIN sous_categorie sc ON p.id_sous_cat = sc.id_sous_cat
                JOIN categorie c ON sc.id_cat = c.id_cat
                WHERE c.nom_cat = ?";

            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$categorie]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: []; // Retourne un tableau vide si aucun résultat
        } catch (Exception $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return [];
        }
    }


}