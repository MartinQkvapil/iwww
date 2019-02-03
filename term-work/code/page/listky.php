<body>
<div class="obal">
    <div class="page-header">
        <h1>Zobrazení událostí pro nákup lístků</h1>
    </div>
    <?php
    if ($_GET["action"] == "koupitListek") {


    } else {
        $conn = Connection::getPdoInstance();
        $obj = new UdalostRepo($conn);
        $allUsersResult = $obj->getAkce();

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("iddetail_udalosti", "ID");
        $datatable->addColumn("nazev_udalosti", "NÁZEV UDÁLOSTI");
        $datatable->addColumn("nazev_mistnosti", "KDE!?");
        $datatable->addColumn("datum", "KDY?!");
        $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
        $datatable->addColumn("cenalistku", "CENA LÍSTKU");
        $datatable->addColumn("pocet_listku", "POČET LÍSTKŮ");
        $datatable->renderSpecial("listky");

    }

    ?>
</div>
</body>
