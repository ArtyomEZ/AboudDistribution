<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pièces Auto - Vente en ligne</title>
    <link type="text/css" rel="stylesheet" href="css/Accueil.css">
    <link type="text/css" rel="stylesheet" href="css/header.css">
</head>
<body class="home-page">

<?php
include ('header.php');
?>
<?php
session_start();
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
    unset($_SESSION['error_message']); // Supprime le message après l'affichage
}
?>
<div class="container">
    <h2>Nos produits</h2>
    <div class="products">
    </div>
</div>


<?php
include ('footer.php');
?>
</body>
</html>