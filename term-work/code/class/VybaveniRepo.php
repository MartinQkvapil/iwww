<?php
/**
 * Created by PhpStorm.
 * User: qvapim
 * Date: 2/2/2019
 * Time: 6:46 PM
 */

class VybaveniRepo
{

    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function UpdateVybaveni(string $id, string $nazev, string $popis, string $stav)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE vybaveni 
                    SET nazev=:nazev, popis=:popis, stav=:stav
                    WHERE idvybaveni = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":popis", $popis);
        $stmt->bindParam(":stav", $stav);

        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!" . "</div>";
        } else {
            echo "<div class=\"wrong\">" . "Chyba při upravě!" . "</div>";
        }


        //return $stmt->fetchAll();
    }


}