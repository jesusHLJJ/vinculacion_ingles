<?php

$host = "localhost";
$user = "root";
$pass = "";
$puert = "3308";
$db = "vinculacion_ingles";

$conec = mysqli_connect($host, $user, $pass, $db, $puert);

if (!$conec) {
    echo "ERRRO " . mysqli_connect_error();
}
?>