<?php
// Check if form data is
if ($_SERVER["REQUESTMETHOD"] != "") {
    // Set a 40 (bad request response code and exit    http_response_(400
    $error_message = "Il y a une erreur avec votre requête.";
    exit(json_encode(['error' => $error_message]));
}

if (!empty($_POST['phone'])) {
    // The form submission was made by a bot, reject it
    exit;
}

// Sanitize and validate form data
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$name = preg_replace('/[^a-zA-Z\s]/', '', $name); // Remove any non-alphabet characters

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Set a 400 (bad request) response code and exit
    http_response_code(400);
    $error_message = "Merci d'entrer une adresse mail valide";
    exit(json_encode(['error' => $error_message]));
}

$subject = trim(filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING));
if (empty($subject)) {
    // Set a 400 (bad request) response code and exit
    http_response_code(400);
    $error_message = "Merci de remplir le champ 'Sujet'";
    exit(json_encode(['error' => $error_message]));
}

$message = trim(filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING));
if (empty($message)) {
    // Set a 400 (bad request) response code and exit
    http_response_code(400);
    $error_message = "Merci de remplir le champ 'Besoin'";
    exit(json_encode(['error' => $error_message]));
}

// Set the recipient email address with a prefix to prevent email header injection
$recipient = "lonchamptgaspard@gmail.com"; // Replace with your recipient email address
$recipient = '=?UTF-8?B?' . base64_encode($recipient) . '?= <' . $recipient . '>';

// Set the email subject
$email_subject = "New contact from $name: $subject";

// Build the email content
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";

// Build the email headers
$email_headers = "From: $name <$email>";

// Send the email
if (mail($recipient, $email_subject, $email_content, $email_headers)) {
    // Set a 200 (okay) response code
    http_response_code(200);
    $success_message = "Merci ! Votre message a été envoyé.";
    exit(json_encode(['success' => $success_message]));
} else {
    // Set a 500 (internal server error) response code
    http_response_code(500);
    $error_message = "Oups ! Il y a eu une erreur, veuillez réessayer s'il vous plait.";
    exit(json_encode(['error' => $error_message]));
}