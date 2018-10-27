<?php
include "./config.php"; //load configurations

#process of a message
$message = "";
if (isset($_POST['newsletter'])) {
    if (!empty($_POST['email'])) {
        if ((preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $_POST['email']))) {
            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // prepare sql and bind parameters
                $stmt = $conn->prepare("INSERT INTO newsletter (email, created) VALUES (:email, NOW())");
                $stmt->bindParam(':email', $_POST["email"]);
                $stmt->execute();

                $message = "Your are subscribed!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                $message = "Unable to save to the database!";
            }
        } else {
            $message = "Bad formatted email address!";
        }
    } else {
        $message = "Email address is needed!";
    }
}

//create table newsletter
//(
//	id int auto_increment primary key,
//	email varchar(255) not null,
//	created datetime not null
//);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test web</title>
</head>
<body>
<nav id="nav">
    <a href="<?= BASE_URL ?>">Home</a>
    <a href="<?= BASE_URL . "?page=blog" ?>">Blog</a>
    <a href="<?= BASE_URL . "?page=contact-me" ?>">Contact me</a>
</nav>


<?php
#feedback message
if (!empty($message)) {
    echo $message;
    $message = "";
}
?>
<main>

    <?php

    $file = "./page/" . $_GET["page"] . ".php";
    if (file_exists($file)) {
        include $file;
    } else {
        include "./page/default.php";
    }
    ?>

</main>
<section>
    <p>Copyleft
        <?= date("Y", strtotime("-1 year")); ?>
        -
        <?php echo date("Y"); ?>
        <a href="https://github.com">Honza</a></p>
</section>
</body>
</html>

