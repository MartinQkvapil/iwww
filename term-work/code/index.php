<?php
ob_start();
session_start();
include 'config.php';


function __autoload($className)
{
    if (file_exists('./class/' . $className . '.php')) {
        require_once './class/' . $className . '.php';
        return true;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styl.css" type="text/css">
    <link rel="stylesheet" href="css/index-style.css" type="text/css">
    <title>Nase Kampelicka</title>
</head>
<body>
<header>

    <div class="header" id="wrapper">
        <div id="first">
            <a href="<?= BASE_URL . "?page=index.php" ?>"> <div id="logo"></div> </a>
            <a href="<?= BASE_URL . "?page=index.php" ?>" class="head_text">Naše&nbsp;Kampelička</a>
        </div>
        <div id=second>
            <div class=prihlaseni>
                <?php if (Authentication::getInstance()->hasIdentity()) {
                    $tmp = Authentication::getInstance()->getIdentity();
                    echo "Přihlášený:   " . $tmp['jmeno']; ?>
                    <a href="<?= BASE_URL . "?page=logout" ?>" class="button">LOGOUT</a>
                    <a href="<?= BASE_URL . "?page=muj-ucet" ?>" class="button">MŮJ ÚČET</a>
                    <?php
                } else {
                    ?>
                    <a href="?page=login" class="button">LOGIN</a>
                    <a href="?page=registrace" class="button">REGISTRACE</a>

                    <?php

                } ?>
            </div>
        </div>
    </div>

</header>
<div class="body_div">
    <nav class="menu">
        <?php
        $currentPage = 'home';
        include('header.php'); ?>
    </nav>

    <main class="main">
        <?php
        $file = null;
        if (isset($_GET['page'])) {
            $file = "./page/" . $_GET['page'] . ".php";
            $currentPage = $_GET['page'];
        }
        if (file_exists($file)) {
            include $file;
        } else {
            include('./page/uvod.php');
        }
        ?>
    </main>


</div>
<footer>
    <?php
    include('footer.php')
    ?>
</footer>


</body>
</html>