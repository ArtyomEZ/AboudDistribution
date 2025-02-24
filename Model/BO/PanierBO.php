<?php

namespace Model\BO;

use Model\BO\UtilisateurBO;
use Model\BO\ProduitBO;

class PanierBO {
    private int $id;
    private UtilisateurBO $utilisateur;
    private ProduitBO $produit;
    private int $quantite;

    public function __construct(UtilisateurBO $utilisateur, ProduitBO $produit, int $quantite , int $id ) {
        $this->id = $id;
        $this->utilisateur = $utilisateur;
        $this->produit = $produit;
        $this->quantite = $quantite;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getUtilisateur(): UtilisateurBO {
        return $this->utilisateur;
    }

    public function getProduit(): ProduitBO {
        return $this->produit;
    }

    public function getQuantite(): int {
        return $this->quantite;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUtilisateur(UtilisateurBO $utilisateur): void {
        $this->utilisateur = $utilisateur;
    }

    public function setProduit(ProduitBO $produit): void {
        $this->produit = $produit;
    }

    public function setQuantite(int $quantite): void {
        $this->quantite = $quantite;
    }
}
?>
