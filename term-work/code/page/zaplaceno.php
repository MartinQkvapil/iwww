<div class="obal">
    <?php
    if (Authentication::getInstance()->CanAdmin()) {
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $userDao = new ListekRepo(Connection::getPdoInstance());
        $conn = Connection::getPdoInstance();
        $obj = new ListekRepo($conn);
        $obj->listekZaplacen($id);
    }
    ?>
</div>
