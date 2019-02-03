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




}