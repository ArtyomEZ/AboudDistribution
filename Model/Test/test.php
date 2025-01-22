<?php

use Model\DAO\ProduitsDAO;
use Model\BDDManager;

require_once '../BDDManager.php';
require_once '../DAO/ProduitsDAO.php';
require_once '../BO/ProduitBO.php';


$bdd = initialiseConnexionBDD();



$produit = new ProduitsDAO($bdd);

$produits = new \Model\BO\ProduitBO(0,'Roue','Un excellent pneu','Michelin',55, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.istockphoto.com%2Ffr%2Fphotos%2Froue-de-voiture&psig=AOvVaw37PXZ-nEWB86gBojXYEoVT&ust=1737536690689000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCLjlk9y6hosDFQAAAAAdAAAAABAE');

$a = $produit->getAllProduits();

var_dump($a);

