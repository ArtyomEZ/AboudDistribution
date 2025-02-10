<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - Aboud Distribution Givors</title>
    <link rel="stylesheet" href="css/a_propos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<header>
    <nav>
        <!-- Menu de navigation -->
    </nav>
</header>
<?php
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
    unset($_SESSION['error_message']); // Supprime le message après l'affichage
}
?>
<main>
    <section class="about">
        <div class="container">
            <h2 class="animate__animated">À Propos de Aboud Distribution Givors</h2>
            <p>Bienvenue chez <strong>Aboud Distribution</strong>, votre magasin automobile de confiance situé à Givors. Depuis plusieurs années, nous nous engageons à fournir des produits de haute qualité pour répondre aux besoins des passionnés d'automobile et des professionnels.</p>

            <h3>Notre Mission</h3>
            <p>Chez Aboud Distribution, notre mission est de vous offrir un large choix de pièces et accessoires automobiles aux meilleurs prix. Nous travaillons avec des marques renommées pour garantir fiabilité, performance et satisfaction.</p>

            <h3>Pourquoi Nous Choisir ?</h3>
            <ul>
                <li class="fade-in">Un large inventaire de produits adaptés à tous les véhicules.</li>
                <li class="fade-in">Des experts à votre écoute pour vous conseiller.</li>
                <li class="fade-in">Des prix compétitifs et des offres régulières.</li>
                <li class="fade-in">Un emplacement pratique à Givors, facile d'accès.</li>
            </ul>

            <h3>Où Nous Trouver ?</h3>
            <p>Notre magasin est situé au <strong>centre de Givors</strong>, à proximité des grands axes routiers. Nous vous accueillons du lundi au vendredi de <strong>9h à 12h</strong> puis de <strong>14h à 18h</strong> et le samedi de <strong>9h à 12h</strong> pour répondre à vos besoins en matière de pièces et accessoires automobiles.</p>

            <div align="center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5584.13740014995!2d4.768811776507023!3d45.589163671076165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47f4e6bbae3751ab%3A0x6bb794304af087cd!2s3%20Pl.%20du%20Colonel%20Fabien%2C%2069700%20Givors!5e0!3m2!1sfr!2sfr!4v1737465124714!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <h3>Nos Services</h3>
            <p>En plus de notre large gamme de produits, nous proposons :</p>
            <ul>
                <li class="fade-in">Un service de commande spéciale pour des produits rares.</li>
                <li class="fade-in">Une assistance personnalisée pour le choix des équipements.</li>
                <li class="fade-in">Des promotions régulières pour nos clients fidèles.</li>
            </ul>

            <p>N'hésitez pas à nous rendre visite pour découvrir tout ce que nous avons à offrir !</p>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__fadeInUp');
                }
            });
        });

        document.querySelectorAll('.animate__animated').forEach(el => observer.observe(el));

        // Animation pour les listes
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            setTimeout(() => el.style.opacity = 1, index * 200);
        });
    });


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
</body>
</html>
