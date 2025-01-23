<?php

namespace Model\BO;

class TypeProduitBO
{
    private int $id_typ_prod;
    private String $lib_typ_prod;

    public function typeProduit($id_typ_prod, $lib_typ_prod) {
        $this->id_typ_prod = $id_typ_prod;
        $this->lib_typ_prod = $lib_typ_prod;
    }
 
    public function getIdTypProd(): int
    {
        return $this->id_typ_prod;
    }

    public function setIdTypProd(int $id_typ_prod): void
    {
        $this->id_typ_prod = $id_typ_prod;
    }

    public function getLibTypProd(): string
    {
        return $this->lib_typ_prod;
    }

    public function setLibTypProd(string $lib_typ_prod): void
    {
        $this->lib_typ_prod = $lib_typ_prod;
    }

}