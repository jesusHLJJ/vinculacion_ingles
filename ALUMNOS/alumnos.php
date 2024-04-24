<?php include '../conn_bd.php';
session_start();

$id_profesor='';
$id_periodo='';
$nombre_grupo='';
$numero_nivel='';
$nombres_pro='';
$ap_pa_pro='';
$ap_ma_pro='';
$t_horario='';
$t_periodo='';
$nombre_aula='';


$ingreso = $_SESSION['correo']; //correo electrónico que ingresa a la parte ALUMNO

//REALIZAR CONSULTAS SQL PARA RECOLECTAR DATOS //

//DATOS DEL ALUMNO
$sql = "select * from alumno where correo='$ingreso'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $matricula= $fila['matricula'];

    $nombres= $fila['nombres'];
    $ap_pa =$fila['apellido_paterno'];
    $ap_ma =$fila['apellido_materno'];

    $edad=$fila['edad'];
    $sexo=$fila['sexo'];
    $telefono=$fila['telefono'];

    $id_carrera=$fila['id_carrera'];
    $id_grupo=$fila['id_grupo'];

    $turno=$fila['turno'];

    $linea_daptura=$fila['linea_captura'];
} 

//DATOS DEL GRUPO
$sql = "select * from grupos where id_grupo='$id_grupo'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $nombre_grupo= $fila['nombre_grupo'];
    $id_profesor =$fila['id_profesor'];
    $numero_nivel =$fila['nivel'];
    $t_horario=$fila['horario'];
    $id_periodo=$fila['id_periodo'];
    $nombre_aula=$fila['aula'];
} 

//DATOS DEL PROFESOR
$sql = "select * from profesores where id_profesor='$id_profesor'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $nombres_pro= $fila['nombres'];
    $ap_pa_pro =$fila['apellido_paterno'];
    $ap_ma_pro =$fila['apellido_materno'];
} 

//DATOS DEL PERIODO
$sql = "select * from periodos where id_periodo='$id_periodo'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $t_periodo= $fila['periodo'];
} 










mysqli_close($con); //CERRAMOS LA CONEXION SQL PARA QUE NO OCUPE ESPACIO EN LA MEMORIA

//header("Location:prestador.php");



//Se van a obtener los datos de las sesiones y de la base de datos
$alumno = $nombres . ' ' . $ap_pa . ' ' . $ap_ma; 
$grupo = $nombre_grupo;
$nivel = $numero_nivel;
$docente = $nombres_pro . ' ' . $ap_pa_pro . ' ' . $ap_ma_pro; ;
$horario = $t_horario;
$periodo = $t_periodo;
$aula = $nombre_aula;


if($alumno=='   '){                          //IF PARA LA PRIMERA VEZ QUE ENTRE EL ALUMNO
    $alumno="ACTUALIZA TUS DATOS";
    $grupo="AD";
    $nivel="AD";
    $docente="AD";
    $horario="AD";
    $periodo="AD";
    $aula="AD";
}
//_________________________________________________________________

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNOS</title>
    <link rel="stylesheet" href="estilos/alumnos.css">
</head>

<body>

    <h1><?php echo $alumno; ?></h1>
    <div class="contenedor_botones">
        <form action='' method="POST">
            <input type='submit' name="actas" value="VER ACTAS/CALIFICACIONES">
            <input type='submit' name="inscribirse" value="INSCRIBIRSE">
            <input type='submit' name="reinscribirse" value="REINSCRIBIRSE">
            <input type='submit' name="datos_alumno" value="VER MIS DATOS">
            <input type='submit' id="cerrar" name="cerrar" value="CERRAR SESION">
        </form>
    </div>
    <div class="tabla_contenido">
        <table border="1">
            <tr>
                <th>GRUPO</th>
                <th>NIVEL</th>
                <th>DOCENTE</th>
                <th>HORARIO</th>
                <th>PERIODO</th>
                <th>AULA</th>
            </tr>
            <tr>
                <td><?php echo $grupo; ?></td>
                <td><?php echo $nivel; ?></td>
                <td><?php echo $docente; ?></td>
                <td><?php echo $horario; ?></td>
                <td><?php echo $periodo; ?></td>
                <td><?php echo $aula; ?></td>
            </tr>
        </table>
    </div>
</body>

</html>


<?php
//Logica de los botones - Lo que pasa al pulsarlo
if (isset($_POST['actas'])) {
    header("Location: ../ALUMNOS/actas.php");
}

if (isset($_POST['inscribirse'])) {
    header("Location: ../ALUMNOS/inscribirse.php");
}

if (isset($_POST['reinscribirse'])) {
    header("Location: ../ALUMNOS/reinscribirse.php");
}

if (isset($_POST['cerrar'])) {
    header("Location: ../index.php");
    session_destroy();
}

if (isset($_POST['datos_alumno'])) {
    header("Location: ../ALUMNOS/datos_alumno.php");
}


?>