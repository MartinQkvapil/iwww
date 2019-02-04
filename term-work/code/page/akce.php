<?php
$conn = Connection::getPdoInstance();
$obj = new UdalostRepo($conn);
?>


<div class="obal">
    <h1>Kalendář akcí</h1>
    <div style="overflow-x:auto;">
        <?php
        $allUsersResult = $obj->getAkce();
        $datatable = new DataTable($allUsersResult);
        $datatable->addColumn("nazev_udalosti", "NÁZEV UDÁLOSTI");
        $datatable->addColumn("nazev_mistnosti", "KDE!?");
        $datatable->addColumn("datum", "KDY?!");
        $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
        $datatable->addColumn("cenalistku", "CENA LÍSTKU");
        $datatable->addColumn("pocet_listku", "POČET LÍSTKŮ");

        $datatable->render();
        ?>
    </div>
</div>
