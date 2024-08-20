<?php
//Exceptions/FrisdrankNietGevonden.php

namespace Exceptions;

use Exception;

class FrisdrankNotFoundException extends Exception {
    public function __construct($id) {
        parent::__construct("Frisdrank met ID $id niet gevonden.");
    }
}