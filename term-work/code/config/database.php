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





try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}

// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>