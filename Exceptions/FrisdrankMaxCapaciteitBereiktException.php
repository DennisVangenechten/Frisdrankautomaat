<?php
namespace Exceptions;
//Exceptions/FrisdrankMaxCapaciteitBereiktException.php

use Exception;

class FrisdrankMaxCapaciteitBereiktException extends Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
