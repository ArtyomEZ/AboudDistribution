<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'zakariyyadsainf@gmail.com';
    $mail->Password = 'fres nkct qltm tmqm';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    if (isset($_POST['message'], $_POST['email'], $_POST['nom'], $_POST['prenom'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $message = $_POST['message'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];


        $mail->setFrom($email, 'Formulaire de contact');

        // Ajouter un Reply-To avec l'adresse de l'utilisateur
        $mail->addReplyTo($email, "$nom $prenom");

        // Destinataire
        $mail->addAddress('zakariyyadsainf@gmail.com', 'Destinataire');

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Message du formulaire de contact';
        $mail->Body = "
            <p><strong>Nom :</strong> $nom $prenom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Téléphone : </strong> $tel</p>
            <p><strong>Message :</strong></p>
            <p>$message</p>
        ";
        $mail->AltBody = "Nom : $nom $prenom\nEmail : $email\nMessage : $message";




        $mail->send();
        echo 'E-mail envoyé avec succès !';
        header('Location: pageAccueil.php');
        exit();
    } else {
        echo 'Veuillez remplir tous les champs.';
    }
} catch (Exception $e) {
    echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
}
?>
