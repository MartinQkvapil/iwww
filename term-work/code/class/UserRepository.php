<?php

class UserRepository
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $stmt = $this->conn->prepare("SELECT * FROM uzivatel");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllDetailUdalosti()
    {
        $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getAllUdalosti()
    {
        $stmt = $this->conn->prepare("SELECT * FROM udalost");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllMistnosti()
    {
        $stmt = $this->conn->prepare("SELECT * FROM mistnost");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function UpdateUdalost(string $id, string $nazev)
    {
        $stmt = $this->conn->prepare("UPDATE udalost 
                    SET id=:id, heslo=:heslo, email=:email, roleUzivatele=:roleUzivatele 
                    WHERE idUzivatel = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nazev", $nazev);


        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Update proveden</div>";
        } else {
            echo "<div class='alert alert-danger'>Chyba UPDATE</div>";
        }


    }

    public function DeleteMistnost(string $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM mistnost WHERE idmistnost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $message = "Smazano";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Chyba mazani";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        //return $stmt->fetchAll();
    }

    public function DeleteUdalost(string $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM udalost WHERE idudalost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>delete proveden</div>";
        } else {
            echo "<div class='alert alert-danger'>Chyba delete</div>";
        }

        //return $stmt->fetchAll();
    }

    public function readOneUdalost(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM udalost WHERE idudalost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function readDetailUdalosti(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM detail_udalosti WHERE udalost_idudalost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function readOneMistnost(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM mistnost WHERE idmistnost LIKE concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function createDetailUdalosti(string $datum, string $popis, int $pocet_listku, int $cenalistku, int $udalost_idudalost, int $uzivatel_iduzivatel, int $mistnost_idmistnost)
    {
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

    public function getByEmail(string $mail)
    {
        $stmt = $this->conn->prepare("SELECT * FROM uzivatel WHERE email LIKE  concat('%', :email, '%') ");
        $stmt->bindParam(":email", $mail);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function createUdalost(string $nazev, string $idUzivatele)
    {
        $stmt = $this->conn->prepare("INSERT INTO udalost (idudalost, nazev, uzivatel_iduzivatel) VALUES (NULL, :nazev, :idUzivatele)");
        $stmt->bindParam(":idUzivatele", $idUzivatele);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->execute();
        //return $stmt->fetchAll();
    }

    public function createVybaveni(string $nazev, string $popis, string $id)
    {
        $stmt = $this->conn->prepare("INSERT INTO vybaveni (idvybaveni, mistnost_idmistnost, nazev, popis, stav) VALUES (NULL, :id, :nazev, :popis,'K dispozici' )");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":popis", $popis);
        $stmt->execute();
        //return $stmt->fetchAll();
    }


    public function createMistnost(string $nazev, string $popis)
    {
        $stmt = $this->conn->prepare("INSERT INTO mistnost (idmistnost, nazev, popis) VALUES (NULL, :nazev, :popis)");
        $stmt->bindParam(":nazev", $nazev);
        $stmt->bindParam(":popis", $popis);
        $stmt->execute();
        //return $stmt->fetchAll();
    }

    public function ReadUzivatel(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM uzivatel WHERE idUzivatel LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function readVybaveniMistosti(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vybaveni WHERE mistnost_idmistnost LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function readVybaveni(string $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vybaveni WHERE idvybaveni LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }


    // INSERT INTO `uzivatel` (`iduzivatel`, `jmeno`, `heslo`, `email`, `datumPridani`, `roleUzivatele`) VALUES (NULL, 'Martin', 'Kvapil', 'martn.@sez.cz', '', 'admin');
    public function CreateUzivatel(string $jmeno, string $heslo, string $email, string $roleUzivatele)
    {
        $stmt = $this->conn->prepare("INSERT INTO uzivatel (iduzivatel, jmeno, heslo, email, datumPridani, roleUzivatele) VALUES (NULL, :jmeno, :heslo, :email, :datumPridani, :roleUzivatele)");

        $datumPridani = date("Y/m/d");
        $stmt->bindParam(":jmeno", $jmeno);
        $stmt->bindParam(":heslo", $heslo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":roleUzivatele", $roleUzivatele);
        $stmt->bindParam(":datumPridani", $datumPridani);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Create proveden</div>";
        } else {
            echo "<div class='alert alert-danger'>Chyba create</div>";
        }


    }

    public function DeleteUzivatel(string $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM uzivatel WHERE idUzivatel LIKE  concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>delete proveden</div>";
        } else {
            echo "<div class='alert alert-danger'>Chyba delete</div>";
        }

        //return $stmt->fetchAll();
    }

    public function DeleteVybaveni(string $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM vybaveni WHERE idvybaveni LIKE  concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $message = "Smazano";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $message = "Chyba mazani";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

    }

    public function UpdateUzivatel(string $id, string $jmeno, string $heslo, string $email, string $roleUzivatele)
    {
        $stmt = $this->conn->prepare("UPDATE uzivatel 
                    SET jmeno=:jmeno, heslo=:heslo, email=:email, roleUzivatele=:roleUzivatele 
                    WHERE idUzivatel = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":jmeno", $jmeno);
        $stmt->bindParam(":heslo", $heslo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":roleUzivatele", $roleUzivatele);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Update proveden</div>";
        } else {
            echo "<div class='alert alert-danger'>Chyba UPDATE</div>";
        }

        //return $stmt->fetchAll();
    }
}