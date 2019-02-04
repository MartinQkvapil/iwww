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

        $obj = new ListekRepo($conn);
        $result = $obj->getListkyProExport();

        $json_arrry = $result;
        $fp = fopen('./page/export.json', 'w');
        if ($fp) {
            fwrite($fp, json_encode($result, JSON_PRETTY_PRINT));
            fclose($fp);
            echo "<br>" . "<a class='button' href=\"http://localhost:63342/kampelicka/code/page/export.json\" download>STÁHNOUT JSON</a><br>";
        }

        ?>
        <form method="post" enctype="multipart/form-data">
            JSON File <input type="file" name="jsonFile">
            <br>
            <input type="submit" value="Import" name="submit">
        </form>
        <?php


        if ($_POST) {
            if (isset($_POST["submit"])) {
                if ($neco = $_FILES["jsonFile"]['tmp_name']) {
                    $retezec = file_get_contents($neco);
                    $rozparsovan = json_decode($retezec, true);
                    foreach ($rozparsovan as $product) {
                        $obj = new ListekRepo($conn);
                        //  print_r($product);
                        //$id, $pocetListku, $datum, $nazevUdalosti, $zaplaceno, $uzivatel_iduzivatel, $detail_udalosti_iddetail_udalosti)
                        $obj->updateListky($product['idfaktura'], $product['pocetlistku'], $product['datum'], 0, $product['zaplaceno'],
                            $product['uzivatel_iduzivatel'], $product['detail_udalosti_iddetail_udalosti']);
                    }
                    echo "<div class=\"good\">" . "uspěšný import!" . "</div>";
                } else {
                    echo "<div class=\"wrong\">" . "Spatný soubor asi!" . "</div>";

                }


            }
        }
    }

    ?>
</div>

