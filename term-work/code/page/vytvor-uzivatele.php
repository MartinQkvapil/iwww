<body>
<div class="obal">
    <div style="text-align:center">
        <h1>Stránka pro tvorbu nového uživatele:</h1>
    </div>
    <form method="POST">
        <table>
            <tr>
                <td><p class="formularText">Zadejte jméno:</p></td>
                <td><input name="jmeno" type="text"/></td>
            </tr>
            <tr>
                <td><p class="formularText">Zadejte email:</p></td>
                <td><input name="email" type="email"/></td>
            </tr>
            <tr>
                <td><p class="formularText">Zadejte heslo:</p></td>
                <td><input name="heslo" type="password"/></td>
            </tr>
            <tr>
                <td><p class="formularText">Zatejte uživatelskou roli:</p></td>
                <td><select name="role">
                        <option value="admin">Administrátor</option>
                        <option value="registrovany">Registrovaný</option>
                    </select></td>
            </tr>
        </table>

        <input type="submit" value="ULOŽIT"/>
        <a href='?page=uzivatel' class='button'>ZPĚT NA PŘEHLED UŽIVATELŮ</a>
    </form>
</div>
</body>

<?php
if ($_POST) {
    if (isset($_POST['jmeno']) && $_POST['heslo'] && isset($_POST['email']) && $_POST['role']) {
        $jmeno = $_POST['jmeno'];
        $email = $_POST['email'];
        $heslo = $_POST['heslo'];
        $roleUzivatele = $_POST['role'];
        try {
            $obj = new UzivatelRepo(Connection::getPdoInstance());
            $obj->CreateUzivatel($jmeno, $heslo, $email, $roleUzivatele);
        } catch (PDOException $exception) {
            echo "<div class=\"wrong\">" . $exception->getMessage() . "</div>";
        }
    } else {
        $hlaska = 'Formulář není správně vyplněný!';
        echo "<div class=\"wrong\">" . $hlaska . "</div>";
    }
}
?>