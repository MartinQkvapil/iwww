

<?php
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
</head>
<body>
<div class="left">

</div>


<div>
    <h1>Kalendář akcí</h1>
    <div style="overflow-x:auto;">
        <?php
        $conn = Connection::getPdoInstance();
        $obj = new UserRepository($conn);
        $allUsersResult = $obj->getAllDetailUdalosti();


        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("datum", "DATUM KONÁNÍ");
        $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
        $datatable->addColumn("pocet_listku", "Počet lístků");
        //$datatable->addButton( "nazev", "Editace");
        $datatable->render();
        ?>
    </div>
</div>



</body>
</html>
