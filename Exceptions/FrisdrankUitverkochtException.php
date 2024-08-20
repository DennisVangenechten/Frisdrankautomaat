<?php
// Exceptions/FrisdrankUitverkochtException.php

namespace Exceptions;

use Exception;

class FrisdrankUitverkochtException extends Exception {
    public function __construct($naam) {
        parent::__construct("De voorraad van frisdrank '$naam' is uitverkocht en kan niet verlaagd worden.");
    }
}
