<div class="obal">
    <?php
    if ($_GET["action"] == "createMistnost") {
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        ?>
        <div style="text-align:center">
            <h1>Stránka pro tvorbu místnosti:</h1>
        </div>
        <form method="POST">
            <table>
                <tr>
                    <td><p class="formularText">Zadejte název místnosti:</p></td>
                    <td><input name="nazev" type="text"/></td>
                </tr>
                <tr>
                    <td><p class="formularText">Zadejte popis místnosti:</p></td>
                    <td><input name="popis" type="text"/></td>
                </tr>
            </table>

            <input type="submit" value="ULOŽIT"/>

            <a href='?page=mistnosti&action=nic' class='button'>ZPĚT NA PŘEHLED MÍSTNOSTÍ</a>
            <?php
            if (Authentication::getInstance()->CanAdmin()) {
                if ($_POST) {
                    if (!empty($_POST['nazev'])) {

                        $allUsersResult = $obj->createMistnost($_POST["nazev"], $_POST["popis"]);

                        echo "<div class=\"good\">" . "Nová místnost uložena!" . "</div>";
                    } else {
                        echo "<div class=\"wrong\">" . "Vyplńtě formulář" . "</div>";
                    }
                }
            }
            ?>
        </form>


        <?php


    } elseif ($_GET["action"] == "editMistnost") {

        ?>
        <div style="text-align:center">
            <h1>Stránka pro editaci místností:</h1>

            <?php
            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            echo "<td>" . "<a class='button' href='?page=edit-mistnost&id={$id}'>Edit mistnost</a>" . "</td>";
            $conn = Connection::getPdoInstance();
            $obj = new UserRepository($conn);

            $allUsersResult = $obj->readOneMistnost($id);

            $datatable = new DataTable($allUsersResult);
            $datatable->addColumn("idmistnost", "ID");
            $datatable->addColumn("nazev", "Název místnosti");
            $datatable->addColumn("popis", "Popis místnosti");
            $datatable->render();


            $datatable = new DataTable($obj->readVybaveniMistosti($id));

            echo "<a class='button' href='?page=mistnosti&action=createVybaveni&id={$id}'>Vytvor vybaveni</a>";

            $datatable->addColumn("idvybaveni", "ID");
            $datatable->addColumn("nazev", "NAZEV");
            $datatable->addColumn("stav", "STAV");
            $datatable->addColumn("popis", "POPIS");
            $datatable->renderSpecial("vybaveni");
            ?>
        </div>
        <?php

    } elseif ($_GET["action"] == "editVybaveni") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        header('Location: ?page=edit-vybaveni&id=' . $id .'');
    } elseif ($_GET["action"] == "smazVybaveni") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->DeleteVybaveni($id);
        header('Location: ?page=mistnosti&action=nic');
    } elseif ($_GET["action"] == "smazMistnost") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        try {
            $allUsersResult = $obj->DeleteMistnost($id);
            header('Location: ?page=mistnosti&action=nic');
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . "NEMUŽEŠ SMAZAT PROPOJENÉ TABULKY DEMONE!" . $exception->getMessage() . "</div>";
        }
    } elseif ($_GET["action"] == "createVybaveni") {
        ?>
        <div style="text-align:center">
            <h1>Stránka pro vytvoření vybaveni:</h1>
            <?php

            $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            $conn = Connection::getPdoInstance();
            $obj = new UserRepository($conn);

            ?>
            <form method="POST">
                <table>
                    <tr>
                        <td><p class="formularText">Zadejte název místnosti:</p></td>
                        <td><input name="nazev" type="text"/></td>
                    </tr>
                    <tr>
                        <td><p class="formularText">Zadejte popis místnosti:</p></td>
                        <td><input name="popis" type="text"/></td>
                    </tr>
                </table>
                <input type="submit" value="ulozit">
        </div>
        <?php
        echo "<td>" . "<a class='button' href='?page=mistnosti&action=nic'>Return</a>" . "</td>";
        if ($_POST) {
            if (!empty($_POST["nazev"]) && !empty($_POST["popis"])) {
                $allUsersResult = $obj->createVybaveni($_POST["nazev"], $_POST["popis"], $id);
                echo "<div class=\"good\">" . "VYBAVENÍ VYTVOŘENO" . "</div>";
            } else {
                echo "<div class=\"wrong\">" . "VYPLN FORMULAR" . "</div>";
            }
        }
    } elseif (($_GET["action"] == "nic")) {
        ?>
        <a href="?page=mistnosti&action=createMistnost" class="button">Vytvoř místnost</a>
        <?php
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->getAllMistnosti();


        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("nazev", "Název místnosti");
        $datatable->addColumn("popis", "Popis místnosti");
        $datatable->renderSpecial("mistnost");

    }
    /*if ($_GET["action"] == "read-all") {
    echo "<h2>All users</h2>";
    $userDao = new UserRepository(Connection::getPdoInstance());
    $allUsersResult = $userDao->getAllUsers();



}*/
    ?>
</div>

