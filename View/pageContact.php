<!DOCTYPE html>
<html lang="fr">


<head>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/contact.css">

</head>



<body>
<?php

include 'header.php';

?>
<?php
session_start();
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
    unset($_SESSION['error_message']); // Supprime le message après l'affichage
}
?>
<div class="contact-container">
    <h1>Contactez-nous</h1>
    <form method="post" action="mail.php" class="contact-form-wrapper">
        <label for="contact-nom">Nom</label>
        <input type="text" id="contact-nom" name="nom" placeholder="Votre nom" required>

        <label for="contact-prenom">Prénom</label>
        <input type="text" id="contact-prenom" name="prenom" placeholder="Votre prénom" required>

        <label for="contact-email">E-mail</label>
        <input type="email" id="contact-email" name="email" placeholder="Votre adresse e-mail" required>

        <label for="contact-telephone">Téléphone</label>
        <input type="tel" id="contact-telephone" name="telephone" placeholder="Votre numéro de téléphone" required>

        <label for="contact-message">Message</label>
        <textarea id="contact-message" name="message" rows="5" placeholder="Votre message ici..." required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</div>
</body>

<?php
include 'footer.php';

