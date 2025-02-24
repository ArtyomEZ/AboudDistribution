<?php

require_once '../Model/BO/UtilisateurBO.php';
use Model\BO\UtilisateurBO;


class UtilisateurDAO
{
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function createUtilisateur(string $login,string $adr, string $hashedPassword): bool {
        try {
            $sql = "INSERT INTO utilisateur (login_uti, mdp_uti,adr_uti) VALUES (?, ?,?)";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute(
                [$login,
                $adr,
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

        $sql = "SELECT * FROM utilisateur WHERE login_uti = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$login]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            return new UtilisateurBO(
                $result['id_uti'],
                $result['login_uti'],
                $result['mdp_uti'],
                $result['adr_uti']
            );

        } else {
            echo "Aucun utilisateur trouvé avec ce login.<br>";
            return null;
        }
    }
    public function editUtilisateur(int $id, string $newLogin, string $newHashedPassword, string $newAdr): bool {
        try {
            $sql = "UPDATE utilisateur SET login_uti = ?, mdp_uti = ?, adr_uti = ? WHERE id_uti = ?";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$newLogin, $newHashedPassword,$newAdr, $id]);

            return true;
        } catch (Exception $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return false;
        }
    }

}