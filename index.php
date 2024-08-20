<?php
// index.php
declare(strict_types=1);

session_start();

use Business\FrisdrankService;
use Business\MuntService;
use Data\MuntDAO;
use Exceptions\FrisdrankNotFoundException;

spl_autoload_register();

$frisdrankService = new FrisdrankService();
$muntService = new MuntService();
$muntDAO = new MuntDAO();

if (!isset($_SESSION['ingeworpenBedrag'])) {
    $_SESSION['ingeworpenBedrag'] = (float) 0.00;
}

$wisselgeld = [];
$errorMsg = '';
$selectedDrinkId = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['terugbetaling'])) {
        $ingeworpenBedrag = $_SESSION['ingeworpenBedrag'];
        $wisselgeld = $muntService->terugbetaling($ingeworpenBedrag);
        $_SESSION['ingeworpenBedrag'] = 0.00;
        // Reset de geselecteerde drank naar nul
        $_SESSION['selectedDrinkId'] = null;
    }

    if (isset($_POST['munt'])) {
        $muntWaarde = floatval($_POST['munt']);
        $munt = $muntDAO->getByWaarde(strval($muntWaarde));
        if ($munt) {
            $muntService->verhoogVoorraad($munt->getId());
        }
        $_SESSION['ingeworpenBedrag'] += $muntWaarde;
        // Reset de geselecteerde drank naar nul
        $_SESSION['selectedDrinkId'] = null;
    }

    if (isset($_POST['frisdrankId'])) {
        $geselecteerdeFrisdrankId = intval($_POST['frisdrankId']);
        try {
            $frisdrankPrijs = floatval($frisdrankService->getPrijsById($geselecteerdeFrisdrankId));
            if ($_SESSION['ingeworpenBedrag'] >= $frisdrankPrijs) {
                $frisdrank = $frisdrankService->getFrisdrankById($geselecteerdeFrisdrankId);
                if ($frisdrank->getVoorraad() > 0) {
                    $betaaldBedrag = floatval($_SESSION['ingeworpenBedrag']);
                    $wisselgeld = $muntService->berekenWisselgeld($betaaldBedrag, $geselecteerdeFrisdrankId);
                    $muntenInLade = $muntService->getMuntenInLade();
                    $voldoendeMunten = $muntService->controleerBeschikbaarheidMunten($muntenInLade, $wisselgeld);

                    if ($voldoendeMunten) {
                        $frisdrankService->verminderVoorraad($geselecteerdeFrisdrankId);
                        $muntService->verminderVoorraad($wisselgeld);
                        $_SESSION['ingeworpenBedrag'] = (float) 0.00;
                        // Set geselecteerd drankje alleen als de voorraad wordt verminderd
                        $_SESSION['selectedDrinkId'] = $geselecteerdeFrisdrankId;
                    } else {
                        $errorMsg = "Onvoldoende wisselgeld beschikbaar!";
                    }
                } else {
                    $errorMsg = "Geselecteerde frisdrank is uitverkocht!";
                }
            } else {
                $errorMsg = "Onvoldoende bedrag ingevoerd!";
            }
        } catch (FrisdrankNotFoundException $e) {
            $errorMsg = $e->getMessage();
        }
    }
}

$frisdranken = $frisdrankService->getAlleFrisdranken();

foreach ($frisdranken as $frisdrank) {
    if ($frisdrank->getVoorraad() <= 0) {
        $frisdrank->setNaam($frisdrank->getNaam() . ' (Uitgeput)');
    }
}

// Controleer of een drankje is geselecteerd
$selectedDrinkId = isset($_SESSION['selectedDrinkId']) ? $_SESSION['selectedDrinkId'] : null;

include("Presentation/index.php");
