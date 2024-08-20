<?php
declare(strict_types = 1);

namespace Entities;
class Munt {
    private $id;
    private $waarde;
    private $aantal;

    // Constructor
    public function __construct($id, $waarde, $aantal) {
        $this->id = $id;
        $this->waarde = $waarde;
        $this->aantal = $aantal;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getWaarde() {
        return $this->waarde;
    }

    public function getAantal() {
        return $this->aantal;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setWaarde($waarde) {
        $this->waarde = $waarde;
    }

    public function setAantal($aantal) {
        $this->aantal = $aantal;
    }
}