<?php
include 'header.php';

require_once '../Model/DAO/UtilisateurDAO.php'; // Inclure le DAO qui gère la BDD
require_once '../Model/BO/UtilisateurBO.php';
require_once  '../Model/BDDManager.php';

$bdd = initialiseConnexionBDD();

$utilisateurDAO = new UtilisateurDAO($bdd); // Instancier l'objet DAO

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    echo "Utilisateur non connecté";
    exit;
}

$login = $_SESSION['login'];
$utilisateur = $utilisateurDAO->getUtilisateurByLogin($login);

if ($utilisateur) {
    $loginValue = htmlspecialchars($utilisateur->getLoginUti());
    $mdpValue = htmlspecialchars($utilisateur->getMdpUti()); // ⚠️ Ne jamais afficher un mot de passe en clair !
} else {
    $loginValue = "";
    $mdpValue = "";
}


?>

<link type="text/css" rel="stylesheet" href="css/paramètre.css">
<body>
<div class="main-content">
    <form action="../Controller/EditController.php" method="post" class="login-form">
        <h2>Modifier mes informations</h2>
        <input type="text" name="login" value="<?= $loginValue ?>" placeholder="Nom d'utilisateur" required>
        <input type="text" name="mdp"  placeholder="Mot de passe" required>
        <button type="submit">Modifier</button>
    </form>
</div>

<p><?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
        echo "<p class='success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }

    ?></p>

</body>
<?php
include 'footer.php';