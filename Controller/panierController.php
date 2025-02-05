<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produit']) && isset($_POST['action'])) {
    $idProduit = $_POST['id_produit'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$idProduit])) {
        if ($action === "augmenter") {
            $_SESSION['cart'][$idProduit]['quantity']++;
        } elseif ($action === "diminuer") {
            $_SESSION['cart'][$idProduit]['quantity']--;
            if ($_SESSION['cart'][$idProduit]['quantity'] <= 0) {
                unset($_SESSION['cart'][$idProduit]); // Supprime l'article si la quantité atteint 0
            }
        } elseif ($action === "supprimer") {
            unset($_SESSION['cart'][$idProduit]); // Supprime l'article du panier
        }
    }
}

// Redirection vers la page panier

header("Location: ../View/panier.php");
exit();

