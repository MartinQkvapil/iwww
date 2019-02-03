<div class="obal">
    <h1>Můj účet:</h1>
    <div style="overflow-x:auto;">
        <?php
        $userDao = new UserRepository(Connection::getPdoInstance());
        $conn = Connection::getPdoInstance();

        $id = Authentication::getInstance()->getIdentity()['idUzivatel'];

        if ($_POST) {
            $jmeno = $_POST['jmenoGET'];
            $email = $_POST['emailGET'];
            $heslo = password_hash($_POST['hesloGET'], PASSWORD_DEFAULT);
            if (empty($heslo)) {
                $heslo = $heslo2;
            } else {

            }
            $roleUzivatele = "registrovany";
            try {
                $obj = new UzivatelRepo($conn);
                $obj->UpdateUzivatel($id, $jmeno, $heslo, $email, $roleUzivatele);
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        try {

            $obj = new UzivatelRepo($conn);
            $row = $obj->ReadUzivatel($id);

            $name = $row[0]['jmeno'];
            $heslo2 = $row[0]['heslo'];
            $email = $row[0]['email'];
            $role = "registrovany";
        } // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }


        ?>


        <form method="post">
            <table >

                <tr>
                    <td>JMENO</td>
                    <td><input type='text' name='jmenoGET' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>"
                               class='form-control'/></td>
                </tr>

                <tr>
                    <td>NOVÉ HESLO</td>
                    <td><input type='text' name='hesloGET' value=""
                               class='form-control'/></td>
                </tr>
                <tr>
                    <td>EMAIL</td>
                    <td><input type='text' name='emailGET' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>"
                               class='form-control'/></td>
                </tr>
            </table>
            <input type='submit' value='Save Changes' class='button'/>

        </form>

        <h1>Moje lístky:</h1>
        <table>
            <td> <img src="./pics/red.png" width='20' height='20' > <p> STORNO </p></td>
            <td> <img src="./pics/green.png" width='20' height='20' > <p> ZAPLACENO </p></td>
            <td> <img src="./pics/orange.png" width='20' height='20' > <p> NEZAPLACENO </p></td>
        </table>


        <?php
        $userDao = new UserRepository(Connection::getPdoInstance());
        $obj = new UdalostRepo($conn);


        $datatable = new DataTable($listky = $obj->getListky(Authentication::getInstance()->getIDUZIVATEL()));


        $datatable->addColumn("idfaktura", "ID");

        $datatable->addColumn("pocetlistku", "POČET LÍSTKŮ");
        $datatable->addColumn("datum", "datum");
        $datatable->addColumn("detail_udalosti_iddetail_udalosti", "id udalosti");


        $datatable->renderSpecial("storno");

        ?>

    </>
</div>

