<?php

namespace Model\DAO;

use Model\BO\AdministrateurBO;

class AdministrateurDAO
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function createAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "INSERT INTO Administrateur (login_admin, mdp_admin) VALUES (?, ?)";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $administrateur->getLoginAdmin(),
                $administrateur->getMdpAdmin()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la création de l'administrateur : " . $e->getMessage();
            return false;
        }
    }

    public function updateAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "UPDATE Administrateur SET login_admin = ?, mdp_admin = ? WHERE id_admin = ?";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $administrateur->getIdAdmin(),
                $administrateur->getNomAdmin(),
                $administrateur->getMdpAdmin()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la mise à jour de l'administrateur : " . $e->getMessage();
            return false;
        }
    }

    public function deleteAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "DELETE FROM Administrateur WHERE id_admin = ?";
            $stmt = $this->bdd->prepare($query);

            $result = $stmt->execute([
                $administrateur->getIdAdmin()
            ]);

            return $result;
        } catch (\Exception $e) {
            echo "Erreur lors de la suppression de l'administrateur : " . $e->getMessage();
            return false;
        }
    }
}