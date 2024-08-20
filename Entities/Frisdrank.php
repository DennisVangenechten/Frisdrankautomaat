<?php
declare(strict_types = 1);

namespace Entities;

class Frisdrank {
    private $id;
    private $naam;
    private $prijs;
    private $voorraad;
    private $afbeelding;

    // Constructor
    public function __construct($id, $naam, $prijs, $voorraad, $afbeelding) {
        $this->id = $id;
        $this->naam = $naam;
        $this->prijs = $prijs;
        $this->voorraad = $voorraad;
        $this->afbeelding = $afbeelding;
    }

    // Getters
    public function getAfbeelding() {
        return $this->afbeelding;
    }
    public function getId() {
        return $this->id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function getPrijs() {
        return $this->prijs;
    }

    public function getVoorraad() {
        return $this->voorraad;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

    public function setPrijs($prijs) {
        $this->prijs = $prijs;
    }

    public function setVoorraad($voorraad) {
        $this->voorraad = $voorraad;
    }
}