<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['id']);
$username = $isLoggedIn && isset($_SESSION['login']) ? $_SESSION['login'] : 'Invité'; // Valeur par défaut
?>

<header class="main-header">
    <div class="header-top">
        <h1>Aboud Distribution</h1>
    </div>

    <nav class="header-navigation">
        <a href="pageAccueil.php">Accueil</a>
        <a href="pageProduits.php">Nos Produits</a>
        <a href="pageContact.php">Contact</a>

        <nav class="dropdown-menu">
            <!-- Catégorie 1 -->
            <div class="dropdown">
                <button class="dropdown-btn">Moteur et Transmission</button>
                <div class="dropdown-content">
                    <a href="categorie.php?categorie=huile">Huiles et Lubrifiants</a>
                    <a href="categorie.php?categorie=filtre">Filtres</a>
                    <a href="categorie.php?categorie=embrayage">Embrayages</a>
                </div>
            </div>
            <!-- Catégorie 2 -->
            <div class="dropdown">
                <button class="dropdown-btn">Éclairage et Électronique</button>
                <div class="dropdown-content">
                    <a href="categorie.php?categorie=ampoule">Ampoules</a>
                    <a href="categorie.php?categorie=batterie">Batteries</a>
                    <a href="categorie.php?categorie=capteurs">Capteurs et Relais</a>
                </div>
            </div>
            <!-- Catégorie 3 -->
            <div class="dropdown">
                <button class="dropdown-btn">Freins et Suspensions</button>
                <div class="dropdown-content">
                    <a href="categorie.php?categorie=plaquette">Plaquettes de Frein</a>
                    <a href="categorie.php?categorie=disque">Disques de Frein</a>
                    <a href="categorie.php?categorie=amortisseur">Amortisseurs</a>
                </div>
            </div>
        </nav>
    </nav>

    <div class="search-and-auth">
        <form action="../Controller/rechercheController.php" method="GET" class="search-bar">
            <input type="search" name="search" placeholder="Rechercher une pièce...">
            <button>Rechercher</button>
        </form>

        <div class="auth-buttons">
            <?php if ($isLoggedIn): ?>
                <span class="username">👤 <?php echo htmlspecialchars($username); ?></span>
                <a href="../Controller/LogoutController.php">
                    <button class="logout-btn">Se Déconnecter</button>
                </a>
            <?php else: ?>
                <a href="pageConnexion.php">
                    <button class="login-btn">Se Connecter</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
