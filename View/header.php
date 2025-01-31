
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/header.css">
<header class="main-header">


    <div class="header-top">
        <h1 a href="pageAccueil.php">Aboud Distribution</h1>

    </div>
    <nav class="header-navigation">
        <a href="pageAccueil.php">Accueil</a>
        <a href="pageProduits.php">Nos Produits</a>
        <a href="pageContact.php">Contact</a>
    </nav>
<form action="../Controller/rechercheController.php" method="GET">
    <div class="search-bar">
        <input  type="search"  name="search" placeholder="Rechercher une pièce...">
        <button>Rechercher</button>
</form>
        <a href="pageConnexion.php">
          <div align="right"> <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Connexion"  height="80px"></div>
        </a>
    </div>
    <nav class="categories-bar">
        <div class="dropdown">
            <button class="dropdown-btn">Moteur et Transmission</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=huile">Huiles et Lubrifiants</a>
                <a href="pageCategorie.php?categorie=filtre">Filtres</a>
                <a href="pageCategorie.php?categorie=embrayage">Embrayages</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Éclairage et Électronique</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=ampoule">Ampoules</a>
                <a href="pageCategorie.php?categorie=batterie">Batteries</a>
                <a href="pageCategorie.php?categorie=capteurs">Capteurs et Relais</a>
            </div>
        </div>
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


