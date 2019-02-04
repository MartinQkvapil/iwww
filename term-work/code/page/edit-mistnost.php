<?php
if (Authentication::getInstance()->CanAdmin()) {
    $conn = Connection::getPdoInstance();
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    if ($_POST) {
        $a = $_POST['nazev'];
        $b = $_POST['popis'];

        try {
            $obj = new UdalostRepo($conn);
            $obj->UpdateMistnost($id, $a, $b);
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
        }
    }

    try {

        $obj = new UserRepository($conn);
        $row = $obj->readOneMistnost($id);
        $nazev = $row[0]['nazev'];
        $popis = $row[0]['popis'];


    } // show error
    catch (PDOException $exception) {
        echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";

    }
    ?>
    <body>
    <div class="obal">
        <div style="text-align:center">
            <h1>Stránka pro Editaci místnosti:</h1>
        </div>
        <form method="POST">
            <table>
                <tr>
                    <td>Datum</td>
                    <td><input type='text' name='nazev' value="<?php echo htmlspecialchars($nazev, ENT_QUOTES); ?>">
                    </td>
                </tr>

                <tr>
                    <td>Popis</td>
                    <td><input type='text' name='popis' value="<?php echo htmlspecialchars($popis, ENT_QUOTES); ?>">
                    </td>
                </tr>


            </table>
            <input type='submit' value='ULOŽIT' class='button'/>
            <a href='?page=mistnosti&action=nic' class='button'>Zpět na místnosti:</a>
        </form>
    </div>
    </body>

    <?php
}