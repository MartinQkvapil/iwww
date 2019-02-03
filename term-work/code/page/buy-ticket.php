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

    $datatable->addColumn("nazev_udalosti", "NÁZEV UDÁLOSTI");
    $datatable->addColumn("nazev_mistnosti", "KDE!?");
    $datatable->addColumn("datum", "KDY?!");
    $datatable->addColumn("popis", "DETAILY UDÁLOSTI");
    $datatable->addColumn("cenalistku", "CENA LÍSTKU");
    $datatable->addColumn("pocet_listku", "POČET LÍSTKŮ");


    //$datatable->addButton( "nazev", "Editace");
    $datatable->render();

    //  createListek(int $pocetListku, int $zaplaceno, string $uzivatel, string $idUdalosti)

    ?>
    <form method="POST">
        <table>
            <tr>
                <td><p class="formularText">Zadejte počet lístků k registraci:</p></td>
                <td><input name="pocetListku" type="number" min="1" max="10"/></td>
            </tr>
        </table>
        <input type="submit" value="ZAMLUVIT"/>
    </form>

    <?php
    if ($_POST) {
        if ($_POST['pocetListku']) {
            $tmp2 =  $obj->getAkceOne($id);
            $obj = new ListekRepo($conn);
            $tmp = $obj->kolikProdanych($id);
            $int = ($_POST['pocetListku']);

            $tmp4= $tmp[0][0] + $int;
            $tmp3 = $tmp2[0]['pocet_listku'];
          // echo $tmp4;

            if($tmp4 <= $tmp3){

            $obj = new UdalostRepo($conn);
            $result = $obj->createListek($_POST['pocetListku'], 1, Authentication::getInstance()->getIdentity()['idUzivatel'], $id);
            echo "<div class=\"good\">" . "Lístek Registrovan:!" . "</div>";
            } else {

                echo "<div class=\"wrong\">" . "Omlouváme se na akci už není kapacita" . "</div>";
            }
        } else {
            echo "<div class=\"wrong\">" . "Zadejte počet Listků" . "</div>";

        }
    }


    ?>
</div>
</body>
