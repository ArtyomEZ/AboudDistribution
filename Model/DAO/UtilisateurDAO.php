<?php

namespace Model\DAO;

use Model\BO\UtilisateurBO;
use PDO;

class UtilisateurDAO
{
    private PDO $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function getUtilisateurByLogin(string $login): ?UtilisateurBO {
        $stmt = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $stmt->execute(['id_uti' => $login]);
        $user = $stmt->fetch();

        return $user ? new UtilisateurBO($user['id_uti'], $user['login_uti'], $user['mdp_uti']) : null;
    }
}