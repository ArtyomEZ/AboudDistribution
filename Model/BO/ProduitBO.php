<?php

namespace Model\BO;

class ProduitBO
{

    private int $id_prod;
    private string $nom_prod;
    private string $desc_prod;
    private string $mar_prod;
    private int $prix_prod;
    private string $img_prod;

    /**
     * @param int $id_prod
     * @param string $nom_prod
     * @param string $desc_prod
     * @param string $mar_prod
     * @param int $prix_prod
     * @param string $img_prod
     */
    public function __construct(int $id_prod, string $nom_prod, string $desc_prod, string $mar_prod, int $prix_prod, string $img_prod)
    {
        $this->id_prod = $id_prod;
        $this->nom_prod = $nom_prod;
        $this->desc_prod = $desc_prod;
        $this->mar_prod = $mar_prod;
        $this->prix_prod = $prix_prod;
        $this->img_prod = $img_prod;
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

    public function getMarProd(): string
    {
        return $this->mar_prod;
    }

    public function setMarProd(string $mar_prod): void
    {
        $this->mar_prod = $mar_prod;
    }

    public function getPrixProd(): int
    {
        return $this->prix_prod;
    }

    public function setPrixProd(int $prix_prod): void
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


}