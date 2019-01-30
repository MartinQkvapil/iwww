<?php


class Authentication
{
    static private $instance = NULL;
    static private $identity = NULL;
    private $conn = null;



    static function getInstance(): Authentication
    {
        if (self::$instance == NULL) {
            self::$instance = new Authentication();
        }
        return self::$instance;
    }

    private function __construct()
    {
        if (isset($_SESSION['identity'])) {
            self::$identity = $_SESSION['identity'];
        }
        $this->conn = Connection::getPdoInstance();

    }



    public function login(string $email, string $password): bool
    {
        $stmt = $this->conn->prepare("SELECT idUzivatel, jmeno, email, roleUzivatele FROM uzivatel WHERE email= :email and heslo = :heslo");
        $stmt->bindParam(':email', $_POST["loginMail"]);
        $stmt->bindParam(':heslo', $_POST["loginPassword"]);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $userDto = array('idUzivatel' => $user['idUzivatel'], 'jmeno' => $user['jmeno'], 'email' => $user['email'], 'roleUzivatele' => $user['roleUzivatele']);
            $_SESSION['identity'] = $userDto;
            self::$identity = $userDto;
            return true;
        } else {
            return false;
        }
    }


    public function hasIdentity(): bool
    {
        if (self::$identity == NULL) {
            return false;
        }
        return true;
    }

    public function getIdentity()
    {
        if (self::$identity == NULL) {
            return false;
        }
        return self::$identity;
    }

    public function getRole()
    {
        if (self::$identity == NULL) {
            return false;
        }
        $role = self::$identity;
        return $role['roleUzivatele'];
    }




    public function logout()
    {
        unset($_SESSION['identity']);
        $_SESSION = array();
        session_destroy();
        self::$identity = NULL;
    }
}