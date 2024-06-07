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
            $sql = "SELECT * FROM niveles where nivel=$nivel_seleccionado";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_nivel = $row['id_nivel'];
                    $grupo = $row["grupo"];

                    $sql = "select count(*) as total_alumnos,niveles.cupo_max from niveles left join alumnos on alumnos.id_nivel=niveles.id_nivel where niveles.id_nivel=$id_nivel";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $total_alumnos = $row['total_alumnos'];
                            $cupo_max = $row["cupo_max"];

                            if ($total_alumnos == $cupo_max) {
                                echo '<option value="' . $id_nivel . '"disabled>' . $grupo . ' - GRUPO LLENO</option>';
                            } else {
                                echo '<option value="' . $id_nivel . '">' . $grupo . '</option>';
                            }
                        }
                    }
                }
            }
            $stmt->close();
            ?>
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
