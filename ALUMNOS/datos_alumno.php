<?php
session_start();
$nombre = "David Daniel";
$ap_pa = "Arguello";
$ap_ma = "Chavez";
$sexo = "M";
$matricula = "202119013";
$carrera = "INGENIERIA EN SISTEMAS COMPUTACIONALES";
$correo = "arguello@gmail.com";
$numero_tel = "5576324867";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS DATOS</title>
    <link rel="stylesheet" href="estilos/datos_alumno.css">
</head>

<body>

    <div class="contenedor">
        <form action='' method="POST">
            <label><span>NOMBRE(S):</span> <?php echo $nombre ?></label><br>

            <label><span>APELLIDO PATERNO:</span> <?php echo $ap_pa ?></label><br>

            <label><span>APELLIDO MATERNO:</span> <?php echo $ap_ma ?></label><br>

            <label><span>SEXO:</span> <?php echo $sexo ?></label><br>

            <label><span>MATRICULA:</span> <?php echo $matricula ?></label><br>

            <label><span>CARRERA:</span> <?php echo $carrera ?></label><br>

            <label><span>CORREO ELECTRONICO:</span> <?php echo $correo ?></label><br>

            <label><span>NÚMERO TELEFÓNICO:</span> <?php echo $numero_tel ?></label><br>


            <div class="botones">
                <input type="submit" name="modificar" value="MODIFICAR INFORMACIÓN">
                <input type="submit" name="volver" id="volver" value="VOLVER">
            </div>


        </form>
    </div>

</body>

</html>


<?php
if (isset($_POST['modificar'])) {
    header("Location: ../ALUMNOS/modificar_alumno.php");
}

if (isset($_POST['volver'])) {
    header("Location: ../ALUMNOS/alumnos.php");
}
?>