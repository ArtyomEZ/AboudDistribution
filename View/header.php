<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>

<header class="main-header">
    <nav class="header-navigation">
        <a href="pageAccueil.php">Accueil</a>
        <a href="pageProduits.php">Nos Produits</a>
        <a href="pageContact.php">Contact</a>

        <?php if (!empty($_SESSION['login'])): ?>
        <div class="dropdown">   <a href="pageParam.php"><span class="user-name">👤 <?= htmlspecialchars($_SESSION['login']) ?></span></a>
            <div class="dropdown-content"><a href="../Controller/LogoutController.php" class="logout-btn">Se Déconnecter</a></div></div>
        <?php else: ?>
            <a href="pageConnexion.php" class="login-btn">Se Connecter</a>
        <?php endif; ?>
    </nav>
    </nav>

    <!-- Titre principal -->
    <div class="header-top">
        <h1>Aboud Distribution</h1>
    </div>

    <!-- Conteneur regroupant la barre de recherche et les catégories -->
    <div class="search-and-categories">
        <form action="../Controller/rechercheController.php">
        <!-- Barre de recherche -->
        <div class="search-bar">
            <input type="search" name="search" placeholder="Rechercher une pièce...">
            <button >Rechercher</button>
        </form>
        </div>

        <!-- Catégories en dessous -->
        <nav class="dropdown-menu">
            <!-- Moteur et Transmission -->
            <div class="dropdown">
                <button class="dropdown-btn">Moteur et Transmission</button>
                <div class="dropdown-content">

                    <a href="pageCategorie.php?categorie=alternateur">Alternateur</a>
                    <a href="pageCategorie.php?categorie=courroie">Courroie de Distribution</a>
                    <a href="pageCategorie.php?categorie=embrayage">Embrayage</a>

                </div>
            </div>

            <!-- Suspension, Direction et Freinage -->
            <div class="dropdown">
                <button class="dropdown-btn">Suspension, Direction </button>
                <div class="dropdown-content">
                    <a href="pageCategorie.php?categorie=amortisseur">Amortisseurs</a>
                    <a href="pageCategorie.php?categorie=ressort">Ressorts de Suspension</a>
                    <a href="pageCategorie.php?categorie=rotule">Rotules de Direction</a>
                    <a href="pageCategorie.php?categorie=barre-stabilisatrice">Barre Stabilisatrice</a>
                    <hr>
                    <a href="pageCategorie.php?categorie=disque-frein">Disques de Frein</a>
                    <a href="pageCategorie.php?categorie=plaquette-frein">Plaquettes de Frein</a>

                </div>
            </div>

            <!-- Refroidissement et Échappement -->
            <div class="dropdown">
                <button class="dropdown-btn">Refroidissement </button>
                <div class="dropdown-content">
                    <a href="pageCategorie.php?categorie=pompe-eau">Pompe à Eau</a>
                    <a href="pageCategorie.php?categorie=thermostat">Thermostat</a>

                </div>
            </div>

            <!-- Électricité et Électronique -->
            <div class="dropdown">
                <button class="dropdown-btn">Électricité et Électronique</button>
                <div class="dropdown-content">
                    <a href="pageCategorie.php?categorie=batterie">Batterie</a>
                    <a href="pageCategorie.php?categorie=bougie-allumage">Bougies d'Allumage</a>
                    <a href="pageCategorie.php?categorie=cablage-electrique">Câblage Électrique</a>
                    <a href="pageCategorie.php?categorie=capteur">Capteurs</a>
                    <a href="pageCategorie.php?categorie=ecu">Unité de Contrôle Électronique (ECU)</a>
                </div>
            </div>

            <!-- Système d'Alimentation -->
            <div class="dropdown">
                <button class="dropdown-btn">Alimentation en Carburant</button>
                <div class="dropdown-content">
                    <a href="pageCategorie.php?categorie=pompe-carburant">Pompe à Carburant</a>
                    <a href="pageCategorie.php?categorie=injecteur">Injecteurs</a>
                    <a href="pageCategorie.php?categorie=filtre-carburant">Filtre à Carburant</a>
                    <a href="pageCategorie.php?categorie=reservoar-carburant">Réservoir de Carburant</a>
                </div>
            </div>

            <!-- Carrosserie et Éclairage -->
            <div class="dropdown">
                <button class="dropdown-btn">Carrosserie et Éclairage</button>
                <div class="dropdown-content">
                    <a href="pageCategorie.php?categorie=porte">Portes</a>
                    <a href="pageCategorie.php?categorie=capot">Capot</a>
                    <a href="pageCategorie.php?categorie=aile">Ailes</a>
                    <a href="pageCategorie.php?categorie=parechoc">Pare-chocs</a>
                    <a href="pageCategorie.php?categorie=phares">Phares et Feux</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropdown-btn">Lubrifiant</button>
                <div class="dropdown-content">

                </div>
        </nav>
</header>



</body>
</html>
