<?php

namespace Model\BO;

class SousCategorieBO
{

    /**
     * @param int $id_sous_cat
     */
    {
        $this->id_sous_cat = $id_sous_cat;
        $this->nom_sous_cat = $nom_sous_cat;
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

    {
    }

    {
    }
}