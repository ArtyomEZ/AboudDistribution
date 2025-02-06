<?php
require_once '../Controller/RegisterController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $registerController = new RegisterController();
    $registerSuccess = $registerController->register($_POST['login_uti'], $_POST['mdp_uti']);

    if ($registerSuccess) {
        header("Location: pageConnexion.php");
        exit;
    } else {
        echo "<p style='color: red;'>Échec de l'inscription.</p>";
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/connexion.css">
</head>
<body class="main-body">
<div class="content">
    <div class="auth-container">
        <h2>Inscription</h2>
        <form method="POST">
            <input type="text" name="login_uti" placeholder="Nom d'utilisateur" required>
            <input type="password" name="mdp_uti" placeholder="Mot de passe" required>
            <button type="submit" name="submit">S'inscrire</button>
        </form>
        <div class="auth-register-link">
            <p>Déjà un compte ? <a href="pageConnexion.php">Connectez-vous</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
