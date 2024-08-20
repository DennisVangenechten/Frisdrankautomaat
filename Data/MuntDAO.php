<?php
//Data/MuntDAO.php
namespace Data;

use \PDO;
use Entities\Munt;
use Data\DBConfig;

class MuntDAO {
    private $dbConn;

    public function __construct() {
        $this->dbConn = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct() {
        $this->dbConn = null; // Verbreek de databaseverbinding wanneer het object wordt vernietigd
    }

    public function getAll(): array {
        $sql = "SELECT * FROM munten";
        $stmt = $this->dbConn->query($sql);
        
        $lijst = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $munt = new Munt($row['id'], $row['waarde'], $row['aantal']);
            $lijst[] = $munt;
        }
        
        return $lijst;
    }

    public function getById($id): ?Munt {
        $sql = "SELECT * FROM munten WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Munt($row['id'], $row['waarde'], $row['aantal']);
        } else {
            return null;
        }
    }

    public function update(Munt $munt): void {
        $sql = "UPDATE munten SET waarde = :waarde, aantal = :aantal WHERE id = :id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute([
            'waarde' => $munt->getWaarde(),
            'aantal' => $munt->getAantal(),
            'id' => $munt->getId()
        ]);
    }
    public function getByWaarde(string $waarde): ?Munt {
        $sql = "SELECT * FROM munten WHERE waarde = :waarde";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute(['waarde' => $waarde]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return new Munt($row['id'], $row['waarde'], $row['aantal']);
        } else {
            return null;
        }
    }
    public function leegLade() {
        $sql = "UPDATE munten SET aantal = 0";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->execute();
    }
    
}
