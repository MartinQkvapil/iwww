<?php

class UserRepository
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }



    public function getAllDetailUdalosti()
{
    $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
    $setChar->execute();
    $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti");
    $stmt->execute();
    return $stmt->fetchAll();
}



    public function getAllUdalosti()
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM udalost");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllMistnosti()
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM mistnost");
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public function DeleteMistnost(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("DELETE FROM mistnost WHERE idmistnost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $message = "Smazano";
            echo "<div class=\"good\">" . "delete proveden!" . "</div>";
        } else {
            $message = "Chyba mazani";
            echo "<div class=\"wrong\">" . "delete NE-proveden!" . "</div>";
        }

        //return $stmt->fetchAll();
    }

    public function DeleteUdalost(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("DELETE FROM udalost WHERE idudalost LIKE  :id ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "delete proveden!" .  "</div>";
        } else {
            echo "<div class=\"wrong\">" . "delete NEproveden!" . "</div>";
        }

        //return $stmt->fetchAll();
    }

    public function readOneUdalost(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM udalost WHERE idudalost LIKE :id ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function readDetailUdalosti(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti WHERE udalost_idudalost LIKE  :id ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function readOneDetailUdalosti(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti WHERE iddetail_udalosti=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function readOneMistnost(string $id){
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
         $stmt = $this->conn->prepare("SELECT * FROM mistnost WHERE idmistnost LIKE  :id ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function createDetailUdalosti(string $datum, string $popis, int $pocet_listku, int $cenalistku, int $udalost_idudalost, int $uzivatel_iduzivatel, int $mistnost_idmistnost)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("INSERT INTO detail_udalosti (iddetail_udalosti ,datum, popis, pocet_listku, cenalistku, udalost_idudalost, uzivatel_iduzivatel, mistnost_idmistnost ) 
VALUES (NULL, :datum, :popis, :pocet_listku, :cenalistku, :udalost_idudalost, :uzivatel_iduzivatel, :mistnost_idmistnost)");
        $stmt->bindParam(":datum", $datum);
        $stmt->bindParam(":popis", $popis);
        $stmt->bindParam(":pocet_listku", $pocet_listku);
        $stmt->bindParam(":cenalistku", $cenalistku);
        $stmt->bindParam(":udalost_idudalost", $udalost_idudalost);
        $stmt->bindParam(":uzivatel_iduzivatel", $uzivatel_iduzivatel);
        $stmt->bindParam(":mistnost_idmistnost", $mistnost_idmistnost);
        $stmt->execute();
    }



    public function createUdalost(string $nazev, string $idUzivatele)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("INSERT INTO udalost (idudalost, nazev, uzivatel_iduzivatel) VALUES (NULL, :nazev, :idUzivatele)");
        $stmt->bindParam(":idUzivatele", $idUzivatele);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->execute();
        //return $stmt->fetchAll();
    }

    public function createVybaveni(string $nazev, string $popis, string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("INSERT INTO vybaveni (idvybaveni, mistnost_idmistnost, nazev, popis, stav) VALUES (NULL, :id, :nazev, :popis,'K dispozici' )");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":popis", $popis);
        $stmt->execute();
        //return $stmt->fetchAll();
    }


    public function createMistnost(string $nazev, string $popis)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("INSERT INTO mistnost (idmistnost, nazev, popis) VALUES (NULL, :nazev, :popis)");
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":popis", $popis);
        $stmt->execute();
        //return $stmt->fetchAll();
    }



    public function readVybaveniMistosti(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM vybaveni WHERE mistnost_idmistnost LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function readVybaveni(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM vybaveni WHERE idvybaveni LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }






    public function DeleteVybaveni(string $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM vybaveni WHERE idvybaveni LIKE :id ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $message = "Smazano";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Chyba mazani";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

    }


}