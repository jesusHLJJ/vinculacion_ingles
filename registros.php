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
  
  <label for="email">Correo Electrónico:</label><br>
  <input type="email" id="email" name="email" required><br>
  
  <label for="contra">Contraseña::</label><br>
  <input type="password" id="contra" name="contra" required><br>
  

  <input type="submit" name="enviar" value="Enviar">
</form>

</body>
</html>

<?php
include "BD.php";

if(isset($_POST['enviar'])){
    $correo = $_POST['email']; 
    $contra = $_POST['contra']; 

    $HASH = password_hash($contra, PASSWORD_DEFAULT);

    $sql = "INSERT INTO login_usuarios (correo, contrasena, id_tipo) VALUES ('$correo','$HASH',2)";
    $result = $conexion->query($sql);
    if ($result === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error al insertar el registro: ";
    }
}

?>
