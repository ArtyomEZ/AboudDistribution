
<?php
<<<<<<< Updated upstream
=======

require_once '../Controller/LoginController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginController = new LoginController();
    $loginSuccess = $loginController->login($_POST['login_uti'], $_POST['mdp_uti']);

    if (!$loginSuccess) {
        echo "<p style='color: red;'>Échec de la connexion.</p>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Formulaire soumis !<br>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

>>>>>>> Stashed changes
include  'header.php';
?>

<br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/connexion.css">
</head>
<br>
<BR>
<body class="main-body">
<div class="content">
    <div class="auth-container">
        <h2>Connexion</h2>
        <form>
            <input type="text" placeholder="Nom d'utilisateur" required>
            <input type="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <div class="auth-register-link">
            <p>Pas encore inscrit ? <a href="#">Créer un compte</a></p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
