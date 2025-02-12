<?php

namespace Model\BO;

class SousCategorieBO
{
    public int $id_sous_cat;
    public String $nom_sous_cat;
    public int $id_cat;

    /**
     * @param int $id_sous_cat
     * @param String $nom_sous_cat
     * @param int $id_cat
     */
    public function __construct(int $id_sous_cat, string $nom_sous_cat, int $id_cat)
    {
        $this->id_sous_cat = $id_sous_cat;
        $this->nom_sous_cat = $nom_sous_cat;
        $this->id_cat = $id_cat;
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

    public function getIdCat(): int
    {
        return $this->id_cat;
    }

    public function setIdCat(int $id_cat): void
    {
        $this->id_cat = $id_cat;
    }

}