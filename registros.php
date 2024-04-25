<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
</head>
<body>

<h2>Formulario</h2>

<form action="" method="POST">
  
  <label for="correo">CORREO ELECTRÓNICO:</label><br>
  <input type="email" id="correo" name="correo" required><br>
  
  <label for="contra">CONTRASEÑA:</label><br>
  <input type="password" id="contrasena" name="contrasena" required><br>

  <label for="contra">MATRICULA:</label><br>
  <input type="text" id="matricula" name="matricula" required><br>
  

  <input type="submit" name="enviar" value="Enviar">
</form>

</body>
</html>

<?php
include "conn_bd.php";

if(isset($_POST['enviar'])){
    $correo = $_POST['correo']; 
    $contrasena = $_POST['contrasena'];
    $matricula =$_POST['matricula'];

    $HASH = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login_usuarios (correo, contrasena, id_tipo) VALUES ('$correo','$HASH',3)";
    $result = $con->query($sql);
    if ($result === TRUE) {
      $sql = "INSERT INTO `alumno` (`matricula`, `nombres`, `apellido_paterno`, `apellido_materno`, `edad`, `sexo`, `correo`, `telefono`, `id_carrera`, `id_grupo`, `turno`, `linea_captura`) VALUES ('$matricula', NULL, NULL, NULL, NULL, NULL,'$correo', NULL, NULL, NULL, NULL, NULL)";
      echo $sql;
      $result = $con->query($sql);
      if ($result === TRUE) {
          header('Location: index.php');
      } else {
          echo "Error al insertar el registro: ";
      }
    } else {
        echo "Error al insertar el registro: ";
    }

}
?>


