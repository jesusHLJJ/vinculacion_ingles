<?php
session_start();
include '../conn_bd.php';

$ingreso = $_SESSION['correo'];
$t_carrera = '99';
$t_nombre='';
$t_ap_paterno='';
$t_ap_materno='';
$t_sexo='';
$t_matricula='';
$nombre_carrera='';
$telefono='';
$t_edad='';

//CONSULTAS SQL PARA OBTENER LOS DATOS DEL ALUMNO//

//DATOS DEL ALUMNO
$sql="select alumnos.nombre,alumnos.ap_paterno,alumnos.ap_materno,alumnos.sexo,alumnos.matricula,carreras.nombre_carrera,alumnos.telefono,alumnos.edad from alumnos join carreras on alumnos.id_carrera=carreras.id_carrera join usuarios on alumnos.id_usuarios = usuarios.id_usuario where usuarios.correo='$ingreso'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $t_nombre = $fila['nombre'];

    $t_ap_paterno = $fila['ap_paterno'];
    $t_ap_materno = $fila['ap_materno'];
    $t_sexo = $fila['sexo'];

    $t_matricula = $fila['matricula'];
    $nombre_carrera = $fila['nombre_carrera'];
    $telefono = $fila['telefono'];

    $t_edad = $fila['edad'];
}



$nombre = $t_nombre;
$ap_pa = $t_ap_paterno;
$ap_ma = $t_ap_materno;
$sexo = $t_sexo;
$matricula = $t_matricula;
$carrera = $nombre_carrera;
$correo = $_SESSION['correo'];
$numero_tel = $telefono;
$edad = $t_edad;

if ($nombre == '') {
    $nombre = 'ACTUALIZAR DATOS';
    $ap_pa = 'ACTUALIZAR DATOS';
    $ap_ma = 'ACTUALIZAR DATOS';
    $sexo = 'ACTUALIZAR DATOS';
    $matricula = 'ACTUALIZAR DATOS';
    $carrera = 'ACTUALIZAR DATOS';
    $numero_tel = 'ACTUALIZAR DATOS';
    $edad = 'ACTUALIZAR DATOS';
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

            <label><span>CORREO ELECTRONICO:</span> <?php echo $_SESSION['correo']; ?></label><br>

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