<body>
<div class="obal">
    <div class="page-header">
        <h1>Zobrazení správy lístků</h1>
    </div>
    <?php
    if (Authentication::getInstance()->CanAdmin()) {
        $conn = Connection::getPdoInstance();
        $obj = new UdalostRepo($conn);
        $allUsersResult = $obj->getAkce();

        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("nazev_udalosti", "NÁZEV UDÁLOSTI");
        $datatable->addColumn("nazev_mistnosti", "KDE!?");
        $datatable->addColumn("datum", "KDY?!");
        $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
        $datatable->addColumn("cenalistku", "CENA LÍSTKU");
        $datatable->addColumn("pocet_listku", "POČET LÍSTKŮ");
        $datatable->renderSpecial("listky-sp");

    }

    ?>
</div>
</body>
