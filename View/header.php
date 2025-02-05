<header class="main-header">
    <div class="header-top">
        <h1>Aboud Distribution</h1>
    </div>
    <nav class="header-navigation">
        <a href="pageAccueil.php">Accueil</a>
        <a href="pageProduits.php">Nos Produits</a>
        <a href="pageContact.php">Contact</a>
    </nav>
    <form action="../Controller/rechercheController.php" method="GET">
        <div class="search-bar">
            <input type="search" name="search" placeholder="Rechercher une pièce...">
            <button>Rechercher</button>
        </div>
    </form>
    <a href="pageConnexion.php">
        <div align="right">
            <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Connexion" height="80px">
        </div>
    </a>
    <div class="categories-bar">
        <div class="dropdown">
            <button class="dropdown-btn">Moteur et Transmission</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=bloc-moteur">Bloc Moteur</a>
                <a href="pageCategorie.php?categorie=piston">Pistons</a>
                <a href="pageCategorie.php?categorie=vilebrequin">Vilebrequin</a>
                <a href="pageCategorie.php?categorie=alternateur">Alternateur</a>
                <a href="pageCategorie.php?categorie=courroie">Courroie de Distribution</a>
                <a href="pageCategorie.php?categorie=embrayage">Embrayage</a>
                <a href="pageCategorie.php?categorie=transmission">Transmission</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Système de Suspension et Direction</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=amortisseur">Amortisseurs</a>
                <a href="pageCategorie.php?categorie=ressort">Ressorts de Suspension</a>
                <a href="pageCategorie.php?categorie=rotule">Rotules de Direction</a>
                <a href="pageCategorie.php?categorie=barre-stabilisatrice">Barre Stabilisateur</a>
                <a href="pageCategorie.php?categorie=direction-assistée">Direction Assistée</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Système de Chauffage et Ventilation</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=compresseur-chauffage">Compresseur de Chauffage</a>
                <a href="pageCategorie.php?categorie=radiateur-chauffage">Radiateur de Chauffage</a>
                <a href="pageCategorie.php?categorie=evaporateur-chauffage">Évaporateur de Chauffage</a>
                <a href="pageCategorie.php?categorie=ventilateur-chauffage">Ventilateur de Chauffage</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropdown-btn">Système d'Airbag et Sécurité</button>
            <div class="dropdown-content">
                <a href="pageCategorie.php?categorie=airbag">Airbags</a>
                <a href="pageCategorie.php?categorie=capteur-airbag">Capteurs Airbag</a>
                <a href="pageCategorie.php?categorie=ceinture-securite">Ceintures de Sécurité</a>
                <a href="pageCategorie.php?categorie=module-securite">Modules de Sécurité</a>
            </div>

    </div>
</header>
