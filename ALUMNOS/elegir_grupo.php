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

$nivel_seleccionado = $_GET['nivel'];
$expediente = $_GET['expediente'];
$modo = $_GET['modo'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPO</title>
    <link rel="stylesheet" href="estilos/elegir_grupo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="" method="post">
        <label for="label">A QUE GRUPO TE QUIERES INSCRIBIR/REINSCRIBIR</label>

        <label for="grup_disponible"><span>GRUPOS DISPONIBLES</span></label><br>
        <select name="grup_disponible" id="grup_disponible" required>
            <option value=''>Explorar grupos...</option>
            <?php
            // Primera consulta para obtener todos los niveles junto con los profesores
            $sql = "SELECT niveles.id_nivel, niveles.nivel, niveles.grupo, niveles.modalidad, niveles.horario, profesores.nombre 
        FROM niveles 
        JOIN profesores ON niveles.id_profesor = profesores.id_profesor 
        WHERE niveles.nivel = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param('i', $nivel_seleccionado);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_nivel = $row['id_nivel'];
                    $nivel = $row['nivel'];
                    $grupo = $row['grupo'];
                    $modalidad = $row['modalidad'];
                    $horario = $row['horario'];
                    $profesor = $row['nombre'];

                    // Segunda consulta para contar alumnos y obtener el cupo máximo para cada nivel
                    $sql_alumnos = "SELECT COUNT(*) AS total_alumnos, niveles.cupo_max 
                        FROM niveles 
                        LEFT JOIN alumnos ON alumnos.id_nivel = niveles.id_nivel 
                        WHERE niveles.id_nivel = ?";
                    $stmt_alumnos = $conexion->prepare($sql_alumnos);
                    $stmt_alumnos->bind_param('i', $id_nivel);
                    $stmt_alumnos->execute();
                    $result_alumnos = $stmt_alumnos->get_result();

                    if ($result_alumnos->num_rows > 0) {
                        $row_alumnos = $result_alumnos->fetch_assoc();
                        $total_alumnos = $row_alumnos['total_alumnos'];
                        $cupo_max = $row_alumnos['cupo_max'];

                        if ($total_alumnos == $cupo_max) {
                            echo '<option value="' . $id_nivel . '" disabled>NIVEL: ' . $nivel . ' /-/ GRUPO: ' . $grupo . ' /-/ MODALIDAD: ' . $modalidad . ' /-/ HORARIO: ' . $horario . ' /-/ PROFESOR(@): ' . $profesor . ' <-----> GRUPO LLENO</option>';
                        } else {
                            echo '<option value="' . $id_nivel . '">NIVEL: ' . $nivel . ' /-/ GRUPO: ' . $grupo . ' /-/ MODALIDAD: ' . $modalidad . ' /-/ HORARIO: ' . $horario . ' /-/ PROFESOR(@): ' . $profesor . ' /-/ ALUMNOS: ' . $total_alumnos . '/' . $cupo_max . '</option>';
                        }
                    }
                    $stmt_alumnos->close();
                }
            } else {
                echo "</select>";
                if ($modo == 1) {
                    $sql = "update alumnos join expediente on alumnos.id_expediente=expediente.id_expediente set alumnos.id_estatus=null,expediente.lin_captura_t='' where alumnos.id_expediente=$expediente";
                    $result = $conexion->query($sql);
                    $sql = "update expediente set expediente.lin_captura_t='' where id_expediente=$expediente";
                } elseif ($modo == 2) {
                    $sql = "update alumnos join expediente on alumnos.id_expediente=expediente.id_expediente set alumnos.id_estatus=1,expediente.lin_captura_t='' where alumnos.id_expediente=$expediente";
                    $result = $conexion->query($sql);
                }

                echo "<script>var fileExists = false;</script>";
            }





            $stmt->close();
            ?>
            <script>
                if (typeof fileExists !== 'undefined' && !fileExists) {
                    Swal.fire({
                        title: 'LO SENTIMOS, NO HAY GRUPOS DISPONIBLES PARA \n NIVEL: <?php echo $nivel_seleccionado ?>',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#ffbb00'
                    }).then(() => {
                        window.location.href = '../ALUMNOS/alumnos.php';
                    });
                }
            </script>
        </select><br>

        <input type="submit" name="enviar" value="ELEGIR GRUPO">
    </form>

    <?php
    if (isset($_POST['enviar'])) {
        $nivel_elegido = $_POST['grup_disponible'];
        $sql = "update alumnos set id_nivel=$nivel_elegido where id_expediente=$expediente";
        $result = $conexion->query($sql);

        if ($result) {
            echo "<script>
                    Swal.fire({
                        title: 'Proceso realizado con éxito',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '../ALUMNOS/alumnos.php';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        title: 'Error en el proceso',
                        text: 'Hubo un problema al actualizar la información. Por favor, inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                  </script>";
        }
    }
    ?>
</body>

</html>