<?php

namespace Model\BO;

use CategorieBO;

class SousCategorieBO
{
    private int $id_sous_cat;
    private string $nom_sous_cat;
    private \CategorieBO $categorie; // Un objet CategorieBO associé

    /**
     * @param int $id_sous_cat
     * @param string $nom_sous_cat
     * @param CategorieBO $categorie
     */
    public function __construct(int $id_sous_cat, string $nom_sous_cat, CategorieBO $categorie)
    {
        $this->id_sous_cat = $id_sous_cat;
        $this->nom_sous_cat = $nom_sous_cat;
        $this->categorie = $categorie; // On associe la catégorie à la sous-catégorie
    }

    // Getters et Setters

    public function getIdSousCat(): int
    {
        return $this->id_sous_cat;
    }

    public function setIdSousCat(int $id_sous_cat): void
    {
        $this->id_sous_cat = $id_sous_cat;
    }

    public function getNomSousCat(): string
    {
        return $this->nom_sous_cat;
    }

    public function setNomSousCat(string $nom_sous_cat): void
    {
        $this->nom_sous_cat = $nom_sous_cat;
    }

    // Getter et Setter pour l'objet CategorieBO
    public function getCategorie(): CategorieBO
    {
        return $this->categorie;
    }

    public function setCategorie(CategorieBO $categorie): void
    {
        $this->categorie = $categorie;
    }
}
?>
