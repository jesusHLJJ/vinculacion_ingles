<?php include '../BD.php';
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 3) {
        header('location: ../');
    }
}


$nombre_alumno = '';
$ap_alumno = '';
$am_alumno = '';
$nombre_grupo = '';
$numero_nivel = '';
$nombres_profesor = '';
$ap_profesor = '';
$am_profesor = '';
$t_horario = '';
$t_periodo = '';
$nombre_aula = '';
$Bloqueo = '';
$estatus_alumno = '';
$bloqueo_inscripcion = '';
$bloqueo_reinscripcion = '';


$ingreso = $_SESSION['correo']; //correo electrónico que ingresa a la parte ALUMNO

//REALIZAR CONSULTAS SQL PARA RECOLECTAR DATOS //

//DATOS GENERALES
$sql = "select alumnos.matricula, alumnos.nombre,alumnos.ap_paterno,alumnos.ap_materno,usuarios.correo from alumnos join usuarios on alumnos.id_usuarios=usuarios.id_usuario where usuarios.correo='$ingreso'";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $matricula = $fila['matricula'];
    $nombre_alumno = $fila['nombre'];
    $ap_alumno = $fila['ap_paterno'];
    $am_alumno = $fila['ap_materno'];
}

$_SESSION['matricula'] = $matricula;

$sql = "select alumnos.id_expediente, id_estatus from alumnos where alumnos.matricula=$matricula";
$stmt = $conexion->prepare($sql);
//$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $id_expediente = $fila['id_expediente'];
    $estatus_alumno = $fila['id_estatus'];
}
$_SESSION['id_expediente'] = $id_expediente;

$sql = "select niveles.grupo, niveles.nivel,profesores.nombre,profesores.ap_paterno,niveles.horario,periodos.periodo,niveles.aula from alumnos join  niveles on alumnos.id_nivel=niveles.id_nivel join periodos on niveles.id_periodo=periodos.id_periodo join profesores on niveles.id_profesor=profesores.id_profesor join usuarios on alumnos.id_usuarios=usuarios.id_usuario where usuarios.correo='$ingreso'";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $nombre_grupo = $fila['grupo'];
    $numero_nivel = $fila['nivel'];
    $nombres_profesor = $fila['nombre'];
    $ap_profesor = $fila['ap_paterno'];
    $t_horario = $fila['horario'];
    $t_periodo = $fila['periodo'];
    $nombre_aula = $fila['aula'];
}

mysqli_close($conexion);
//CERRAMOS LA CONEXION SQL PARA QUE NO OCUPE ESPACIO EN LA MEMORIA

//header("Location:prestador.php");



//Se van a obtener los datos de las sesiones y de la base de datos
$alumno = $nombre_alumno . ' ' . $ap_alumno . ' ' . $am_alumno;
$grupo = $nombre_grupo;
$nivel = $numero_nivel;
$docente = $nombres_profesor . ' ' . $ap_profesor;
$horario = $t_horario;
$periodo = $t_periodo;
$aula = $nombre_aula;


if ($alumno == "  ") {                          //IF PARA LA PRIMERA VEZ QUE ENTRE EL ALUMNO
    $alumno = "ACTUALIZA TUS DATOS";
    $grupo = "AD";
    $nivel = "AD";
    $docente = "AD";
    $horario = "AD";
    $periodo = "AD";
    $aula = "AD";
    $Bloqueo = "Disabled";
} else {
    if ($estatus_alumno == '') {
        $Bloqueo = "";
        $bloqueo_reinscripcion = "disabled";
        $bloqueo_inscripcion="";
    } 
    if ($estatus_alumno >= 1) {
        $Bloqueo = "";
        $bloqueo_inscripcion = "disabled";
        $bloqueo_reinscripcion = "";
    }
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
            <input type='submit' name="actas" value="CONSTANCIAS DE LIBERACION" <?php echo $Bloqueo; ?>>
            <input type='submit' name="inscribirse" value="INSCRIBIRSE" <?php echo $Bloqueo . $bloqueo_inscripcion; ?>>
            <input type='submit' name="reinscribirse" value="REINSCRIBIRSE" <?php echo $Bloqueo . $bloqueo_reinscripcion; ?>>
            <input type='submit' name="datos_alumno" value="VER MIS DATOS">
            <input type='submit' name="calif_alumno" value="VER MIS CALIFICACIONES" <?php echo $Bloqueo; ?>>
            <input type='button' id="cerrar" name="cerrar" value="CERRAR SESION">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/sweetAlert.js"></script>
    <script>
        document.getElementById("cerrar").addEventListener("click", function() {
            Swal.fire({
                title: '¿Deseas cerrar sesión?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cerrar sesión'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../CONTROLADORES/cerrar_sesion.php";
                }
            });
        });
    </script>

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
/*
if (isset($_POST['cerrar'])) {
    header("Location: ../index.php");
    session_destroy();
}
*/
if (isset($_POST['datos_alumno'])) {
    header("Location: ../ALUMNOS/datos_alumno.php");
}

if (isset($_POST['calif_alumno'])) {
    header("Location: ../ALUMNOS/calif_alumno.php");
}


?>