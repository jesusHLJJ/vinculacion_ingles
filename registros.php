<?php
session_start();

if (isset($_SESSION['tipo'])) {
    switch ($_SESSION['tipo']) {
        case 1: // Tutor
            header('location: ADMINISTRADOR/');
            break;
            case 2: // Administrador
                header('location: PROFESORES/');
            break;
        case 3: // Alumno

            header('location: ALUMNOS/alumnos.php');
            break;
        default:
    }
}
?>

<?php
if (isset($_POST['volver'])) {
  header("Location:index.php");
}
include "../vinculacion_ingles-main/conn_bd.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <link rel="stylesheet" href="estilos/registros.css">
</head>

<body>

  <h2>REGISTRO</h2>

  <form action="" method="POST" class="formulario">

    <label for="correo">CORREO ELECTRÓNICO:</label><br>
    <input type="email" id="correo" name="correo" required><br>

    <label for="contrasena">CONTRASEÑA:</label><br>
    <input type="password" id="contrasena" name="contrasena" required><br>

    <label for="matricula">MATRÍCULA:</label><br>
    <input type="text" id="matricula" name="matricula" required><br>

    <input type="submit" name="enviar" value="REGISTRARSE" class="boton">

  </form>
  <form action="" method="post" class="formulario">
    <input type="submit" name="volver" value="VOLVER" class="boton" id="volver">
  </form>
</body>

</html>


<?php


    $conexion = mysqli_connect('localhost', 'root', '', 'vinculacion_ingles');
        if (!$conexion){
            echo('Conexion fallida');
        }else{
            
        }

if (isset($_POST['enviar'])) {
  $correo = $_POST['correo'];
  $contrasena = $_POST['contrasena'];
  $matricula = $_POST['matricula'];

  $HASH = password_hash($contrasena, PASSWORD_DEFAULT);
  $sql = "INSERT INTO `usuarios` (`correo`, `contrasena`, `id_tipo`) VALUES ('$correo', '$HASH', 3)";
  $result = $con->query($sql);



  if ($result === TRUE) {

    //ULTIMO ID DE LA TABLA USUARIOS
    $sql = "select MAX(id_usuario) as 'ultimo_id' from usuarios";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    //Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
      // Obtener el nombre de la fila
      $fila = $result->fetch_assoc();
      $ultimo_id_usuario = $fila['ultimo_id'];
    }

    $sql = "SELECT MAX(id_expediente) as 'ultimo_id' FROM expediente";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $fila = $result->fetch_assoc();
      $ultimo_id = $fila['ultimo_id'];
    }
    $ultimo_id = $ultimo_id + 1;

    $sql = "SELECT MAX(id_nota) as 'ultimo_id' FROM notas";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $fila = $result->fetch_assoc();
      $ultimo_id_notas = $fila['ultimo_id'];
    }
    $ultimo_id_notas = $ultimo_id_notas + 1;

    $sql="INSERT INTO `notas` (`id_nota`, `nota_parcial1`, `nota_parcial2`, `nota_parcial3`, `id_nivel`) VALUES (NULL, NULL, NULL, NULL, NULL)";
    $result = $con->query($sql);
    $sql = "INSERT INTO `expediente` (`id_expediente`, `nivel`, `lin_captura`, `soli_aspirante`, `act_nac`, `comp_estu`, `ine`, `comp_pago`, `lin_captura_t`, `fecha_pago`, `modalidad`, `horario`) VALUES ($ultimo_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
    $result = $con->query($sql);
    $sql = "INSERT INTO `alumnos` (`matricula`, `nombre`, `ap_paterno`, `ap_materno`, `edad`, `id_carrera`, `telefono`, `sexo`, `id_nivel`, `id_estatus`, `id_usuarios`, `id_expediente`, `id_nota`) VALUES ($matricula, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $ultimo_id_usuario, $ultimo_id, $ultimo_id_notas)";
    $result = $con->query($sql);




    if ($result === TRUE) {
      //CREACION DE LAS CARPETAS DE USUARIO 
      $nombre_carpeta = "usuario_expediente_" . $ultimo_id;
      $directorio = "ALUMNOS/archivos/";
      $ruta_carpeta = $directorio . $nombre_carpeta;
      mkdir($ruta_carpeta, 0755);

      $nombre_carpeta = "usuario_expediente_" . $ultimo_id . "_reinscripcion";
      $directorio = "ALUMNOS/archivos/";
      $ruta_carpeta = $directorio . $nombre_carpeta;
      mkdir($ruta_carpeta, 0755);

      header('Location: index.php');
    } else {
      echo "Error al insertar el registro: ";
    }
  } else {
    echo "No se inserto nada: ";
  }
}
?>