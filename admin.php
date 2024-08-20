<?php
// admin.php

session_start();

// Controleer of de gebruiker is ingelogd, zo niet, stuur hem terug naar de inlogpagina
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Automatisch laden van klassen
spl_autoload_register();

use Business\FrisdrankService;
use Business\MuntService;
use Exceptions\FrisdrankUitverkochtException;
use Exceptions\FrisdrankMaxCapaciteitBereiktException;

// Maak een instantie van FrisdrankService
$frisdrankService = new FrisdrankService();

// Maak een instantie van MuntService
$muntService = new MuntService();

$errorMsgs = []; // Initialiseer een array voor foutmeldingen

// Als het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of de knop voor het verhogen van de voorraad is ingedrukt
    if (isset($_POST['verhoog']) && isset($_POST['frisdrankId'])) {
        $frisdrankId = $_POST['frisdrankId'];
        // Roep de methode aan om de voorraad te verhogen
        try {
            $frisdrankService->verhoogVoorraad($frisdrankId);
        } catch (FrisdrankMaxCapaciteitBereiktException $e) {
            // Behandel de FrisdrankMaxCapaciteitBereiktException
            // Toon een foutmelding aan de gebruiker
            $errorMsgs[$frisdrankId] = $e->getMessage();
        }
    }
    // Controleer of de knop voor het verlagen van de voorraad is ingedrukt
    elseif (isset($_POST['verminder']) && isset($_POST['frisdrankId'])) {
        $frisdrankId = $_POST['frisdrankId'];
        // Roep de methode aan om de voorraad te verlagen
        try {
            $frisdrankService->verminderVoorraad($frisdrankId);
        } catch (FrisdrankUitverkochtException $e) {
            // Behandel de FrisdrankUitverkochtException
            // Toon een foutmelding aan de gebruiker
            $errorMsgs[$frisdrankId] = $e->getMessage();
        }
    }
    // Controleer of de knop voor het legen van de muntlade is ingedrukt
    elseif (isset($_POST['legeMuntlade'])) {
        // Roep de methode aan om de muntlade te legen
        $muntService->leegMuntlade();
    }
    // Controleer of het formulier voor het bijvullen van de muntlade is ingediend
    elseif (isset($_POST['vul_munt']) && isset($_POST['muntId']) && isset($_POST['aantal'])) {
        $muntId = $_POST['muntId'];
        $aantal = $_POST['aantal'];
        // Roep de methode aan om de muntlade individueel te vullen
        $muntService->verhoogVoorraad($muntId, $aantal);
    }
}

// Laad de presentatie en geef de $errorMsgs variabele door
include("Presentation/admin.php");
