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

