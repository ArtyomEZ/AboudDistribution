<?php

class CategorieBO {
    private $id_cat;
    private $nom_cat;

    // Constructeur
    public function __construct($id_cat, $nom_cat) {
        $this->id_cat = $id_cat;
        $this->nom_cat = $nom_cat;
    }

    // Getters et Setters
    public function getIdCat() {
        return $this->id_cat;
    }

    public function setIdCat($id_cat) {
        $this->id_cat = $id_cat;
    }

    public function getNomCat() {
        return $this->nom_cat;
    }

    public function setNomCat($nom_cat) {
        $this->nom_cat = $nom_cat;
    }
}

?>
