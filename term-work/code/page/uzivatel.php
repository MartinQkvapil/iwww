<!DOCTYPE HTML>
<html>
<head>


</head>
<body>


<div class="obal">
    <div class="page-header">
        <h1>Správa uživatelů:</h1>
    </div>
    <?php

    if (Authentication::getInstance()->getRole() == "admin") {
        include 'config/database.php';
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        $query = "SELECT idUzivatel, jmeno, heslo, email, roleUzivatele FROM uzivatel ORDER BY idUzivatel DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();


        echo "<a href='?page=uzivatelFinal&action=create'' class='button'>Vytvor nového uzivatele</a>";

        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table'>";//start table

            //creating our table heading
            echo "<tr class='table tr'>";
            echo "<th class='table th'>ID</th>";
            echo "<th>JMENO</th>";
            echo "<th>HESLO</th>";
            echo "<th>EMAIL</th>";
            echo "<th>ROLE UZIVATELE</th>";
            echo "</tr>";


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to
                // just $firstname only
                extract($row);

                // creating new table row per record
                echo "<tr>";
                echo "<td class='table td'>{$idUzivatel}</td>";
                echo "<td>{$jmeno}</td>";
                echo "<td>{$heslo}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$roleUzivatele}</td>";
                echo "<td>";
                // read one record
                //"?page=uzivatelFinal&action=by-email"
                echo "<a href='?page=uzivatelFinal&id={$idUzivatel}&action=read-one' class='button'>Read-one</a>";

                // we will use this links on next part of this post
                echo "<a href='?page=uzivatelFinal&id={$idUzivatel}&action=edit' class='button'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='?page=uzivatelFinal&id={$idUzivatel}&action=delete'  class='button'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            // end table
            echo "</table>";

        } // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
    } else {
        echo "you DO NOT have access";
    }
    ?>

</div>
<script type='text/javascript'>
    // confirm record deletion
    function delete_user(id) {

        var answer = confirm('Are you sure?');
        if (answer) {
            // if user clicked ok,
            // pass the id to delete.php and execute the delete query
            window.location = './page/ddd.php?id=' + id;
        }
    }
</script>
</body>
</html>
