<?php
/**
 * Created by PhpStorm.
 * User: qvapim
 * Date: 2/2/2019
 * Time: 12:07 AM
 */

class UdalostRepo
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function UpdateNazevUdalosti($id, $nazev, $idUzivatele)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE udalost 
                    SET  nazev=:nazev, uzivatel_iduzivatel=:uzivatel_iduzivatel
                    WHERE idudalost = :id");

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":uzivatel_iduzivatel", $idUzivatele);


        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!! " . "</div>";

        } else {
            echo "<div class=\"wrong\">" . "Uprava chyba!!!" . "</div>";

        }


    }

    public function UpdateUdalost(int $id, string $a, string $b, string $c, string $d, string $e)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE detail_udalosti 
                    SET  datum=:a, popis=:b, pocet_listku=:c, cenalistku=:d, mistnost_idmistnost=:e 
                    WHERE iddetail_udalosti = :id");

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":a", $a);
        $stmt->bindParam(":b", $b);
        $stmt->bindParam(":c", $c);
        $stmt->bindParam(":d", $d);
        $stmt->bindParam(":e", $e);
        /*  $a = $_POST['datum'];
             $b = $_POST['popis'];
             $c = $_POST['pocet_listku'];
             $d = $_POST['cena_listku'];
             $e = $_POST['mistnosti'];*/

        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!! " . "</div>";

        } else {
            echo "<div class=\"wrong\">" . "Uprava chyba!!!" . "</div>";

        }

    }

    public function UpdateMistnost($id, $a, $b)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE mistnost 
                    SET  nazev=:a, popis=:b
                    WHERE idmistnost = :id");

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":a", $a);
        $stmt->bindParam(":b", $b);

        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!! " . "</div>";

        } else {
            echo "<div class=\"wrong\">" . "Uprava chyba!!!" . "</div>";

        }

    }


    public function readOneUdalost(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM udalost WHERE idudalost LIKE  :id ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAkce()
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();

        $stmt = $this->conn->prepare("SELECT a.iddetail_udalosti, a.datum ,a.popis,a.pocet_listku,a.cenalistku,b.nazev \"nazev_udalosti\", c.nazev \"nazev_mistnosti\" 
                    FROM detail_udalosti a, udalost b, mistnost c 
                     WHERE  a.udalost_idudalost = b.idudalost and a.mistnost_idmistnost = c.idmistnost AND a.datum > NOW() ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getListky(int $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM listek WHERE  uzivatel_iduzivatel = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getListkyKakci(int $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM listek WHERE  detail_udalosti_iddetail_udalosti = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAkceOne(int $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();

        $stmt = $this->conn->prepare("SELECT a.iddetail_udalosti, a.datum ,a.popis,a.pocet_listku,a.cenalistku,b.nazev \"nazev_udalosti\", c.nazev \"nazev_mistnosti\" 
                    FROM detail_udalosti a, udalost b, mistnost c 
                     WHERE  a.udalost_idudalost = b.idudalost and a.mistnost_idmistnost = c.idmistnost AND a.iddetail_udalosti =:id ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createListek(int $pocetListku, int $zaplaceno, string $uzivatel, string $idUdalosti)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("
                  INSERT INTO listek (idfaktura, pocetlistku, datum, nazevUdalosti, zaplaceno, uzivatel_iduzivatel, detail_udalosti_iddetail_udalosti) VALUES (NULL, :pocetlistku,  :datum, NULL, :zaplaceno, :uzivatel_iduzivatel, :udalost)");
        $stmt->bindParam(":pocetlistku", $pocetListku);
        $datum = date("Y/m/d");
        $stmt->bindParam(":datum", $datum);
        $stmt->bindParam(":zaplaceno", $zaplaceno);
        $stmt->bindParam(":uzivatel_iduzivatel", $uzivatel);
        $stmt->bindParam(":udalost", $idUdalosti);
        $stmt->execute();

    }


    public function DeleteDetail(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("DELETE FROM detail_udalosti WHERE iddetail_udalosti=:id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $message = "Smazano";
            echo "<div class=\"good\">" . "Smazani provedeno!! " . "</div>";
        } else {
            $message = "Chyba mazani";
            echo "<div class=\"good\">" . "Smazani ne provedena!! " . "</div>";
        }

    }

    /* public function readOneDetailUdalosti(string $id)
        {
            $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
            $setChar->execute();
            $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti WHERE iddetail_udalosti=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll();
        }*/

}