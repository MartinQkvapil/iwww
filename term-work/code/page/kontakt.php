<?php
$currentPage = 'kampelicka';
?>
<!DOCTYPE html>
<html>
<head>
    <style>

    </style>
</head>
<body>
<div class="obal">
    <div style="text-align:center">
        <h1>Kontaktujte Nás:</h1>
    </div>
    <div class="row">
        <div class="column">
            <img src="./pics/frontold.jpg" style="width:90%">
        </div>
        <div class="column">
            <form action="/do_kontakt.php">
                <label for="fname">Jméno</label>
                <input type="text" id="fname" name="jmeno" placeholder="Vaše jméno..">
                <label for="lname">Přijmení</label>
                <input type="text" id="lname" name="prijmeni" placeholder="Vaše příjmení..">

                <label for="subject">Sdělení</label>
                <input type="text" id="l2name" name="prijmeni" placeholder="sdělení..">
                <input type="submit" value="Odeslat">
            </form>
        </div>
    </div>
</div>



</body>
</html>
