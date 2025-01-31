<?php

require_once '../Controller/LoginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    echo "Envoi des données à AuthController...<br>";

    $loginController = new LoginController();
    $loginController->login($_POST['login_uti'], $_POST['mdp_uti']);

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Formulaire soumis !<br>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

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
<br>

<body class="main-body">
    <div class="content">
        <div class="auth-container">
            <h2>Connexion</h2>
            <form method="POST">
                <input type="text" name="login_uti" placeholder="Nom d'utilisateur" required>
                <input type="password" name="mdp_uti" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
            <div class="auth-register-link">
                <p>Pas encore inscrit ? <a href="#">Créer un compte</a></p>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>

</body>
</html>