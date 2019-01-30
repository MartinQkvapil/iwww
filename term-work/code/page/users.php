<h1>Users</h1>
<?php
if ($_GET["action"] == "read-all") {
    echo "<h2>All users</h2>";
    $userDao = new UserRepository(Connection::getPdoInstance());
    $allUsersResult = $userDao->getAllUsers();

    $datatable = new DataTable($allUsersResult);
    $datatable->addColumn("iduzivatel", "ID");
    $datatable->addColumn("email", "Email");
    $datatable->addColumn("jmeno", "Jmeno");
    $datatable->render();

} else if ($_GET["action"] == "by-email") {
    echo "<h2>By email</h2>";
    ?>

    <form method="post">
        <input type="text" name="mail" placeholder="insert email address" >
        <input type="submit" value="Find by email">
    </form>

    <?php

    if (!empty($_POST["mail"])) {
        $userDao = new UserRepository(Connection::getPdoInstance());
        $usersByEmail = $userDao->getByEmail($_POST["mail"]);
        $datatable = new DataTable($usersByEmail);
        $datatable->addColumn("iduzivatel", "ID");
        $datatable->addColumn("email", "Email");
        $datatable->addColumn("jmeno", "Jmeno");
        $datatable->render();
    }
}

?>