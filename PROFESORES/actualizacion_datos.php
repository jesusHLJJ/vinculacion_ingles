<?php
include "../BD.php";
session_start();
$correo = $_SESSION['correo'];

// Realizar la consulta para obtener los datos del profesor
$sql_profesor = "SELECT profesores.id_profesor, profesores.nombre, profesores.ap_paterno, profesores.ap_materno, profesores.edad, profesores.id_estado_civil, profesores.sexo, profesores.calle, profesores.numero, profesores.colonia, profesores.codigo_postal, profesores.id_municipio, profesores.estado, profesores.rfc FROM profesores JOIN usuarios ON usuarios.id_usuario = profesores.id_usuario WHERE usuarios.correo = ?";

$stmt_profesor = $conexion->prepare($sql_profesor);
$stmt_profesor->bind_param("s", $correo);
$stmt_profesor->execute();
$result_profesor = $stmt_profesor->get_result();

// Verificar si se encontraron resultados
if ($result_profesor->num_rows > 0) {
    // Obtener los datos del profesor
    $fila_profesor = $result_profesor->fetch_assoc();
    $id_profesor = $fila_profesor["id_profesor"];
    $nombres = $fila_profesor["nombre"];
    $apellido_paterno = $fila_profesor["ap_paterno"];
    $apellido_materno = $fila_profesor["ap_materno"];
    $edad = $fila_profesor["edad"];
    $sexo = $fila_profesor["sexo"];
    $calle = $fila_profesor["calle"];
    $numero = $fila_profesor["numero"];
    $rfc = $fila_profesor["rfc"];
    $estado_civil = $fila_profesor["id_estado_civil"];
    $estado = $fila_profesor["estado"];
    $municipio = $fila_profesor["id_municipio"];
    $colonia = $fila_profesor["colonia"];
    $codigo = $fila_profesor["codigo_postal"];
} else {
    echo "No se encontraron resultados.";
}

// Realizar las consultas para obtener los datos de los municipios, colonias, códigos postales y estados civiles
$sql_municipios = "SELECT * FROM municipios";
$result_municipios = $conexion->query($sql_municipios);

$sql_colonias = "SELECT * FROM colonias";
$result_colonias = $conexion->query($sql_colonias);

$sql_codigos_postales = "SELECT * FROM codigos";
$result_codigos_postales = $conexion->query($sql_codigos_postales);

$sql_estados_civiles = "SELECT * FROM estado_civil";
$result_estados_civiles = $conexion->query($sql_estados_civiles);

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombres = $_POST["nombres"];
    $apellido_paterno = $_POST["apellido_paterno"];
    $apellido_materno = $_POST["apellido_materno"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];
    $calle = $_POST["calle"];
    $numero = $_POST["numero"];
    $rfc = $_POST["rfc"];
    $estado_civil = $_POST["estado_civil"];
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $colonia = $_POST["colonia"];
    $codigo = $_POST["codigo_postal"];

    // Realizar la actualización de los datos
    $sql_actualizar = "UPDATE profesores SET nombre=?, ap_paterno=?, ap_materno=?, edad=?, sexo=?, calle=?, numero=?, rfc=?, id_estado_civil=?, estado=?, id_municipio=?, colonia=?, codigo_postal=? WHERE id_profesor=?";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);
    $stmt_actualizar->bind_param("sssissssisissi", $nombres, $apellido_paterno, $apellido_materno, $edad, $sexo, $calle, $numero, $rfc, $estado_civil, $estado, $municipio, $colonia, $codigo, $id_profesor);
   
    if ($stmt_actualizar->execute()) {
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Los datos se actualizaron correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php'; // Redireccionar a la página deseada después de confirmar
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error al actualizar los datos',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar datos</title>
  <link rel="stylesheet" href="../estilos/style_formulario_profesores.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<h1 class="titulo-bienvenida"><?php echo $nombres . ' ' . $apellido_paterno . ' ' . $apellido_materno; ?></h1>
<div class="boton-regresar">
    <a id="regresar" href="#">Regresar</a>
</div>

<div class="container">
    <div class="formulario">
        <form id="updateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombres">Nombres:</label><br>
            <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>"><br>
            
            <label for="apellido_paterno">Apellido Paterno:</label><br>
            <input type="text" id="apellido_paterno" name="apellido_paterno" value="<?php echo $apellido_paterno; ?>"><br>
            
            <label for="apellido_materno">Apellido Materno:</label><br>
            <input type="text" id="apellido_materno" name="apellido_materno" value="<?php echo $apellido_materno; ?>"><br>
            
            <label for="edad">Edad:</label><br>
            <input type="number" id="edad" name="edad" value="<?php echo $edad; ?>"><br>
            
            <label for="sexo">Sexo:</label><br>
            <select id="sexo" name="sexo">
                <option value="M" <?php if ($sexo == 'M') echo 'selected'; ?>>M</option>
                <option value="F" <?php if ($sexo == 'F') echo 'selected'; ?>>F</option>
            </select><br>
            
            <label for="calle">Calle:</label><br>
            <input type="text" id="calle" name="calle" value="<?php echo $calle; ?>"><br>
            
            <label for="numero">Número:</label><br>
            <input type="text" id="numero" name="numero" value="<?php echo $numero; ?>"><br>
            
            <label for="rfc">RFC:</label><br>
            <input type="text" id="rfc" name="rfc" value="<?php echo $rfc; ?>"><br>
            
            <label for="estado_civil">Estado Civil:</label><br>
            <select id="estado_civil" name="estado_civil">
                <?php
                while ($row = $result_estados_civiles->fetch_assoc()) {
                    $selected = ($estado_civil == $row['estado_civil']) ? 'selected' : '';
                    echo "<option value='" . $row['id_estado_civil'] . "' $selected>" . $row['estado_civil'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <label for="estado">Estado:</label><br>
            <input type="text" id="estado" name="estado" value="<?php echo $estado; ?>"><br><br>
            <label for="municipio">Municipio:</label><br>
            <select id="municipio" name="municipio">
                <?php
                while ($row = $result_municipios->fetch_assoc()) {
                    $selected = ($municipio == $row['nombre_munipio']) ? 'selected' : '';
                    echo "<option value='" . $row['id_municipio'] . "' $selected>" . $row['nombre_munipio'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <label for="colonia">Colonia:</label><br>
            <input type="text" id="colonia" name="colonia" value="<?php echo $colonia; ?>"><br><br>
            
            <label for="codigo_postal">Código Postal:</label><br>
            <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo $codigo; ?>"><br><br>
            
            <input type="submit" value="Modificar" id="cambios">
        </form>
    </div>
</div>

<div class="boton-redondo3">
    <a id="cerrar" href="#">
        <img class="imagen" src="../imagenes/cerrar_sesion_icono.png" alt="Botón Redondo3">
    </a>
</div>
<h2 class="button-description3">Cerrar sesión</h2>

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

document.getElementById("regresar").addEventListener("click", function() {
  Swal.fire({
    title: '¿Deseas regresar al menú principal?',
    text: "Si aplicaste cambios y no guardaste, se perderán",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, regresar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "index.php";
    }
  });
});

document.getElementById("updateForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent the form from submitting immediately
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¿Deseas aplicar los cambios?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, modificar'
  }).then((result) => {
    if (result.isConfirmed) {
      event.target.submit(); // Submit the form if confirmed
    }
  });
});
</script>

</body>
</html>
