<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicias la sesión PHP
    if (isset($_POST['volver'])) {
        header("Location:alumnos.php");
    }
}

$ingreso = $_SESSION['correo'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIBIRSE</title>
    <link rel="stylesheet" href="estilos/inscribirse.css">

</head>

<body>
    <h1>INSCRIBIRSE</h1>
    <form action="subir.php" method="POST" enctype="multipart/form-data">
        <div class="form_datos">

            <label for="lin_captura">LINEA DE CAPTURA</label>
            <input type="text" name="lin_captura" id="lin_captura" placeholder="XXXXXX(6) XXXXXX XXXXXX XXXXXX XXX" required><br>

            <label for="fe_pago">FECHA DEPAGO</label>
            <input type="date" name="fe_pago" id="fe_pago" required><br>

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
        <h3>DOCUMENTOS EN FORMATO PDF NO MAYOR A 2MB</h3>



        <div class="form_documentos">
            <label class="file-label" for="soli_aspirante" id="file-label">
                <span class="file-label-text">SOLICITUD DE ASPIRANTE</span></label>
            <input class="file-input" type="file" id="soli_aspirante" name="soli_aspirante" required>
            <br>

            <label class="file-label" for="lin_captura_d" id="file-label1">
                <span class="file-label-text">LINEA DE CAPTURA</span></label>
            <input class="file-input" type="file" id="lin_captura_d" name="lin_captura_d" required>
            <br>

            <label class="file-label" for="comp_pago" id="file-label2">
                <span class="file-label-text">COMPROBANTE DE PAGO</span></label>
            <input class="file-input" type="file" id="comp_pago" name="comp_pago" required>
            <br>

            <label class="file-label" for="ine" id="file-label3">
                <span class="file-label-text">INE</span></label>
            <input class="file-input" type="file" id="ine" name="ine" required>
            <br>

            <label class="file-label" for="act_nacimiento" id="file-label4">
                <span class="file-label-text">ACTA DE NACIMIENTO</span></label>
            <input class="file-input" type="file" id="act_nacimiento" name="act_nacimiento" required>
            <br>

            <label class="file-label" for="comp_estudios" id="file-label5">
                <span class="file-label-text">COMRPOBANTE DE ESTUDIOS</span></label>
            <input class="file-input" type="file" id="comp_estudios" name="comp_estudios" required>
            <br><br><br>
        </div>



        <input id="inscribirse" name="inscribirse" type="submit" value="INSCRIBIRSE" required><br>
    </form>
    <form action="" method="post">
        <input type="submit" id="volver" name="volver" value=VOLVER>
    </form>
    <script src="java/inscribirse.js"></script>
</body>

</html>

<?php
//CUANDO SE PULSA EL BOTON INSCRIBIRSE...
if (isset($_POST['inscribirse'])) {
    //DATOS
    $linea_captura = $_POST['lin_captura'];
    $fecha_pago = $_POST['fe_pago'];
    $nivel_cursar = $_POST['nivel'];
    $modalidad = $_POST['modalidad'];
    $horario = $_POST['horario'];
    //DOCUMENTOS
    $soli_aspirante = $_POST['soli_aspirante'];
    $lin_captura_d = $_POST['lin_captura_d'];
    $comp_pago = $_POST['comp_pago'];
    $ine = $_POST['ine'];
    $act_nacimiento = $_POST['act_nacimiento'];
    $comp_estudios = $_POST['comp_estudios'];

    $sql = "select alumnos.id_expediente from alumnos join usuarios on alumnos.id_usuarios=usuarios.id_usuario where usuarios.correo='$ingreso'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $id_expediente = $fila['id_expediente'];
    }

    

}




?>