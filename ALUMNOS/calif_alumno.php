<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 2) {
        header('location: ../');
    }
}
include "../BD.php";
$primer_parcial = '';
$segundo_parcial = '';
$tercer_parcial = '';



$matricula = $_SESSION['matricula'];

if (isset($_POST['volver'])) {
    header("Location:alumnos.php");
}

// OBTENEMOS LAS CALIFICACIONES DEL ALUMNO
$sql = "select notas.nota_parcial1,notas.nota_parcial2,notas.nota_parcial3,niveles.nivel,profesores.nombre,profesores.ap_paterno,profesores.ap_materno from notas join alumnos on notas.id_nota=alumnos.id_nota join niveles on alumnos.id_nivel=niveles.id_nivel join profesores on niveles.id_profesor=profesores.id_profesor where alumnos.matricula=$matricula";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $primer_parcial_s = $fila['nota_parcial1'];
    $segundo_parcial_s = $fila['nota_parcial2'];
    $tercer_parcial_s = $fila['nota_parcial3'];
    $nivel = $fila['nivel'];
    $nombre = $fila['nombre'];
    $ap_paterno = $fila['ap_paterno'];
    $ap_materno = $fila['ap_materno'];
}else{
    echo "No perteneces a algun grupo";
    die();
}
//NOMBRE COMPLETO DEL PROFE
$nombre_profesor = $nombre . " " . $ap_paterno . " " . $ap_materno;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALIFICACIONES DE ALUMNO</title>
    <link rel="stylesheet" href="estilos/calif_alumno.css">
</head>

<body>
    <div class="table">
        <table border="1" class="tabla-calificaciones">
            <tr>
                <th colspan="2" class="encabezado">INFO GRUPO</th>
                <th colspan="4" class="encabezado">PARCIAL</th>
            </tr>
            <tr>
                <th class="titulo">NIVEL</th>
                <th class="titulo">PROFESOR</th>
                <th class="titulo">PRIMERO</th>
                <th class="titulo">SEGUNDO</th>
                <th class="titulo">TERCERO</th>
                <th class="titulo">TOTAL</th>
            </tr>
            <tr>
                <td><?php echo $nivel; ?></td>
                <td><?php echo $nombre_profesor; ?></td>
                <td><?php echo $primer_parcial_s; ?></td>
                <td><?php echo $segundo_parcial_s; ?></td>
                <td><?php echo $tercer_parcial_s; ?></td>
                <?php
                $primer_parcial = (int)$primer_parcial_s;
                $segundo_parcial = (int)$segundo_parcial_s;
                $tercer_parcial = (int)$tercer_parcial_s;

                $total = round((($primer_parcial + $segundo_parcial + $tercer_parcial) / 3), 2);
                ?>
                <td><?php echo $total; ?></td>
            </tr>
        </table>
        <br>
        <form action="" method="post">
            <input type="submit" value="VOLVER" name="volver" id="volver">
        </form>

    </div>


</body>

</html>