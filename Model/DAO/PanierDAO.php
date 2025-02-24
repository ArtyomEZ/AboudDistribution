<?php

namespace Model\DAO;

use PDO;
use Model\BO\PanierBO;
use Model\BO\UtilisateurBO;
use Model\BO\ProduitBO;
require_once('../Model/BO/ProduitBO.php');

class PanierDAO {
    private PDO $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    // Ajouter un produit au panier ou mettre à jour la quantité
    public function ajouterAuPanier(PanierBO $panier): bool {
        $sql = "INSERT INTO panier (id_utilisateur, id_produit, quantite)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE quantite = quantite + ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([
            $panier->getUtilisateur()->getIdUti(),
            $panier->getProduit()->getIdProd(),
            $panier->getQuantite(),
            $panier->getQuantite()
        ]);
    }

    // Récupérer le panier d'un utilisateur
    public function getPanierUtilisateur(int $idUtilisateur): array {
        $sql = "SELECT p.id, p.quantite, 
                       u.id_uti, u.login_uti AS nom_utilisateur,u.mdp_uti,u.adr_uti, 
                       pr.id_prod, pr.nom_prod,pr.desc_prod,pr.marq_prod, pr.prix_prod, pr.img_prod,pr.id_sous_cat
                FROM panier p
                JOIN utilisateur u ON p.id_utilisateur = u.id_uti
                JOIN produit pr ON p.id_produit = pr.id_prod
                WHERE p.id_utilisateur = ?";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$idUtilisateur]);

        $panier = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur = new UtilisateurBO($row['id_uti'], $row['nom_utilisateur'],$row['mdp_uti'], $row['adr_uti']);
            $produit = new ProduitBO($row['id_prod'], $row['nom_prod'],$row['desc_prod'],$row['marq_prod'], $row['prix_prod'], $row['img_prod'], $row['id_sous_cat']);
            $panier[] = new PanierBO($utilisateur, $produit, $row['quantite'], $row['id']);
        }
        return $panier;
    }

    // Modifier la quantité d'un produit dans le panier
    public function modifierQuantite($idUtilisateur, $idProduit, $increment) {
        // Vérifie si la quantité actuelle est 1 et l'utilisateur clique sur "decrease"
        $sqlCheck = "SELECT quantite FROM panier WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
        $stmtCheck = $this->bdd->prepare($sqlCheck);
        $stmtCheck->execute(['idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        $quantiteActuelle = $stmtCheck->fetchColumn();

        // Si la quantité devient 0, on supprime l'article du panier
        if ($quantiteActuelle + $increment <= 0) {
            $sqlDelete = "DELETE FROM panier WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
            $stmtDelete = $this->bdd->prepare($sqlDelete);
            $stmtDelete->execute(['idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        } else {
            $sqlUpdate = "UPDATE panier SET quantite = quantite + :increment WHERE id_utilisateur = :idUtilisateur AND id_produit = :idProduit";
            $stmtUpdate = $this->bdd->prepare($sqlUpdate);
            $stmtUpdate->execute(['increment' => $increment, 'idUtilisateur' => $idUtilisateur, 'idProduit' => $idProduit]);
        }
    }
    // Supprimer un produit du panier
    public function supprimerProduit(int $idUtilisateur, int $idProduit): bool {
        $sql = "DELETE FROM panier WHERE id_utilisateur = ? AND id_produit = ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$idUtilisateur, $idProduit]);
    }

    // Vider le panier d'un utilisateur
    public function viderPanier(int $idUtilisateur): bool {
        $sql = "DELETE FROM panier WHERE id_utilisateur = ?";
        $stmt = $this->bdd->prepare($sql);
        return $stmt->execute([$idUtilisateur]);
    }
}
?>
