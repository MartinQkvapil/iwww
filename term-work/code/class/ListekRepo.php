<?php
/**
 * Created by PhpStorm.
 * User: qvapim
 * Date: 2/2/2019
 * Time: 8:06 PM
 */

class ListekRepo
{

    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteListky($id)
    {

        $stmt = $this->conn->prepare("DELETE FROM listek WHERE idfaktura=:id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Smazani provedeno!! " . "</div>";
        } else {
            echo "<div class=\"good\">" . "Smazani NE-provedeno!! " . "</div>";
        }

    }

    public function deleteListkyISPoctem($id)
    {


    }

    public function pridejPocetListku(int $id, int $pocet)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE listek 
                    SET nazevUdalosti=:pocet
                   WHERE idfaktura=:id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pocet", $pocet);
        $stmt->execute();


    }


    public function pocetProdanych($id)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT nazevUdalosti FROM listek WHERE detail_udalosti_iddetail_udalosti = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetchAll();


    }


    public function listekZaplacen($id)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE listek 
                    SET zaplaceno = 3
                    WHERE idfaktura = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!" . "</div>";
        } else {
            echo "<div class=\"wrong\">" . "Chyba při upravě!" . "</div>";
        }


    }

    public function kolikProdanych($id)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT SUM(pocetlistku) FROM listek WHERE detail_udalosti_iddetail_udalosti = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetchAll();


    }


    public function getListkyProExport()
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM listek");
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function printJson($data)
    {

        $conn = Connection::getPdoInstance();
        $obj = new ListekRepo($conn);
        $result = $obj->getListkyProExport();


        header('Content-Type: text/json');
        header('Content-Disposition: attachment; filename="export.json"');
        header('Pragma: no-cache');
        header('Expires: 0');
        echo json_encode($data);


    }

    public function updateListky($id, $pocetListku, $datum, $nazevUdalosti, $zaplaceno, $uzivatel_iduzivatel, $detail_udalosti_iddetail_udalosti)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE listek 
                    SET pocetlistku=:pocetlistku,
                        datum=:datum,
                        nazevUdalosti=:nazevUdalosti,
                        zaplaceno=:zaplaceno, 
                        uzivatel_iduzivatel=:uzivatel_iduzivatel,
                        detail_udalosti_iddetail_udalosti=:detail_udalosti_iddetail_udalosti   
                    WHERE idfaktura = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pocetlistku", $pocetListku);
        $stmt->bindParam(":datum", $datum);
        $stmt->bindParam(":nazevUdalosti", $nazevUdalosti);
        $stmt->bindParam(":zaplaceno", $zaplaceno);
        $stmt->bindParam(":uzivatel_iduzivatel", $uzivatel_iduzivatel);
        $stmt->bindParam(":detail_udalosti_iddetail_udalosti", $detail_udalosti_iddetail_udalosti);

        try {
            if ($stmt->execute()) {
                echo "<div class=\"good\">" . "Uprava provedena!" . "</div>";
            } else {
                echo "<div class=\"wrong\">" . "Chyba při upravě!" . "</div>";
            }

        } catch (PDOException $ex) {
            echo "<div class=\"wrong\">" . "Chyba při upravě!" . $ex . "</div>";
        }
    }
}