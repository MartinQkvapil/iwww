<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

$conn = Connection::getPdoInstance();
$obj = new UserRepository($conn);

/*
$datatable = new DataTable($obj->readVybaveni($id));
$datatable->addColumn("idvybaveni", "ID");
$datatable->addColumn("nazev", "NAZEV");
$datatable->addColumn("stav", "STAV");
$datatable->addColumn("popis", "POPIS");
$datatable->render();
*/

if ($_POST) {
    $jmeno = $_POST['nazev'];
    $popis = $_POST['popis'];
    $stav = $_POST['stav'];

    try {
        $obj = new VybaveniRepo($conn);
        $obj->UpdateVybaveni($id, $jmeno, $popis, $stav);
    } catch (PDOException $exception) {
        echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
    }
}

try {

    $obj = new UserRepository($conn);
    $row = $obj->readVybaveni($id);
    $name = $row[0]['nazev'];
    $email = $row[0]['popis'];
    $stav = $row[0]['stav'];

} // show error
catch (PDOException $exception) {
    echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";

}
?>
    <body>
    <div class="obal">
        <div style="text-align:center">
            <h1>Stránka pro editaci vybaveni:</h1>
        </div>
        <form method="POST">
            <table>
                <tr>
                    <td>Nazev</td>
                    <td><input type='text' name='nazev' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Popis</td>
                    <td><input type='text' name='popis' value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Stav</td>
                    <td><input type='text' name='stav' value="<?php echo htmlspecialchars($stav, ENT_QUOTES); ?>">
                    </td>
                </tr>
            </table>
            <input type='submit' value='ULOŽIT' class='button'/>
            <a href='?page=mistnosti&action=nic' class='button'>Zpět na mistnosti:</a>
        </form>
    </div>
    </body>

<?php