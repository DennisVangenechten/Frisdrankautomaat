<?php
session_start();

// Verwijder alle sessievariabelen
session_unset();

// Vernietig de sessie
session_destroy();

// Stuur de gebruiker terug naar de inlogpagina
header('Location: index.php');
exit;
