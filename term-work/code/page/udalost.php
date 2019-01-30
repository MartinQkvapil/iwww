<?php
$currentPage = 'udalost';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        .left {
            background-color: #2196F3;
            padding: 20px;
            float: left;
            width: 20%; /* The width is 20%, by default */
        }

        .mainn {
            background-color: #f1f1f1;
            padding: 20px;
            float: left;
            width: 60%; /* The width is 60%, by default */
        }

        .right {
            background-color: #4CAF50;
            padding: 20px;
            float: left;
            width: 20%; /* The width is 20%, by default */
        }

        /* Use a media query to add a break point at 800px: */
        @media screen and (max-width: 800px) {
            .left, .mainn, .right {
                width: 100%; /* The width is 100%, when the viewport is 800px or smaller */
            }
        }
    </style>
</head>
<body>


<div class="left">


</div>

<div class="mainn">
    <?php

    if ($_GET["action"] == "createUdalost") {
        echo "Vytvářím událost:";
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $tmp = Authentication::getInstance()->getIdentity();
        $idUziv = $tmp['idUzivatel'];
        echo $idUziv;
        ?>
        <form method="post">
            <input type="text" name="text" placeholder="insert email address">
            <input type="submit" value="Uložit">
        </form>

        <?php


        if (!empty($_POST["text"])) {
            $allUsersResult = $obj->createUdalost($_POST["text"], $idUziv);
            echo "succ";
        }
    } elseif ($_GET["action"] == "editUdalost") {
        echo "Edituji událost:";
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);


        $allUsersResult = $obj->readOneUdalost($id);

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("idudalost", "ID");
        $datatable->addColumn("nazev", "Název události");
        $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");
        $datatable->renderSpecial('udalost');

        $allUsersResult = $obj->readDetailUdalosti($id);

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("popis", "popis");
        $datatable->addColumn("datum", "Datum");
        $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");
        $datatable->renderSpecial('detailUdalosti');
        ?>
        <a href="?page=udalost&action=createDetailUdalosti" class="button">Vytvoř další ročník události</a>
        <?php
        if (!empty($_POST["text"])) {
            $allUsersResult = $obj->createUdalost($_POST["text"], $idUziv);
            echo "succ";
        }

    } elseif ($_GET["action"] == "createDetailUdalosti") {
        echo "create detail událost:";

        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $tmp = Authentication::getInstance()->getIdentity();
        $idUziv = $tmp['idUzivatel'];
        echo $idUziv;

        $combobox_data = array();
        $mistnosti = $obj->getAllMistnosti();
        $udalosti = $obj->getAllUdalosti();
        ?>

        <?php
        ?>
        <form action="#" method="post">
            <input type="date" name="datum">
            <input type="text" name="popis" placeholder="popis...">
            <input type="number" name="pocet_listku" placeholder="počet lístků">
            <input type="number" name="cena_listku" placeholder="cena lístku">
            <select name="mistnosti">
                <?php
                foreach ($mistnosti as $item) {

                    echo '<option value="' . $item['idmistnost'] . '">' . $item['nazev'] . '</option>';
                }
                ?>
            </select>
            <select name="udalosti">
                <?php
                foreach ($udalosti as $item) {

                    echo '<option value="' .  $item['idudalost'] . '">' . $item['nazev'] . '</option>';
                }
                ?>
            </select>

            <input type="submit" name="submit" value="Vytvořit">
        </form>

        <?php



        if (!empty($_POST["datum"]) && !empty($_POST["popis"]) && !empty($_POST["pocet_listku"]) && !empty($_POST["cena_listku"])) {

            $allUsersResult = $obj->createDetailUdalosti($_POST["datum"], $_POST['popis'], $_POST['pocet_listku'], $_POST['cena_listku'], $_POST['udalosti'], $idUziv, $_POST['mistnosti']);
            echo "succ";
        }
        else {
            echo "err";
        }


    } elseif ($_GET["action"] == "editdetailUdalosti") {
        echo "Edituji detail udalosti:";


    } elseif ($_GET["action"] == "smazUdalost") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->DeleteUdalost($id);
        header('Location: ?page=udalost&action=nic');

    } elseif ($_GET["action"] == "smazdetailUdalosti") {
        echo "mazu detail";
    } else {
        echo "Všechny události:";
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->getAllUdalosti();

        $tmp = Authentication::getInstance()->getIdentity();
        $idUziv = $tmp['idUzivatel'];

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("idudalost", "ID");
        $datatable->addColumn("nazev", "Název události");
        $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");

        $datatable->renderSpecial("udalost");
        ?>
        <a href="?page=udalost&action=createUdalost" class="button">Vytvoř událost</a>
        <?php


    }
    /*if ($_GET["action"] == "read-all") {
    echo "<h2>All users</h2>";
    $userDao = new UserRepository(Connection::getPdoInstance());
    $allUsersResult = $userDao->getAllUsers();



}*/
    ?>
</div>

<div class="right">

</div>

</body>
</html>