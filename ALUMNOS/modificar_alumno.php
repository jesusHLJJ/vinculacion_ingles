<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS DATOS</title>
    <link rel="stylesheet" href="estilos/modificar_alumno.css">
</head>

<body>

    <div class="contenedor_botones">
        <form action='' method="POST">

            <label>CORREO ELECTRONICO: <br><span>arguello@gmail.com</span></label><br>

            <label for="nombre">NOMBRE(S)</label>
            <input type="text" id="nombre"><br>

            <label for="ap_pa">APELLIDO PATERNO</label>
            <input type="text" id="ap_pa"><br>

            <label for="ap_ma">APELLIDO MATERNO</label>
            <input type="text" id="ap_ma"><br>

            <label for="ap_ma">MATRICULA</label>
            <input type="text" id="ap_ma"><br>

            <label for="carrera">CARRERA</label>
            <select name="carrera" id="carrera">
                <option value=''>Selecciona una opción...</option>
                <option value='1'>Ingenieria en sistemas computacionales</option>
                <option value='2'>Administracion</option>
                <option value='3'>Informatica</option>
            </select><br>

            <label for="ap_ma">NÚMERO TELEFÓNICO</label>
            <input type="text" id="ap_ma"><br>

            <label for="sexo">SEXO</label>
            <select name="sexo" id="sexo">
                <option value=''>Selecciona una opción...</option>
                <option value='1'>MASCULINO</option>
                <option value='2'>FEMENINO</option>
            </select><br>

            <input type="submit" name="modificar" id="modificar" value="MODIFICAR">
            <input type="submit" name="volver" id="volver" value="VOLVER">



        </form>
    </div>

</body>

</html>


<?php
if (isset($_POST['modificar'])) {
    header("Location: ../ALUMNOS/datos_alumno.php");
}

if (isset($_POST['volver'])) {
    header("Location: ../ALUMNOS/datos_alumno.php");
}
?>