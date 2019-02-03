<html>
<head>
    <title>Registrace</title>
</head>
<body>
<h1>Registrace:</h1>
<form class=box method="post">
    <input class="email" type="text" name="regname" placeholder="Zadejte jméno..">
    <input class="email" type="email" name="regemail" placeholder="Zadejte email..">
    <input class="password" type="password" name="regpass1" placeholder="Zadejte heslo...">
    <input class="password" type="password" name="regpass2" placeholder="Zadejte heslo...">
    <input class="button" type="submit" value="Registrovat se">

</form>
</body>
</html>


<?php
if ($_POST) {
    if ($_POST["regname"] && $_POST["regemail"] && $_POST["regpass1"] && $_POST["regpass2"]) {
        if ($_POST["regpass1"] == $_POST["regpass2"]) {
            $jmeno = $_POST['regname'];
            $email = $_POST['regemail'];
            $heslo = $_POST['regpass1'];
            $roleUzivatele = 'registrovany';
            try {
                $conn = Connection::getPdoInstance();
                $obj = new UzivatelRepo($conn);
                $obj->CreateUzivatel($jmeno, $heslo, $email, $roleUzivatele);
                header('Location: ?page=login');
            } catch (PDOException $exception) {
                echo "<div class=\"wrong\">Chybné údaje!!!</div>";
            }


        } else echo "<div class=\"wrong\">Hesla se neshodují</div>";
    } else echo "<div class=\"wrong\">Nevalidní vstupní data</div>";
}
?>