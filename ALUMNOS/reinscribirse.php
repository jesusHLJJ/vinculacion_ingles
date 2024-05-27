<?php
session_start();
include "../conn_bd.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['volver'])) {
        header("Location:alumnos.php");
    }
}
$expediente = $_SESSION['id_expediente'];
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
    <form action="" method="POST" enctype="multipart/form-data">
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
                <option value='1'>8:00 a 12:00</option>
                <option value='2'>12:00 a 16:00</option>

            </select><br><br><br>
        </div>
        <h3>DOCUMENTOS EN FORMATO PDF NO MAYOR A 2MB</h3>

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

        <input id="reinscribirse" name="reinscribirse" type="submit" value="REINSCRIBIRSE" required><br>

    </form>
    <form action="" method="post">
        <input type="submit" id="volver" name="volver" value=VOLVER>
    </form>
    <script src="java/reinscribirse.js"></script>
</body>

</html>

<?php
if (isset($_POST['reinscribirse'])) {
    //DATOS
    $linea_captura = $_POST['lin_captura'];
    $fecha_pago = $_POST['fe_pago'];
    $nivel_cursar = $_POST['nivel'];
    $modalidad = $_POST['modalidad'];
    $horario = $_POST['horario'];

    //DOCUMENTOS

    $const_anterior = '';
    $comp_pago =  '';
    $lin_captura_d =  '';

    //COPIAR DOCUMENTOS A LA CARPETA DE USUARIO CORRESPONDIENTE

    $const_anterior = $_FILES['const_anterior']['name'];
    if ($const_anterior != '') {
        $const_anterior_extension = pathinfo($const_anterior, PATHINFO_EXTENSION);
        $const_anterior_tmp = $_FILES['const_anterior']['tmp_name'];
        $const_anterior_route = "archivos/usuario_expediente_" . $expediente . "_reinscripcion/".$nivel_cursar."nivel_const_anterior." . $const_anterior_extension;
        move_uploaded_file($const_anterior_tmp, $const_anterior_route);
    }

    $comp_pago = $_FILES['comp_pago']['name'];
    if ($comp_pago != '') {
        $comp_pago_extension = pathinfo($comp_pago, PATHINFO_EXTENSION);
        $comp_pago_tmp = $_FILES['comp_pago']['tmp_name'];
        $comp_pago_route = "archivos/usuario_expediente_" . $expediente . "_reinscripcion/".$nivel_cursar."nivel_comp_pago." . $comp_pago_extension;
        move_uploaded_file($comp_pago_tmp, $comp_pago_route);
    }

    $lin_captura_d = $_FILES['lin_captura_d']['name'];
    if ($lin_captura_d != '') {
        $lin_captura_d_extension = pathinfo($lin_captura_d, PATHINFO_EXTENSION);
        $lin_captura_d_tmp = $_FILES['lin_captura_d']['tmp_name'];
        $lin_captura_d_route = "archivos/usuario_expediente_" . $expediente . "_reinscripcion/".$nivel_cursar."nivel_lin_captura_d." . $lin_captura_d_extension;
        move_uploaded_file($lin_captura_d_tmp,  $lin_captura_d_route);
    }

    //CONSULTA PARA ALMACENAR LAS RUTAS
    $sql="update alumnos set id_estatus=2 where id_expediente=$expediente";
    $result = $con->query($sql);

    $sql="INSERT INTO documento_expediente (`id_expediente`, `nivel`, `const_na`, `comp_pago`, `lin_captura`, `lin_captura_t`, `fecha_entrega`) VALUES ($expediente, $nivel_cursar, '$const_anterior_route','$comp_pago_route', '$lin_captura_d_route','$linea_captura','$fecha_pago')";
    $result = $con->query($sql);
    if ($result) {
    } else {
        echo "NO se cargaron los archivos correctamente, pero si funciona inscripcion";
    }
}

?>