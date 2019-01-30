<?php
/**
 * Created by PhpStorm.
 * User: qvapim
 * Date: 1/19/2019
 * Time: 7:04 PM
 */
$host = "localhost";
$db_name = "mydb";
$username = "root";
$password = "";

define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}

// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>