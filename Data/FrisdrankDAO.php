<?php

namespace Data;

use \PDO;
use Entities\Frisdrank;

class FrisdrankDAO {
    private $dbConn;

    public function __construct() {
        $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct() {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAll() {
        $sql = "SELECT * FROM frisdranken";
        $stmt = $this->dbConn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $frisdranken = [];
        foreach ($result as $row) {
            $frisdrank = new Frisdrank($row['id'], $row['naam'], $row['prijs'], $row['voorraad'], $row['afbeelding']);
            $frisdranken[] = $frisdrank;
        }

        return $frisdranken;
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM frisdranken WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Frisdrank($row['id'], $row['naam'], $row['prijs'], $row['voorraad'], $row['afbeelding']);
        } else {
            return null;
        }
    }

    public function getByName($name) {
        $sql = "SELECT * FROM frisdranken WHERE naam = :naam";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute(['naam' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Frisdrank($row['id'], $row['naam'], $row['prijs'], $row['voorraad'], $row['afbeelding']);
        } else {
            return null;
        }
    }

    public function update(Frisdrank $frisdrank) {
        $sql = "UPDATE frisdranken SET naam = :naam, prijs = :prijs, voorraad = :voorraad, afbeelding = :afbeelding WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute([
            'naam' => $frisdrank->getNaam(),
            'prijs' => $frisdrank->getPrijs(),
            'voorraad' => $frisdrank->getVoorraad(),
            'afbeelding' => $frisdrank->getAfbeelding(),
            'id' => $frisdrank->getId()
        ]);
    }
}
