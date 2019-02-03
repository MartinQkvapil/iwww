<?php
$conn = Connection::getPdoInstance();
if ($_GET["action"] == "editUdalost") {
?>
<body>
<div class="obal">
    <div style="text-align:center">
        <h1>Stránka pro editaci názvu události a přidání ročníku:</h1>
    </div>
    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
    $conn = Connection::getPdoInstance();
    $obj = new UserRepository($conn);

    echo "<td>" . "<a class='button' href='?page=edit-nazev-udalost&id={$id}'>EDITUJ NÁZEV UDÁLOSTI</a>" . "</td>";

    $allUsersResult = $obj->readOneUdalost($id);

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("idudalost", "ID");
    $datatable->addColumn("nazev", "Název události");
    $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");
    $datatable->render();

    $allUsersResult = $obj->readDetailUdalosti($id);

    ?>
    <br>
    <?php
    echo "<td>" . "<a  class='button' href='?page=udalost&action=createDetailUdalosti&id={$id}'>VYTVOŘIT DALŠÍ DETAIL UDÁLOSTI</a>" . "</td>";

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("popis", "popis");
    $datatable->addColumn("datum", "Datum");
    $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");
    $datatable->renderSpecial('detailUdalosti');

    if (!empty($_POST["text"])) {
        $allUsersResult = $obj->createUdalost($_POST["text"], $idUziv);
        echo "succ";
    }

    } elseif ($_GET["action"] == "createDetailUdalosti") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        ?>
        <body>
        <div class="obal">
            <h1>Tvořím ročník události:</h1>
            <?php

            $conn = Connection::getPdoInstance();
            $obj = new UserRepository($conn);
            $tmp = Authentication::getInstance()->getIdentity();
            $idUziv = $tmp['idUzivatel'];
            $combobox_data = array();
            $mistnosti = $obj->getAllMistnosti();
            $udalosti = $obj->getAllUdalosti();

            ?>

            <form method="POST">
                <table>
                    <tr>
                        <td>DATUM KONÁNÍ UDÁLOSTI</td>
                        <td><input type="date" name="datum">
                        </td>
                    </tr>

                    <tr>
                        <td>POPIS</td>
                        <td><input type="text" name="popis" placeholder="popis...">
                        </td>
                    </tr>
                    <tr>
                        <td>POČET LÍSTKŮ NA UDÁLOST</td>
                        <td><input type="number" name="pocet_listku" placeholder="počet lístků">
                        </td>
                    </tr>
                    <tr>
                        <td>CENA JEDNOHO LÍSTKU</td>
                        <td><input type="number" name="cena_listku" placeholder="cena lístku"></td>
                    </tr>
                    <tr>
                        <td>MÍSTO KONÁNÍ</td>
                        <td><select name="mistnosti">
                                <?php
                                foreach ($mistnosti as $item) {
                                    echo '<option value="' . $item['idmistnost'] . '">' . $item['nazev'] . '</option>';
                                }
                                ?>
                            </select></td>
                    </tr>
                </table>
                <input type='submit' value='ULOŽIT' class='button'/>
                <a href='?page=udalost&action=nic' class='button'>Zpět na události:</a>

                <?php

                if ($_POST) {
                    if (!empty($_POST["datum"]) && !empty($_POST["popis"]) && !empty($_POST["pocet_listku"]) && !empty($_POST["cena_listku"])) {
                        $allUsersResult = $obj->createDetailUdalosti($_POST["datum"], $_POST['popis'], $_POST['pocet_listku'], $_POST['cena_listku'], $id, $idUziv, $_POST['mistnosti']);
                        echo "<div class=\"good\">" . "Událost vytvořena" . "</div>";
                    } else {
                        echo "<div class=\"wrong\">" . "Chyba při vytváření události" . "</div>";
                    }
                }
                ?>
        </div>
        </body>

        <?php

    } elseif ($_GET["action"] == "editdetailUdalosti") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        if ($_POST) {
            $a = $_POST['datum'];
            $b = $_POST['popis'];
            $c = $_POST['pocet_listku'];
            $d = $_POST['cena_listku'];
            $e = $_POST['mistnosti'];
            try {
                $obj = new UdalostRepo($conn);
                $obj->UpdateUdalost($id, $a, $b, $c, $d, $e);
            } catch (PDOException $exception) {
                echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
            }
        }

        try {

            $obj = new UserRepository($conn);
            $row = $obj->readOneDetailUdalosti($id);
            $datum = $row[0]['datum'];
            $popis = $row[0]['popis'];
            $pocet_listku = $row[0]['pocet_listku'];
            $cena_listku = $row[0]['cenalistku'];
            $mistnosti = $obj->getAllMistnosti();


        } // show error
        catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";

        }
        ?>
        <body>
        <div class="obal">
            <div style="text-align:center">
                <h1>Stránka pro Editaci události:</h1>
            </div>
            <form method="POST">
                <table>
                    <tr>
                        <td>Datum</td>
                        <td><input type='date' name='datum' value="<?php echo htmlspecialchars($datum, ENT_QUOTES); ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Popis</td>
                        <td><input type='text' name='popis' value="<?php echo htmlspecialchars($popis, ENT_QUOTES); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Počet listku</td>
                        <td><input type='number' name='pocet_listku'
                                   value="<?php echo htmlspecialchars($pocet_listku, ENT_QUOTES); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Cena listku</td>
                        <td><input type='number' name='cena_listku'
                                   value="<?php echo htmlspecialchars($cena_listku, ENT_QUOTES); ?>"></td>
                    </tr>
                    <tr>
                        <td>Mistnost</td>
                        <td><select name="mistnosti">
                                <?php
                                foreach ($mistnosti as $item) {
                                    echo '<option value="' . $item['idmistnost'] . '">' . $item['nazev'] . '</option>';
                                }
                                ?>
                            </select></td>
                    </tr>

                </table>
                <input type='submit' value='ULOŽIT' class='button'/>
                <a href='?page=udalost&action=nic' class='button'>Zpět na udalosti:</a>
            </form>
        </div>
        </body>

        <?php


    } elseif ($_GET["action"] == "smazUdalost") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        try {
            $obj = new UserRepository($conn);
            $allUsersResult = $obj->DeleteUdalost($id);
            header('Location: ?page=udalost&action=nic');
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . "NEMUŽEŠ SMAZAT PROPOJENÉ TABULKY DEMONE!" . $exception->getMessage() . "</div>";
        }
    } elseif ($_GET["action"] == "smazdetailUdalosti") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        try {
            $conn = Connection::getPdoInstance();
            $obj = new UdalostRepo($conn);
            $allUsersResult = $obj->DeleteDetail($id);

        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . "NEMUŽEŠ SMAZAT PROPOJENÉ TABULKY DEMONE!" . $exception->getMessage() . "</div>";
        }

    } else {
        ?>
        <body>
        <div class="obal">
            <div class="page-header">
                <h1>Zobrazení událostí:</h1>
            </div>
            <a href="?page=vytvor-udalost" class="button">Vytvoř událost</a>
            <?php

            $conn = Connection::getPdoInstance();
            $obj = new UserRepository($conn);
            $allUsersResult = $obj->getAllUdalosti();

            $tmp = Authentication::getInstance()->getIdentity();
            $idUziv = $tmp['idUzivatel'];

            $datatable = new DataTable($allUsersResult);

            $datatable->addColumn("nazev", "Název události");


            $datatable->renderSpecial("udalost");
            ?>
        </div>
        </body>
        <?php


    }

    /* ?>

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

        <?php*/

    ?>
