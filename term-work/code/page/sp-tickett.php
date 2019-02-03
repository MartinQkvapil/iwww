<body>
<div class="obal">
    <div class="page-header">
        <h1>Proces nákupu lístků:</h1>
    </div>
    <?php

    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');


    $conn = Connection::getPdoInstance();
    $obj = new UdalostRepo($conn);
    $allUsersResult = $obj->getAkceOne($id);


    $datatable = new DataTable($allUsersResult);


    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("nazev_udalosti", "NÁZEV UDÁLOSTI");
    $datatable->addColumn("nazev_mistnosti", "KDE!?");
    $datatable->addColumn("datum", "KDY?!");
    $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
    $datatable->addColumn("cenalistku", "CENA LÍSTKU");
    $datatable->addColumn("pocet_listku", "POČET LÍSTKŮ");
    //$datatable->addButton( "nazev", "Editace");
    $datatable->render();

    //  createListek(int $pocetListku, int $zaplaceno, string $uzivatel, string $idUdalosti)
    $allUsersResult = $obj->getListkyKakci($id);

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("idfaktura", "ID");


    //$datatable->addButton( "nazev", "Editace");
    $datatable->renderSpecial("sp-listku");
    ?>

</div>
</body>
