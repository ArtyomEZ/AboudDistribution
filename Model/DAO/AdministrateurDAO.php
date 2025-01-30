<?php

namespace Model\DAO;

use Model\BO\AdministrateurBO;
use PDO;

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
                $administrateur->getLoginAdmin(),
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

    public function loginAdmin(string $login, string $password): ?AdministrateurBO
    {
        try {
            $query = "SELECT * FROM Administrateur WHERE login_admin = ?";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([$login]);

            $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($adminData && password_verify($password, $adminData['mot_de_passe'])) {
                // Création de l'objet AdministrateurBO avec les données récupérées
                $admin = new AdministrateurBO();
                $admin->setIdAdmin($adminData['id_admin']);

                $admin->setLoginAdmin($adminData['login_admin']); // Assure-toi que le setter existe

                return $admin; // Retourne l'objet administrateur connecté
            } else {
                return null; // Identifiants incorrects
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la connexion : " . $e->getMessage();
            return null;
        }
    }
}