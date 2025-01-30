
<?php
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
