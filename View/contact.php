<?php

include 'header.php';

?>
<body>

<link rel="stylesheet" href="css/contact.css">

<div class="container">
    <h1>Contactez-nous</h1>
    <form method="post" action="mail.php" class="contact-form">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>

        <label for="telephone">Téléphone</label>
        <input type="tel" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" placeholder="Votre message ici..." required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</div>
</body>

