<div class="obal">
    <div class="page-header">
        <h1>Správa uživatelů:</h1>
    </div>
    <?php
    if (Authentication::getInstance()->CanAdmin()) {
    echo "<a class='button' href='?page=vytvor-uzivatele'>VYTVOŘIT UŽIVATELE</a>";

        try {
            $obj = new UzivatelRepo(Connection::getPdoInstance());
            $row = $obj->getAllUsers();

            $datatable = new DataTable($row);
            $datatable->addColumn("iduzivatel", "ID");
            $datatable->addColumn("email", "EMAIL");
            $datatable->addColumn("jmeno", "JMÉNO");
            $datatable->addColumn("roleUzivatele", "ROLE");
            $datatable->renderSpecial('uzivatel');
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
        }
    } else {
        header('Location: ?page?=uvod.php');
    }
    ?>

</div>

