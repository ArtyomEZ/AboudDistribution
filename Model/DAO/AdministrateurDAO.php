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
            return $stmt->execute([
                $administrateur->getLoginAdmin(),
                $administrateur->getMdpAdmin()
            ]);
        } catch (\Exception $e) {
            error_log("Erreur création administrateur : " . $e->getMessage());
            return false;
        }
    }

    public function updateAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "UPDATE Administrateur SET login_admin = ?, mdp_admin = ? WHERE id_admin = ?";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                $administrateur->getLoginAdmin(),
                $administrateur->getMdpAdmin(),
                $administrateur->getIdAdmin() // Correct order
            ]);
        } catch (\Exception $e) {
            error_log("Erreur mise à jour administrateur : " . $e->getMessage());
            return false;
        }
    }

    public function deleteAdministrateur(AdministrateurBO $administrateur): bool
    {
        try {
            $query = "DELETE FROM Administrateur WHERE id_admin = ?";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([$administrateur->getIdAdmin()]);
        } catch (\Exception $e) {
            error_log("Erreur suppression administrateur : " . $e->getMessage());
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

            if (!$adminData || !isset($adminData['mdp_admin'])) {
                return null; // Admin non trouvé
            }

            if (password_verify($password, $adminData['mdp_admin'])) {
                $admin = new AdministrateurBO();
                $admin->setIdAdmin($adminData['id_admin']);
                $admin->setLoginAdmin($adminData['login_admin']);
                return $admin;
            } else {
                return null; // Mauvais mot de passe
            }
        } catch (\Exception $e) {
            error_log("Erreur lors de la connexion admin : " . $e->getMessage());
            return null;
        }
    }
}
