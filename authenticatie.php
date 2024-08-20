<?php
session_start();

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer gebruikersnaam en wachtwoord (vervang deze met de echte inloggegevens)
    $username = 'admin';
    $password = 'admin';

    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        // Inloggen gelukt, stel sessievariabelen in
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: admin.php');
        exit;
    } else {
        // Inloggen mislukt, toon een foutmelding
        $error = "Ongeldige gebruikersnaam of wachtwoord.";
        header('Location: index.php'); // Stuur terug naar het inlogformulier
        exit;
    }
}