<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 3) {
        header('location: ../');
    }
}
include "../BD.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['volver'])) {
        header("Location:alumnos.php");
    }
}

$ingreso = $_SESSION['correo'];
$expediente = $_SESSION['id_expediente'];
$matricula = $_SESSION['matricula'];

//SACAR EL CUPO DEL GRUPO DEL ALUMNO
$sql = "select niveles.cupo_max from niveles";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $cupo_max = $fila['cupo_max'];
}

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
                <option value='presencial'>PRESENCIAL</option>
                <option value='linea'>LINEA</option>
            </select><br>

            <label for="horario">HORARIO</label>
            <select name="horario" id="horario" required>
                <option value=''>Selecciona una opción...</option>
                <option value='1'>8:00 a 12:00</option>
                <option value='2'>12:00 a 16:00</option>
                <option value='3'></option>

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

    $soli_aspirante = '';
    $act_nacimiento =  '';
    $comp_estudios =  '';
    $ine =  '';
    $comp_pago =  '';
    $lin_captura_d =  '';






    //COPIAR DOCUMENTOS A LA CARPETA DE USUARIO CORRESPONDIENTE

    $soli_aspirante = $_FILES['soli_aspirante']['name'];
    if ($soli_aspirante != '') {
        $soli_aspirante_extension = pathinfo($soli_aspirante, PATHINFO_EXTENSION);
        $soli_aspirante_tmp = $_FILES['soli_aspirante']['tmp_name'];
        $soli_aspirante_route = "archivos/usuario_expediente_" . $expediente . "/soli_aspirante." . $soli_aspirante_extension;
        move_uploaded_file($soli_aspirante_tmp, $soli_aspirante_route);
    }

    $act_nacimiento = $_FILES['act_nacimiento']['name'];
    if ($act_nacimiento != '') {
        $act_nacimiento_extension = pathinfo($act_nacimiento, PATHINFO_EXTENSION);
        $act_nacimiento_tmp = $_FILES['act_nacimiento']['tmp_name'];
        $act_nacimiento_route = "archivos/usuario_expediente_" . $expediente . "/act_nacimiento." . $act_nacimiento_extension;
        move_uploaded_file($act_nacimiento_tmp, $act_nacimiento_route);
    }

    $comp_estudios = $_FILES['comp_estudios']['name'];
    if ($comp_estudios != '') {
        $comp_estudios_extension = pathinfo($comp_estudios, PATHINFO_EXTENSION);
        $comp_estudios_tmp = $_FILES['comp_estudios']['tmp_name'];
        $comp_estudios_route = "archivos/usuario_expediente_" . $expediente . "/comp_estudios." . $comp_estudios_extension;
        move_uploaded_file($comp_estudios_tmp,  $comp_estudios_route);
    }

    $ine = $_FILES['ine']['name'];
    if ($ine != '') {
        $ine_extension = pathinfo($ine, PATHINFO_EXTENSION);
        $ine_tmp = $_FILES['ine']['tmp_name'];
        $ine_route = "archivos/usuario_expediente_" . $expediente . "/ine." . $ine_extension;
        move_uploaded_file($ine_tmp,  $ine_route);
    }

    $comp_pago = $_FILES['comp_pago']['name'];
    if ($comp_pago != '') {
        $comp_pago_extension = pathinfo($comp_pago, PATHINFO_EXTENSION);
        $comp_pago_tmp = $_FILES['comp_pago']['tmp_name'];
        $comp_pago_route = "archivos/usuario_expediente_" . $expediente . "/comp_pago." . $comp_pago_extension;
        move_uploaded_file($comp_pago_tmp,  $comp_pago_route);
    }

    $lin_captura_d = $_FILES['lin_captura_d']['name'];
    if ($lin_captura_d != '') {
        $lin_captura_d_extension = pathinfo($lin_captura_d, PATHINFO_EXTENSION);
        $lin_captura_d_tmp = $_FILES['lin_captura_d']['tmp_name'];
        $lin_captura_d_route = "archivos/usuario_expediente_" . $expediente . "/lin_captura_d." . $lin_captura_d_extension;
        move_uploaded_file($lin_captura_d_tmp,  $lin_captura_d_route);
    }









    //CONSULTA PARA ALMACENAR LAS RUTAS
    $sql = "update alumnos set id_estatus=1 where id_expediente=$expediente";
    $result = $conexion->query($sql);
    $sql = "update expediente set nivel=$nivel_cursar, lin_captura='$lin_captura_d_route',soli_aspirante='$soli_aspirante_route',act_nac='$act_nacimiento_route',comp_estu='$comp_estudios_route',ine='$ine_route',comp_pago='$comp_pago_route',lin_captura_t='$linea_captura',fecha_pago='$fecha_pago',modalidad='$modalidad',horario='$horario' where id_expediente=$expediente";
    $result = $conexion->query($sql);
    if ($result) {
        header("Location:elegir_grupo.php?nivel=$nivel_cursar&expediente=$expediente");
    } else {
        echo "NO se cargaron los archivos correctamente";
    }
}




?>