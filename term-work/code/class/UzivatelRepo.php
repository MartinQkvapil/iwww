<?php
/**
 * Created by PhpStorm.
 * User: qvapim
 * Date: 2/1/2019
 * Time: 9:59 PM
 */

class UzivatelRepo
{

    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM uzivatel");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // INSERT INTO `uzivatel` (`iduzivatel`, `jmeno`, `heslo`, `email`, `datumPridani`, `roleUzivatele`) VALUES (NULL, 'Martin', 'Kvapil', 'martn.@sez.cz', '', 'admin');
    public function CreateUzivatel(string $jmeno, string $heslo, string $email, string $roleUzivatele)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("INSERT INTO uzivatel (iduzivatel, jmeno, heslo, email, datumPridani, roleUzivatele) VALUES (NULL, :jmeno, :heslo, :email, :datumPridani, :roleUzivatele)");
        $heslo = password_hash($heslo, PASSWORD_DEFAULT);
        $datumPridani = date("Y/m/d");
        $stmt->bindParam(":jmeno", $jmeno);
        $stmt->bindParam(":heslo", $heslo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":roleUzivatele", $roleUzivatele);
        $stmt->bindParam(":datumPridani", $datumPridani);
        if ($stmt->execute()) {
            echo "<div class=\"good\">Vložení bylo úspěšné!!!</div>";
        } else {
            echo "<div class=\"wrong\">Něco se pokazilo (raději kontaktujte administrátora webu)!!!</div>";
        }
    }

    public function ReadUzivatel(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("SELECT * FROM uzivatel WHERE idUzivatel LIKE   :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function UpdateUzivatel(string $id, string $jmeno, string $heslo, string $email, string $roleUzivatele)
    {

        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("UPDATE uzivatel 
                    SET jmeno=:jmeno, heslo=:heslo, email=:email, roleUzivatele=:roleUzivatele 
                    WHERE idUzivatel = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":jmeno", $jmeno);
        $stmt->bindParam(":heslo", $heslo);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":roleUzivatele", $roleUzivatele);

        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "Uprava provedena!" . "</div>";
        } else {
            echo "<div class=\"wrong\">" . "Chyba při upravě!" . "</div>";
        }


        //return $stmt->fetchAll();
    }

    public function DeleteUzivatel(string $id)
    {
        $setChar = $this->conn->prepare("SET NAMES 'utf8'"); // odstranění problému s kodovaním!!!
        $setChar->execute();
        $stmt = $this->conn->prepare("DELETE FROM uzivatel WHERE idUzivatel LIKE  concat('%', :id, '%') ");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            echo "<div class=\"good\">" . "delete proveden!" . "</div>";
        } else {
            echo "<div class=\"wrong\">" . "Chyba při delete!" . "</div>";
        }


    }

}


?>