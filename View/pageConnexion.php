<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/connexion.css">
</head>
<body class="main-body">
<?php include 'header.php'; ?>

<div class="content">
    <div class="auth-container">
        <h2>Connexion</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
        <form action="../Controller/LoginController.php" method="post">
            <input type="text" name="login" placeholder="Nom d'utilisateur" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <div class="auth-register-link">
            <p>Pas encore inscrit ? <a href="pageInscription.php">Créer un compte</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
