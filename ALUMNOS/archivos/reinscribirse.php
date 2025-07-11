<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 3) {
        header('location: ../');
    }
}
include "../../BD.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['volver'])) {
        header("Location:../alumnos.php");
    }
}
$expediente = $_SESSION['id_expediente'];
?>




<?php
if (isset($_POST['reinscribirse'])) {
    //DATOS
    $linea_captura = $_POST['lin_captura'];
    $fecha_pago = $_POST['fe_pago'];
    $fecha_entrega = $_POST['fe_entrega'];
    $nivel_cursar = $_POST['nivel'];
    $linea_repetida = '';

    //COMPROBAR SI LA LINEA DE CAPTURA NO ESTA REPETIDA
    $sql = "Select expediente.lin_captura_t from expediente where expediente.lin_captura_t='$linea_captura'";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $linea_repetida = $fila['lin_captura_t'];
    }


    //DOCUMENTOS

    $const_anterior = '';
    $comp_pago =  '';
    $lin_captura_d =  '';

    if ($linea_repetida == '') {

        //COPIAR DOCUMENTOS A LA CARPETA DE USUARIO CORRESPONDIENTE

        $const_anterior = $_FILES['const_anterior']['name'];
        if ($const_anterior != '') {
            $const_anterior_extension = pathinfo($const_anterior, PATHINFO_EXTENSION);
            $const_anterior_tmp = $_FILES['const_anterior']['tmp_name'];
            $const_anterior_route = "../../EXPEDIENTE_ALUMNO/archivos/usuario_expediente_" . $expediente . "/nivel_" . $nivel_cursar . "_nivel_const_anterior." . $const_anterior_extension;
            move_uploaded_file($const_anterior_tmp, $const_anterior_route);
        }

        $comp_pago = $_FILES['comp_pago']['name'];
        if ($comp_pago != '') {
            $comp_pago_extension = pathinfo($comp_pago, PATHINFO_EXTENSION);
            $comp_pago_tmp = $_FILES['comp_pago']['tmp_name'];
            $comp_pago_route = "../../EXPEDIENTE_ALUMNO/archivos/usuario_expediente_" . $expediente . "/nivel_" . $nivel_cursar . "_nivel_comp_pago." . $comp_pago_extension;
            move_uploaded_file($comp_pago_tmp, $comp_pago_route);
        }

        $lin_captura_d = $_FILES['lin_captura_d']['name'];
        if ($lin_captura_d != '') {
            $lin_captura_d_extension = pathinfo($lin_captura_d, PATHINFO_EXTENSION);
            $lin_captura_d_tmp = $_FILES['lin_captura_d']['tmp_name'];
            $lin_captura_d_route = "../../EXPEDIENTE_ALUMNO/archivos/usuario_expediente_" . $expediente . "/nivel_" . $nivel_cursar . "_nivel_lin_captura_d." . $lin_captura_d_extension;
            move_uploaded_file($lin_captura_d_tmp,  $lin_captura_d_route);
        }

        //CONSULTA PARA ALMACENAR LAS RUTAS
        $sql = "update alumnos set id_estatus=2 where id_expediente=$expediente";
        $result = $conexion->query($sql);

        //$sql="update expediente set fecha_pago='$fecha_pago',fecha_entrega='$fecha_entrega',lin_captura_t='$linea_captura' where id_expediente=$expediente";
        //$result = $conexion->query($sql);

        $sql = "update expediente set lin_captura_t='$linea_captura',fecha_pago='$fecha_pago',fecha_entrega='$fecha_entrega'";
        $result = $conexion->query($sql);

        $sql = "INSERT INTO documento_expediente (`id_expediente`, `nivel`, `const_na`, `comp_pago`, `lin_captura`) VALUES ($expediente, $nivel_cursar, '$const_anterior_route','$comp_pago_route', '$lin_captura_d_route')";
        $result = $conexion->query($sql);
        mysqli_close($conexion);
        if ($result) {
            header("Location:../elegir_grupo.php?nivel=$nivel_cursar&expediente=$expediente&modo=2");
        }
    } else {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'LINEA DE CAPTURA REPETIDA',
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#ffbb00'
            }).then(() => {
                window.location.href = '../alumnos.php';
            });
        });
    </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REINSCRIBIRSE</title>
    <link rel="stylesheet" href="../estilos/reinscribirse.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <h1>REINSCRIBIRSE</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form_datos">

            <script>
                function formatInput(event) {
                    let input = event.target;
                    let value = input.value.replace(/\s+/g, ''); // Elimina todos los espacios
                    let formattedValue = '';

                    for (let i = 0; i < value.length; i += 6) {
                        if (i > 0) {
                            formattedValue += ' ';
                        }
                        formattedValue += value.substring(i, i + 6);
                    }

                    input.value = formattedValue;
                }
            </script>


            <label for="lin_captura">LINEA DE CAPTURA</label>
            <input type="text" name="lin_captura" id="lin_captura" placeholder="XXXXXX(6) XXXXXX XXXXXX XXXXXX XXX" maxlength="31" oninput="formatInput(event)" pattern="[0-9\s]+" title="SOLO SE ADMITEN NÚMEROS" required><br>

            <label for="fe_pago">FECHA DE PAGO</label>
            <input type="date" name="fe_pago" id="fe_pago" required><br>

            <label for="fe_entrega">FECHA ENTREGA</label>
            <input type="date" name="fe_entrega" id="fe_entrega" required><br>


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
<!--
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

            </select><br><br><br>-->
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
    <script src="../java/reinscribirse.js"></script>
</body>

</html>

