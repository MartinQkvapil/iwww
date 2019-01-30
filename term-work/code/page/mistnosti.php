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
    <a href="?page=mistnosti&action=createMistnost" class="button">Vytvoř místnost</a>

</div>

<div class="mainn">
    <?php
    if ($_GET["action"] == "createMistnost") {
        echo "Vytvářím událost:";
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);


        ?>
        <form method="post">
            <input type="text" name="nazev" placeholder="nazev mistnosti">
            <input type="text" name="popis" placeholder="popis mistnosti">
            <input type="submit" value="ulozit">
        </form>

        <?php


        if (!empty($_POST["nazev"])) {
            $allUsersResult = $obj->createMistnost($_POST["nazev"], $_POST["popis"]);
            echo "succ";
        } else {
            echo "damn neco zle";
        }
    } elseif ($_GET["action"] == "editMistnost") {
        echo "Edituji událost:";
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);

        $allUsersResult = $obj->readOneMistnost($id);

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("idmistnost", "ID");
        $datatable->addColumn("nazev", "Název místnosti");
        $datatable->addColumn("popis", "Popis místnosti");
        $datatable->render();


        $datatable = new DataTable($obj->readVybaveniMistosti($id));

        echo "<a href='?page=mistnosti&action=createVybaveni&id={$id}'>Vytvor vybaveni</a>";

        $datatable->addColumn("idvybaveni", "ID");
        $datatable->addColumn("nazev", "NAZEV");
        $datatable->addColumn("stav", "STAV");
        $datatable->addColumn("popis", "POPIS");
        $datatable->renderSpecial("vybaveni");


    } elseif ($_GET["action"] == "editVybaveni") {
        echo "Edituji vybaveni:";
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);


        $datatable = new DataTable($obj->readVybaveni($id));
        $datatable->addColumn("idvybaveni", "ID");
        $datatable->addColumn("nazev", "NAZEV");
        $datatable->addColumn("stav", "STAV");
        $datatable->addColumn("popis", "POPIS");
        $datatable->render();


    } elseif ($_GET["action"] == "smazVybaveni") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->DeleteVybaveni($id);
        header('Location: ?page=mistnosti&action=smazVybaveni');
    } elseif ($_GET["action"] == "smazMistnost") {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->DeleteMistnost($id);
        header('Location: ?page=mistnosti&action=nic');
    } elseif ($_GET["action"] == "createVybaveni") {
        echo "Vytvářím vybaveni:";
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);

        ?>
        <form method="post">
            <input type="text" name="nazev" placeholder="nazev vybaveni">
            <input type="text" name="popis" placeholder="popis vybaveni">
            <input type="submit" value="ulozit">
        </form>

        <?php


        if (!empty($_POST["nazev"])) {
            $allUsersResult = $obj->createVybaveni($_POST["nazev"], $_POST["popis"], $id);
            echo "succ";
        } else {
            echo "damn neco zle";
        }
    } elseif(($_GET["action"] == "nic")) {
        echo "Všechny místnosti:";
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->getAllMistnosti();


        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("idmistnost", "ID");
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

<div class="right">
    <p>Right Content</p>
</div>

</body>
</html>