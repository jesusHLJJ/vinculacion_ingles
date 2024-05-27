<?php

$host = "localhost";
$user = "root";
$pass = "";
$puert = "3308";
$db = "tabla_alumno";

$conec = mysqli_connect($host, $user, $pass, $db, $puert);

if (!$conec) {
    echo "ERRRO " . mysqli_connect_error();
}
?>