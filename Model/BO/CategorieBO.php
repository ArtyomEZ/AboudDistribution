<?php

namespace Model\BO;

class CategorieBO
{
    public int $id_cat;
    public String $nom_cat;

    /**
     * @param int $id_cat
     * @param String $nom_cat
     */
    public function __construct(int $id_cat, string $nom_cat)
    {
        $this->id_cat = $id_cat;
        $this->nom_cat = $nom_cat;
    }

    public function getIdCat(): int
    {
        return $this->id_cat;
    }

    public function setIdCat(int $id_cat): void
    {
        $this->id_cat = $id_cat;
    }

    public function getNomCat(): string
    {
        return $this->nom_cat;
    }

    public function setNomCat(string $nom_cat): void
    {
        $this->nom_cat = $nom_cat;
    }

}