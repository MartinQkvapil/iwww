<body>
<div class="obal">
    <div style="text-align:center">
        <h1>Stránka pro tvorbu  místnosti:</h1>
    </div>
    <form method="POST">
        <table>
            <tr>
                <td><p class="formularText">Zadejte název místnosti:</p></td>
                <td><input name="jmeno" type="text"/></td>
            </tr>
            <tr>
                <td><p class="formularText">Zadejte popis místnosti:</p></td>
                <td><input name="jmeno" type="text"/></td>
            </tr>
        </table>

        <input type="submit" value="ULOŽIT"/>

        <a href='?page=mistnosti&action=nic' class='button'>ZPĚT NA PŘEHLED MÍSTNOSTÍ</a>
        <?php
        if(Authentication::getInstance()->CanAdmin()) {
            if ($_POST) {
                if (!empty($_POST['jmeno'])) {
                    $conn = Connection::getPdoInstance();
                    $obj = new UserRepository($conn);
                    $tmp = Authentication::getInstance()->getIdentity();
                    $idUziv = $tmp['idUzivatel'];
                    $obj->createUdalost($_POST["jmeno"], $idUziv);
                    echo "<div class=\"good\">" . "Nová místnost uložena!" . "</div>";
                } else {
                    echo "<div class=\"wrong\">" . "Vyplńtě formulář" . "</div>";
                }
            }
        }
        ?>
    </form>
</div>
</body>

