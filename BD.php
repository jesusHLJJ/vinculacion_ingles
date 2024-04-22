<?php
$conexion = mysqli_connect('localhost','ADMIN','@lonsos@linas150903','vinculacion_ingles');

if (!$conexion) {
    echo '<script>alert("ERROR EN LA CONEXION DE BASE DE DATOS");</script>';
}
?>