<?php
$currentPage = 'udalost';
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="left">

</div>

<div class="mainn">
    <?php
    if ($_GET["action"] == "koupitListek") {


    } else {
        echo "Všechny události:";
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->getAllUdalosti();



        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("idudalost", "ID");
        $datatable->addColumn("nazev", "Název události");
        $datatable->addColumn("uzivatel_iduzivatel", "Kdo vytvořil událost");
        //$datatable->addButton( "nazev", "Editace");
        $datatable->renderSpecial("udalost");

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