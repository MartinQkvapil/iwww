<?php
$conn = Connection::getPdoInstance();
if ($_GET["action"] == "read-one") {
    ?>
    <body>
    <div class="obal">
        <div class="page-header">
            <h1>Zobrazení jednoho uživatele:</h1>
        </div>
        <a href='?page=uzivatel' class='button'>ZPĚT NA PŘEHLED UŽIVATELŮ</a>
        <?php

        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        try {
            $obj = new UzivatelRepo($conn);
            $row = $obj->ReadUzivatel($id);
            $datatable = new DataTable($row);
            $datatable->addColumn("iduzivatel", "ID");
            $datatable->addColumn("email", "EMAIL");
            $datatable->addColumn("jmeno", "JMÉNO");
            $datatable->addColumn("roleUzivatele", "ROLE");
            $datatable->render();
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
        } ?>
    </div>
    </body>
    <?php
} else if ($_GET["action"] == "edit") {
    ?>

    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    if ($_POST) {
        $jmeno = $_POST['jmenoGET'];
        $email = $_POST['emailGET'];
        $heslo = password_hash($_POST['hesloGET'], PASSWORD_DEFAULT);
        if (!empty($heslo)) {
        } else {
            $heslo = $heslo2;
        }
        $roleUzivatele = $_POST['roleUzivateleGET'];
        try {
            $obj = new UzivatelRepo($conn);
            $obj->UpdateUzivatel($id, $jmeno, $heslo, $email, $roleUzivatele);
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
        }
    }

    try {

        $obj = new UzivatelRepo($conn);
        $row = $obj->ReadUzivatel($id);
        $name = $row[0]['jmeno'];
        $heslo2 = $row[0]['heslo'];
        $email = $row[0]['email'];
        $role = $row[0]['roleUzivatele'];
    } // show error
    catch (PDOException $exception) {
        echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";

    }
    ?>
    <body>
    <div class="obal">
        <div style="text-align:center">
            <h1>Stránka pro tvorbu nového uživatele:</h1>
        </div>
        <form method="POST">
            <table>
                <tr>
                    <td>JMENO</td>
                    <td><input type='text' name='jmenoGET' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                    </td>
                </tr>

                <tr>
                    <td>ZMENIT HESLO?</td>
                    <td><input type='password' name='hesloGET'>
                    </td>
                </tr>
                <tr>
                    <td>EMAIL</td>
                    <td><input type='email' name='emailGET' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                    </td>
                </tr>
                <tr>
                    <td>ROLE</td>
                    <td><input type='text' name='roleUzivateleGET'
                               value="<?php echo htmlspecialchars($role, ENT_QUOTES); ?>"></td>
                </tr>

            </table>
            <input type='submit' value='ULOŽIT' class='button'/>
            <a href='?page=uzivatel' class='button'>Zpět na uživatele:</a>
        </form>
    </div>
    </body>

    <?php
} else if ($_GET["action"] == "delete") {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    try {
        $obj = new UzivatelRepo($conn);
        $obj->DeleteUzivatel($id);
        header('Location: ?page=uzivatel');

    } catch (PDOException $exception) {
        echo "<div class=\"wrong\">" . "NEMUŽEŠ SMAZAT PROPOJENÉ TABULKY DEMONE!" . $exception->getMessage() . "</div>";
    }


}

?>
