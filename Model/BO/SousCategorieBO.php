<?php

namespace Model\BO;

class SousCategorieBO
{
    public int $id_sous_cat;
    public String  $nom_sous_cat;
    public int $id_categorie;

    /**
     * @param int $id_sous_cat
     * @param String $nom_sous_cat
     * @param int $id_categorie
     */
    public function __construct(int $id_sous_cat, string $nom_sous_cat, int $id_categorie)
    {
        $this->id_sous_cat = $id_sous_cat;
        $this->nom_sous_cat = $nom_sous_cat;
        $this->id_categorie = $id_categorie;
    }

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

    public function getIdCategorie(): int
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(int $id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

}