<?php
$conn = Connection::getPdoInstance();
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
if ($_POST) {
    $jmeno = $_POST['nazev'];

    try {
        $obj = new UdalostRepo($conn);
        $idUzivatele = Authentication::getInstance()->getIDUZIVATEL();
        $obj->UpdateNazevUdalosti($id, $jmeno, $idUzivatele);
    } catch (PDOException $exception) {
        echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
    }
}

try {

    $obj = new UdalostRepo($conn);
    $row = $obj->readOneUdalost($id);
    $name = $row[0]['nazev'];

} // show error
catch (PDOException $exception) {
    echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";

}
?>
    <body>
    <div class="obal">
        <div style="text-align:center">
            <h1>Stránka pro editaci názvu události:</h1>
        </div>
        <form method="POST">
            <table>
                <tr>
                    <td>Uprav název:</td>
                    <td><input type='text' name='nazev' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
                    </td>
                </tr>



            </table>
            <input type='submit' value='ULOŽIT' class='button'/>
            <a href='?page=udalost&action=nic' class='button'>Zpět na události</a>
        </form>
    </div>
    </body>

<?php