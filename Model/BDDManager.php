<?php

namespace Model;

use Exception;
use PDO;

class BDDManager
{
    function initialiseConnexionBDD() {
        $bdd = null;
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=AbouDistribution;charset=utf8',
                'root',
                ''
            );
        } catch(Exception $e) {
            die('Erreur connexion BDD : '.$e->getMessage());
        }

        return $bdd;
    }

}