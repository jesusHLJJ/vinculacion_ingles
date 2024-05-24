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


    $conexion = mysqli_connect('localhost', 'root', '', 'vinculacion_ingles');
        if (!$conexion){
            echo('Conexion fallida');
        }else{
            
        }

if(isset($_POST['enviar'])){
    $correo = $_POST['correo']; 
    $contrasena = $_POST['contrasena'];
    $matricula =$_POST['matricula'];

    $HASH = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql="INSERT INTO `usuarios` (`correo`, `contrasena`, `id_tipo`) VALUES ('$correo', '$HASH', 2)";
    echo $sql;
    $result = $conexion->query($sql);
    if ($result === TRUE) {
      $sql="INSERT INTO `profesores` ('nombre', `id_usuarios`) VALUES ($matricula, 0)";
      echo $sql;
      $result = $conexion->query($sql);
      if ($result === TRUE) {
          header('Location: index.php');
      } else {
          echo "Error al insertar el registro: ";
      }
    } else {
        echo "No se inserto nada: ";
    }

}
?>


