<h1>Uzivatel</h1>

<style>
table {
border: 5px solid #ccc;
border-collapse: collapse;
margin: 0;
padding: 0;
width: 50%;
table-layout: fixed;
}
</style>

<?php
$conn = Connection::getPdoInstance();
if ($_GET["action"] == "read-all") {
    echo "<h2>All users</h2>";
    $userDao = new UserRepository(Connection::getPdoInstance());
    $allUsersResult = $userDao->getAllUsers();

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("iduzivatel", "ID");
    $datatable->addColumn("email", "Email");
    $datatable->addColumn("jmeno", "Jmeno");
    $datatable->render();

} else if ($_GET["action"] == "by-email") {
    echo "<h2>By email</h2>";
    ?>

    <form method="post">
        <input type="text" name="mail" placeholder="insert email address">
        <input type="submit" value="Find by email">
    </form>

    <?php

    if (!empty($_POST["mail"])) {
        $userDao = new UserRepository(Connection::getPdoInstance());
        $usersByEmail = $userDao->getByEmail($_POST["mail"]);
        $datatable = new DataTable($usersByEmail);
        $datatable->addColumn("iduzivatel", "ID");
        $datatable->addColumn("email", "Email");
        $datatable->addColumn("jmeno", "Jmeno");
        $datatable->render();
    }

} else if ($_GET["action"] == "read-one") {
    echo "<h2>read</h2>";

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    try {
        $obj = new UserRepository($conn);
        $row = $obj->ReadUzivatel($id);

        $name = $row[0]['jmeno'];
        $heslo = $row[0]['heslo'];
        $email = $row[0]['email'];
        $role = $row[0]['roleUzivatele'];

    }
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }

    ?>
    <table class='table'>

        <tr>
            <td>jmeno</td>
            <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td>heslo</td>
            <td><?php echo htmlspecialchars($heslo, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td>email</td>
            <td><?php echo htmlspecialchars($email, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td>role</td>
            <td><?php echo htmlspecialchars($role, ENT_QUOTES); ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href='?page=uzivatel' class='btn btn-danger'>Zobraz všechny uživatele</a>
            </td>
        </tr>
    </table>
    <?php


} else if ($_GET["action"] == "edit") {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    if ($_POST) {
        $jmeno = $_POST['jmenoGET'];
        $email = $_POST['emailGET'];
        $heslo = $_POST['hesloGET'];
        $roleUzivatele = $_POST['roleUzivateleGET'];
        try {
            $obj = new UserRepository($conn);
            $obj->UpdateUzivatel($id, $jmeno, $heslo, $email, $roleUzivatele);
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    }

        try {

            $obj = new UserRepository($conn);
            $row = $obj->ReadUzivatel($id);
            echo print_r($row);
            $name = $row[0]['jmeno'];
            $heslo = $row[0]['heslo'];
            $email = $row[0]['email'];
            $role = $row[0]['roleUzivatele'];
        } // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }



    ?>


    <form  method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>ID</td>
                <td><?php echo "$id"; ?></td>
            </tr>
            <tr>
                <td>JMENO</td>
                <td><input type='text' name='jmenoGET' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                           class='form-control'/></td>
            </tr>

            <tr>
                <td>HESLO</td>
                <td><input  type='text'  name='hesloGET'value="<?php echo htmlspecialchars($heslo, ENT_QUOTES); ?>"
                            class='form-control'/></td>
            </tr>
            <tr>
                <td>EMAIL</td>
                <td><input type='text' name='emailGET' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>"
                           class='form-control'/></td>
            </tr>
            <tr>
                <td>ROLE</td>
                <td><input type='text' name='roleUzivateleGET' value="<?php echo htmlspecialchars($role, ENT_QUOTES); ?>"
                           class='form-control'/></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-primary'/>
                    <a href='?page=uzivatel' class='btn btn-danger'>Zpět na uzivatele:</a>
                </td>
            </tr>
        </table>
    </form>

    </div> <!-- end .container -->




    <?php
} else if ($_GET["action"] == "delete") {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    try {
        $obj = new UserRepository($conn);
        $obj->DeleteUzivatel($id);
        header('Location: ?page=uzivatel');

    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }


} else if ($_GET["action"] == "create") {
    ?>
    <form method="POST">
        <table>
            <tr>
                <td>Vaše jméno</td>
                <td><input name="jmeno" type="text"/></td>
            </tr>
            <tr>
                <td>Váš email</td>
                <td><input name="email" type="email"/></td>
            </tr>
            <tr>
                <td>heslo</td>
                <td><input name="heslo" type="text"/></td>
            </tr>
            <tr>
                <td>role</td>
                <td><input name="roleUzivatele" type="text"/></td>
            </tr>
        </table>

        <input type="submit" value="Odeslat"/>
        <a href='?page=uzivatel' class='btn btn-danger'>Zpět na uživatele</a>
    </form>


    <?php

    if ($_POST) {
        if (isset($_POST['jmeno']) && $_POST['heslo'] &&
            isset($_POST['email']) && $_POST['heslo'] &&
            isset($_POST['heslo']) && $_POST['heslo'] &&
            isset($_POST['roleUzivatele']) && $_POST['roleUzivatele']) {
            $jmeno = $_POST['jmeno'];
            $email = $_POST['email'];
            $heslo = $_POST['heslo'];
            $roleUzivatele = $_POST['roleUzivatele'];


            try {
                $obj = new UserRepository($conn);
                $obj->CreateUzivatel($jmeno, $heslo, $email, $roleUzivatele);
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } else {
            $hlaska = 'Formulář není správně vyplněný!';
            echo $hlaska;
        }
    }
}

?>
