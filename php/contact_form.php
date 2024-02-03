<?php

// Vérifier si la méthode de la requête est POST et si le bouton de soumission a été utilisé
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['submit'])) {
    // Renvoyer un code de réponse 400 (Bad Request) et quitter
    http_response_code(400);
    $error_message = "Méthode de requête non valide ou le formulaire n'a pas été soumis correctement.";
    exit(json_encode(['error' => $error_message]));
}

// Vérifier le champ caché pour la protection contre les soumissions de formulaire automatisées
if (!empty($_POST['phone'])) {
    // La soumission a été effectuée par un bot, la rejeter
    exit;
}

// Assainir et valider les données du formulaire
$name = htmlspecialchars(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
$surname = htmlspecialchars(filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING));
$email = htmlspecialchars(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Renvoyer un code de réponse 400 (Bad Request) et quitter
    http_response_code(400);
    $error_message = "Merci d'entrer une adresse mail valide.";
    exit(json_encode(['error' => $error_message]));
}

$subject = htmlspecialchars(trim(filter_input(INPUT_POST, "besoin", FILTER_SANITIZE_STRING)));
if (empty($subject)) {
    // Renvoyer un code de réponse 400 (Bad Request) et quitter
    http_response_code(400);
    $error_message = "Merci de remplir le champ 'Votre besoin'.";
    exit(json_encode(['error' => $error_message]));
}

// Définir l'adresse e-mail du destinataire
$recipient = "lonchamptgaspard@gmail.com"; // Remplacer par votre adresse e-mail destinataire

// Définir le sujet de l'e-mail
$email_subject = "Nouveau contact de $name $surname : $subject";

// Construire le contenu de l'e-mail
$email_content = "Nom : $name\n";
$email_content .= "Prénom : $surname\n";
$email_content .= "E-mail : $email\n\n";
$email_content .= "Message :\n$subject\n";

// Construire les en-têtes de l'e-mail
$email_headers = "From: $name <$email>";

// Envoyer l'e-mail
if (mail($recipient, $email_subject, $email_content, $email_headers)) {
    // Renvoyer un code de réponse 200 (OK)
    http_response_code(200);
    $success_message = "Merci ! Votre message a été envoyé.";
    exit(json_encode(['success' => $success_message]));
} else {
    // Renvoyer un code de réponse 500 (Internal Server Error)
    http_response_code(500);
    $error_message = "Oups ! Une erreur s'est produite, veuillez réessayer.";
    exit(json_encode(['error' => $error_message]));
}
