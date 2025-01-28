

<link rel="stylesheet" href="css/header.css">
<header class="main-header">


    <div class="header-top">
        <h1>Aboud Distribution</h1>
    </div>
    <nav class="header-navigation">
        <a href="pageAccueil.php">Accueil</a>
        <a href="pageProduits.php">Nos Produits</a>
        <a href="pageContact.php">Contact</a>
        <a href="pageGestionProduits.php">Gestions Articles</a>
    </nav>
    <div class="search-bar">
        <input type="search" placeholder="Rechercher une pièce...">
        <button>Rechercher</button>
    </div>
    <nav class="categories-bar">
        <!-- Catégorie 1 -->
        <div class="dropdown">
            <button class="dropdown-btn">Moteur et Transmission</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=huile">Huiles et Lubrifiants</a>
                <a href="pageCategorie.php?categorie=filtre">Filtres</a>
                <a href="pageCategorie.php?categorie=embrayage">Embrayages</a>
            </div>
        </div>
        <!-- Catégorie 2 -->
        <div class="dropdown">
            <button class="dropdown-btn">Éclairage et Électronique</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=ampoule">Ampoules</a>
                <a href="pageCategorie.php?categorie=batterie">Batteries</a>
                <a href="pageCategorie.php?categorie=capteurs">Capteurs et Relais</a>
            </div>
        </div>
        <!-- Catégorie 3 -->
        <div class="dropdown">
            <button class="dropdown-btn">Freins et Suspensions</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=plaquette">Plaquettes de Frein</a>
                <a href="pageCategorie.php?categorie=disque">Disques de Frein</a>
                <a href="pageCategorie.php?categorie=amortisseur">Amortisseurs</a>
            </div>
        </div>
    </nav>
</header>


<?php
