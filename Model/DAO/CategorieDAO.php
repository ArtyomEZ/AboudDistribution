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

    // Nouvelle méthode pour récupérer les pièces d'une sous-catégorie



    public function getInfosByCategorie(string $sousCategorie): array {
        try {
            $sql = "SELECT p.* FROM Produit p
                JOIN sous_categorie sc ON p.id_sous_cat = sc.id_sous_cat
                WHERE sc.nom_sous_cat = ?"; // Filtrer par sous-catégorie

            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$sousCategorie]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result ?: []; // Retourne un tableau vide si aucun résultat
        } catch (Exception $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return [];
        }
    }



}