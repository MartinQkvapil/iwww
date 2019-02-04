<div class="obal">
    <?php
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

    $userDao = new ListekRepo(Connection::getPdoInstance());
    $conn = Connection::getPdoInstance();
    $obj = new ListekRepo($conn);
    $obj->deleteListky($id);

    ?>
</div>
