<?php

namespace Model\BO;
namespace Model\BO;

class ProduitBO
{
    private $id_prod;
    private $nom_prod;
    private $desc_prod;
    private $marq_prod;
    private $prix_prod;
    private $img_prod;
    private $id_typ_prod;  // Changez le nom si nécessaire

    public function __construct(int $id_prod, string $nom_prod, string $desc_prod, string $marq_prod, float $prix_prod, string $img_prod, int $id_typ_prod) {
        $this->id_prod = $id_prod;
        $this->nom_prod = $nom_prod;
        $this->desc_prod = $desc_prod;
        $this->marq_prod = $marq_prod;
        $this->prix_prod = $prix_prod;
        $this->img_prod = $img_prod;
        $this->id_typ_prod = $id_typ_prod;  // Accepte un int ici, pas un objet
    }

    public function getIdProd(): int
    {
        return $this->id_prod;
    }

    public function setIdProd(int $id_prod): void
    {
        $this->id_prod = $id_prod;
    }

    public function getNomProd(): string
    {
        return $this->nom_prod;
    }

    public function setNomProd(string $nom_prod): void
    {
        $this->nom_prod = $nom_prod;
    }

    public function getDescProd(): string
    {
        return $this->desc_prod;
    }

    public function setDescProd(string $desc_prod): void
    {
        $this->desc_prod = $desc_prod;
    }

    public function getMarqProd(): string
    {
        return $this->marq_prod;
    }

    public function setMarqProd(string $marq_prod): void
    {
        $this->marq_prod = $marq_prod;
    }

    public function getPrixProd(): float
    {
        return $this->prix_prod;
    }

    public function setPrixProd(float $prix_prod): void
    {
        $this->prix_prod = $prix_prod;
    }

    public function getImgProd(): string
    {
        return $this->img_prod;
    }

    public function setImgProd(string $img_prod): void
    {
        $this->img_prod = $img_prod;
    }

    public function getIdTypProd(): int
    {
        return $this->id_typ_prod;
    }

    public function setIdTypProd(int $id_typ_prod): void
    {
        $this->id_typ_prod = $id_typ_prod;
    }


}
