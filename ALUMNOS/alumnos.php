<?php include '../conn_bd.php';
session_start();


//Se van a obtener los datos de las sesiones y de la base de datos
$alumno = "DAVID DANIEL ARGUELLO CHAVEZ";

$grupo = '1A';
$nivel = 5;
$docente = 'karla';
$horario = '8:00 a 12:00 hrs';
$periodo = 'Intersemestral';
$aula = 'K9';
//_________________________________________________________________

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNOS</title>
    <link rel="stylesheet" href="estilos/alumnos.css">
</head>

<body>

    <h1><?php echo $alumno; ?></h1>
    <div class="contenedor_botones">
        <form action='' method="POST">
            <input type='submit' name="actas" value="VER ACTAS/CALIFICACIONES">
            <input type='submit' name="inscribirse" value="INSCRIBIRSE">
            <input type='submit' name="reinscribirse" value="REINSCRIBIRSE">
            <input type='submit' id="cerrar" name="cerrar" value="CERRAR SESION">
        </form>
    </div>
    <div class="tabla_contenido">
        <table border="1">
            <tr>
                <th>GRUPO</th>
                <th>NIVEL</th>
                <th>DOCENTE</th>
                <th>HORARIO</th>
                <th>PERIODO</th>
                <th>AULA</th>
            </tr>
            <tr>
                <td><?php echo $grupo; ?></td>
                <td><?php echo $nivel; ?></td>
                <td><?php echo $docente; ?></td>
                <td><?php echo $horario; ?></td>
                <td><?php echo $periodo; ?></td>
                <td><?php echo $aula; ?></td>
            </tr>
        </table>
    </div>
</body>

</html>


<?php
//Logica de los botones - Lo que pasa al pulsarlo
if (isset($_POST['actas'])) {
    header("Location: ../ALUMNOS/actas.php");
}

if (isset($_POST['inscribirse'])) {
    header("Location: ../ALUMNOS/inscribirse.php");
}

if (isset($_POST['reinscribirse'])) {
    header("Location: ../ALUMNOS/reinscribirse.php");
}

if (isset($_POST['cerrar'])) {
    header("Location: ../index.php");
    session_destroy();
}
?>