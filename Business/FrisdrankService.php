<?php
//Business/FrisdrankService.php
namespace Business;

use Data\FrisdrankDAO;
use Entities\Frisdrank;
use Business\MuntService;
use Exceptions\FrisdrankNotFoundException;
use Exceptions\FrisdrankUitverkochtException;
use Exceptions\FrisdrankMaxCapaciteitBereiktException;

class FrisdrankService
{
    private $frisdrankDAO;

    public function __construct()
    {
        $this->frisdrankDAO = new FrisdrankDAO();
    }

    public function getPrijsById($id): ?float
    {
        $frisdrank = $this->frisdrankDAO->getById($id);
        if (!$frisdrank) {
            throw new FrisdrankNotFoundException($id);
        }
        return $frisdrank->getPrijs();
    }

    public function getAlleFrisdranken(): array
    {
        return $this->frisdrankDAO->getAll();
    }

    public function getFrisdrankById($id): ?Frisdrank
    {
        return $this->frisdrankDAO->getById($id);
    }

    public function verminderVoorraad($frisdrankId): bool
    {
        $frisdrank = $this->frisdrankDAO->getById($frisdrankId);
        if (!$frisdrank) {
            throw new FrisdrankNotFoundException($frisdrankId);
        }
        if ($frisdrank->getVoorraad() == 0) {
            throw new FrisdrankUitverkochtException($frisdrank->getNaam());
        }
        $frisdrank->setVoorraad($frisdrank->getVoorraad() - 1);
        $this->frisdrankDAO->update($frisdrank);
        return true;
    }

    public function verhoogVoorraad($frisdrankId): bool
    {
        $frisdrank = $this->frisdrankDAO->getById($frisdrankId);

        if (!$frisdrank) {
            throw new FrisdrankNotFoundException($frisdrankId);
        }

        // Controleer of de maximale capaciteit is bereikt
        if ($frisdrank->getVoorraad() >= 20) {
            throw new FrisdrankMaxCapaciteitBereiktException("De maximale capaciteit voor deze frisdrank is bereikt.");
        }

        $frisdrank->setVoorraad($frisdrank->getVoorraad() + 1);
        $this->frisdrankDAO->update($frisdrank);

        return true;
    }


    public function controleerBeschikbareVoorraad($frisdrankId): bool
    {
        $frisdrank = $this->frisdrankDAO->getById($frisdrankId);
        return $frisdrank && $frisdrank->getVoorraad() > 0;
    }

    public function getVoorraadStatus(): array
    {
        $frisdranken = $this->frisdrankDAO->getAll();
        $status = [];
        foreach ($frisdranken as $frisdrank) {
            $status[$frisdrank->getId()] = $frisdrank->getVoorraad() > 0 ? 'Beschikbaar' : 'Uitgeput';
        }
        return $status;
    }
}