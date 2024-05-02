<?php
session_start();
include '../conn_bd.php';

$ingreso = $_SESSION['correo'];
$t_carrera = '99';
//CONSULTAS SQL PARA OBTENER LOS DATOS DEL ALUMNO//

//DATOS DEL ALUMNO
$sql = "select * from alumno where correo='$ingreso'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $t_matricula = $fila['matricula'];

    $nombres = $fila['nombres'];
    $t_ap_pa = $fila['apellido_paterno'];
    $t_ap_ma = $fila['apellido_materno'];

    $t_edad = $fila['edad'];
    $t_sexo = $fila['sexo'];
    $telefono = $fila['telefono'];

    $id_carrera = $fila['id_carrera'];
}

if ($nombres == '') {
    $id_carrera = '99';
}



//DATOS DE CARRERA
$sql = "select * from carreras where id_carrera=$id_carrera";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $t_carrera = $fila['carrera'];
}


$nombre = $nombres;
$ap_pa = $t_ap_pa;
$ap_ma = $t_ap_ma;
$sexo = $t_sexo;
$matricula = $t_matricula;
$carrera = $t_carrera;
$correo = $_SESSION['correo'];
$numero_tel = $telefono;
$edad = $t_edad;


if ($nombre == '') {
    $nombres = 'ACTUALIZAR DATOS';
    $t_ap_pa = 'ACTUALIZAR DATOS';
    $t_ap_ma = 'ACTUALIZAR DATOS';
    $t_sexo = 'ACTUALIZAR DATOS';
    $telefono = 'ACTUALIZAR DATOS';
    $t_edad = 'ACTUALIZAR DATOS';
    $id_carrera = '99';
}
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

            <label><span>EDAD:</span> <?php echo $edad ?></label><br>

            <label><span>MATRICULA:</span> <?php echo $matricula ?></label><br>

            <label><span>CARRERA:</span> <?php echo $carrera ?></label><br>

            <label><span>CORREO ELECTRONICO:</span> <?php echo $correo ?></label><br>

            <label><span>NÚMERO TELEFÓNICO:</span> <?php echo $numero_tel ?></label><br>


            <div class="botones">
                <input type="submit" name="modificar" id='modificar' value="MODIFICAR INFORMACIÓN">
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