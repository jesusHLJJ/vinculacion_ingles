<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicias la sesión PHP
    if (isset($_POST['volver'])) {
        header("Location:alumnos.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REINSCRIBIRSE</title>
    <link rel="stylesheet" href="estilos/reinscribirse.css">
</head>

<body>
    <h1>REINSCRIBIRSE</h1>
    <form action="subir.php" method="POST" enctype="multipart/form-data">
        <div class="form_datos">
            <label for="nombre">NOMBRES(S)</label>
            <input type="text" name="nombre" id="nombre" required><br>


            <label for="nombre">APELLIDO PATERNO</label>
            <input type="text" name="ap_pa" id="nombre" required><br>

            <label for="nombre">APELLIDO MATERNO</label>
            <input type="text" name="ap_ma" id="nombre" required><br>

            <label for="nombre">MATRICULA</label>
            <input type="text" name="matricula" id="nombre" required><br>

            <label for="carrera">CARRERA</label>
            <select name="carrera" id="carrera" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>Ingenieria en sistemas computacionales</option>
                <option value='2'>Administracion</option>
                <option value='3'>Informatica</option>
            </select><br>

            <label for="correo">CORREO ELECTRÓNICO</label>
            <input type="email" name="correo" id="correo" placeholder="ejemplo@gmail.com" required><br>

            <label for="telefono">NÚMERO DE TELEFONO</label>
            <input type="text" name="telefono" id="telefono" required><br>

            <label for="lin_captura">LINEA DE CAPTURA</label>
            <input type="text" name="lin_captura" id="lin_captura" placeholder="XXXXXX(6) XXXXXX XXXXXX XXXXXX XXX" required><br>

            <label for="fe_pago">FECHA DEPAGO</label>
            <input type="date" name="fe_pago" id="fe_pago" required><br>

            <label for="sexo">SEXO</label>
            <select name="sexo" id="sexo" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>MASCULINO</option>
                <option value='2'>FEMENINO</option>
            </select><br>

            <label for="nivel">NIVEL A CURSAR</label>
            <select name="nivel" id="nivel" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>NIVEL 1</option>
                <option value='2'>NIVEL 2</option>
                <option value='3'>NIVEL 3</option>
                <option value='4'>NIVEL 4</option>
                <option value='5'>NIVEL 5</option>
                <option value='6'>NIVEL 6</option>
            </select><br>

            <label for="modalidad">MODALIDAD</label>
            <select name="modalidad" id="modalidad" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>PRESENCIAL</option>
                <option value='2'>LINEA</option>
            </select><br>

            <label for="horario">HORARIO</label>
            <select name="horario" id="horario" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>8:00 a 12:00 hrs</option>
                <option value='2'>13:00 a 16:00 hrs</option>
            </select><br><br><br>
        </div>


        <div class="form_documentos">
            <label class="file-label" for="const_anterior" id="file-label">
                <span class="file-label-text">CONSTANCIA NIVEL ANTERIOR</span></label>
            <input class="file-input" type="file" id="const_anterior" name="const_anterior" required>
            <br>

            <label class="file-label" for="comp_pago" id="file-label1">
                <span class="file-label-text">COMPROBANTE DE PAGO</span> </label>
            <input class="file-input" type="file" id="comp_pago" name="comp_pago" required>
            <br>

            <label class="file-label" for="lin_captura_d" id="file-label2">
                <span class="file-label-text">LINEA DE CAPTURA</span></label>
            <input class="file-input" type="file" id="lin_captura_d" name="lin_captura_d" required>
            <br><br><br>
        </div>

        <input id="reinscribirse" type="submit" value="REINSCRIBIRSE" required><br>

    </form>
    <form action="" method="post">
        <input type="submit" id="volver" name="volver" value=VOLVER>
    </form>
    <script src="java/reinscribirse.js"></script>
</body>

</html>