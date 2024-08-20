<?php
//Business/MuntService.php
namespace Business;

use Data\MuntDAO;
use Entities\Munt;
use Business\FrisdrankService;

class MuntService
{
    private $muntDAO;
    private $frisdrankService;

    public function __construct()
    {
        $this->muntDAO = new MuntDAO();
        $this->frisdrankService = new FrisdrankService();
    }

    public function getMunten(): array
    {
        return $this->muntDAO->getAll();
    }

    public function getMuntById($id): ?Munt
    {
        return $this->muntDAO->getById($id);
    }

    public function updateMunt(Munt $munt): void
    {
        $this->muntDAO->update($munt);
    }

    public function berekenWisselgeld(float $betaaldBedrag, int $frisdrankId): array
    {
        $teBetalenBedrag = $this->frisdrankService->getPrijsById($frisdrankId);

        if ($teBetalenBedrag === null) {
            return [];
        }

        $verschil = round($betaaldBedrag - $teBetalenBedrag, 2); // Afronden op 2 decimalen



        return $this->berekenMuntAantallen($verschil);
    }

    public function berekenTeruggave(float $verschil): array
    {
        return $this->berekenMuntAantallen($verschil);
    }

    private function berekenMuntAantallen(float $verschil): array
    {
        $wisselgeld = [];
        $restVerschil = round($verschil * 100); // Converteer naar centen en rond af

        // Haal alle beschikbare munten op uit de database
        $munten = $this->muntDAO->getAll();

        usort($munten, function ($a, $b) {
            return $b->getWaarde() - $a->getWaarde();
        });

        // Bereken het wisselgeld met beschikbare munten
        foreach ($munten as $munt) {
            $muntWaardeCenten = round($munt->getWaarde() * 100); // Converteer naar centen en rond af
            $aantalBeschikbaar = $munt->getAantal();
            $aantalMunten = min(intval($restVerschil / $muntWaardeCenten), $aantalBeschikbaar); // Neem het minimum van beschikbare munten en het berekende aantal munten
            if ($aantalMunten > 0) {
                $wisselgeld[$munt->getId()] = $aantalMunten; // Gebruik de ID van de munt als sleutel
                $restVerschil -= $aantalMunten * $muntWaardeCenten;
            }
        }

        return $wisselgeld;
    }



    public function updateMuntenVoorraad(array $munten): void
    {
        foreach ($munten as $munt) {
            $this->muntDAO->update($munt);
        }
    }

    public function verminderVoorraad(array $muntIds): void
    {
        foreach ($muntIds as $muntId => $aantal) { // Voeg $aantal toe
            $munt = $this->getMuntById($muntId);
            if ($munt) {
                $munt->setAantal($munt->getAantal() - $aantal); // Verminder met $aantal
                $this->muntDAO->update($munt); // Update de voorraad van de munt in de database
            }
        }
    }

    public function verhoogVoorraad(int $muntId, int $aantal = 1): void
    {
        $munt = $this->getMuntById($muntId);
        if ($munt) {
            $munt->setAantal($munt->getAantal() + $aantal);
            $this->muntDAO->update($munt);
        }
    }

    public function controleerBeschikbaarheidMunten(array $munten, array $wisselgeld): bool
    {
        // Controleer of $wisselgeld niet leeg is
        if (empty($wisselgeld)) {
            return false;
        }

        // Controleer of er voldoende munten beschikbaar zijn voor het wisselgeld
        foreach ($munten as $munt) {
            if (isset($wisselgeld[$munt->getId()]) && $munt->getAantal() < $wisselgeld[$munt->getId()]) {
                return false;
            }
        }
        return true;
    }
    public function getMuntenInLade()
    {
        return $this->muntDAO->getAll();
    }

    public function leegMuntLade()
    {
        $this->muntDAO->leegLade();
    }

    public function terugbetaling(float $ingeworpenBedrag): array
{
    return $this->berekenTeruggave($ingeworpenBedrag);
}

}
