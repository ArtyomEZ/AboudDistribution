<?php

require_once '../Model/BO/UtilisateurBO.php';
use Model\BO\UtilisateurBO;


class UtilisateurDAO
{
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function createUtilisateur(string $login, string $hashedPassword): bool {
        try {
            $sql = "INSERT INTO utilisateur (login_uti, mdp_uti) VALUES (?, ?)";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute(
                [$login,
                $hashedPassword]
            );

            return true;
        } catch (Exception $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return false;
        }
    }

    public function getUtilisateurByLogin(string $login): ?UtilisateurBO
    {
        echo "getUtilisateurByLogin() appelé avec : " . htmlspecialchars($login) . "<br>";

        $sql = "SELECT * FROM utilisateur WHERE login_uti = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$login]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "Utilisateur trouvé dans la BDD !<br>";
            return new UtilisateurBO(
                $result['id_uti'],
                $result['login_uti'],
                $result['mdp_uti'],
                $result['adr_mail']
            );

        } else {
            echo "Aucun utilisateur trouvé avec ce login.<br>";
            return null;
        }
    }

}