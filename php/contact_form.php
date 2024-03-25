<?php

// Fonction pour nettoyer et valider l'adresse email
function validate_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("L'adresse email est invalide.");
    }
    return $email;
}

// Fonction pour nettoyer les entrées du formulaire
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Méthode non autorisée.");
    }

    // Vérifiez que le honeypot (champ 'phone') est vide
    if (!empty($_POST['phone'])) {
        throw new Exception("Détecté comme spam!");
    }

    // Assignez et nettoyez chaque champ de formulaire
    $name = clean_input($_POST['name'] ?? '');
    $surname = clean_input($_POST['surname'] ?? '');
    $email = validate_email($_POST['email'] ?? '');
    $besoin = clean_input($_POST['besoin'] ?? '');

    // Votre adresse email de réception
    // $to = 'hlot@mailo.com'; // Remplacez par votre adresse e-mail
    $to = 'hlot@mailo.com'; // Remplacez par votre adresse e-mail

    // Sujet de l'email
    $subject = "Nouveau message de contact de $name $surname";

    // Contenu de l'email
    $email_content = "Nom: $name\nPrénom: $surname\nEmail: $email\nBesoin: $besoin\n";

    // Headers de l'email
    $headers = "From: $name <$email>";

    // Envoi de l'email en s'assurant qu'il n'y a pas d'injection d'en-têtes
    if (mail($to, $subject, $email_content, $headers)) {
        echo "Merci $name, votre message a été envoyé.";
    } else {
        throw new Exception("Erreur lors de l'envoi du message.");
    }
} catch (Exception $e) {
    // Retourne le message d'erreur si une exception est levée
    echo $e->getMessage();
}
