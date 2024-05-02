<?php
include "../BD.php";
session_start();
$correo = $_SESSION['correo'];

// Realizar la consulta para obtener los datos del profesor
$sql_profesor = "SELECT id_profesor, nombres, apellido_paterno, apellido_materno, edad, sexo, calle, id_estado, id_municipio, id_colonia, id_codigo, rfc, modalidad, turno, id_estado_civil FROM profesores WHERE correo = ?";
$stmt_profesor = $conexion->prepare($sql_profesor);
$stmt_profesor->bind_param("s", $correo);
$stmt_profesor->execute();
$result_profesor = $stmt_profesor->get_result();

// Verificar si se encontraron resultados
if ($result_profesor->num_rows > 0) {
    // Obtener los datos del profesor
    $fila_profesor = $result_profesor->fetch_assoc();
    $id_profesor = $fila_profesor["id_profesor"];
    $nombres = $fila_profesor["nombres"];
    $apellido_paterno = $fila_profesor["apellido_paterno"];
    $apellido_materno = $fila_profesor["apellido_materno"];
    $edad = $fila_profesor["edad"];
    $sexo = $fila_profesor["sexo"];
    $calle = $fila_profesor["calle"];
    $id_estado = $fila_profesor["id_estado"];
    $id_municipio = $fila_profesor["id_municipio"];
    $id_colonia = $fila_profesor["id_colonia"];
    $id_codigo = $fila_profesor["id_codigo"];
    $rfc = $fila_profesor["rfc"];
    $modalidad = $fila_profesor["modalidad"];
    $turno = $fila_profesor["turno"];
    $id_estado_civil = $fila_profesor["id_estado_civil"];
} else {
    echo "No se encontraron resultados.";
}

// Realizar la consulta para obtener los estados
$sql_estados = "SELECT * FROM estados";
$result_estados = $conexion->query($sql_estados);

// Realizar la consulta para obtener los municipios
$sql_municipios = "SELECT * FROM municipios";
$result_municipios = $conexion->query($sql_municipios);

// Realizar la consulta para obtener las colonias
$sql_colonias = "SELECT * FROM colonias";
$result_colonias = $conexion->query($sql_colonias);

// Realizar la consulta para obtener los códigos postales
$sql_codigos_postales = "SELECT * FROM codigos";
$result_codigos_postales = $conexion->query($sql_codigos_postales);

// Realizar la consulta para obtener los estados civiles
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
    $id_estado = $_POST["estado"];
    $id_municipio = $_POST["municipio"];
    $id_colonia = $_POST["colonia"];
    $id_codigo = $_POST["codigo_postal"];
    $rfc = $_POST["rfc"];
    $id_estado_civil = $_POST["estado_civil"];

    // Realizar la actualización de los datos
    $sql_actualizar = "UPDATE profesores SET nombres = ?, apellido_paterno = ?, apellido_materno = ?, edad = ?, sexo = ?, calle = ?, id_estado = ?, id_municipio = ?, id_colonia = ?, id_codigo = ?, rfc = ?, id_estado_civil = ? WHERE correo = ?";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);

    $stmt_actualizar->bind_param("sssissiiiisss", $nombres, $apellido_paterno, $apellido_materno, $edad, $sexo, $calle, $id_estado, $id_municipio, $id_colonia, $id_codigo, $rfc, $id_estado_civil, $correo);
   
    $stmt_actualizar->execute();


    if ($stmt_actualizar->affected_rows > 0) {
        echo "<script>alert('Los datos se actualizaron correctamente');</script>";
    } else {
        echo "<script>alert('Hubo un error al actualizar los datos');</script>";
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<h1 class="titulo-bienvenida">Bienvenido(a): <?php echo $nombres . ' ' . $apellido_paterno . ' ' . $apellido_materno; ?></h1>
<div class="boton-regresar">
    <a href="index.php" onclick="return confirm('¿Seguro que deseas retroceder?')">Regresar</a>
</div>
<div class="container">
    <div class="formulario">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
            
            <label for="rfc">RFC:</label><br>
            <input type="text" id="rfc" name="rfc" value="<?php echo $rfc; ?>"><br>
            
            <label for="estado_civil">Estado Civil:</label><br>
            <select id="estado_civil" name="estado_civil">
                <?php
                while ($row = $result_estados_civiles->fetch_assoc()) {
                    $selected = ($id_estado_civil == $row['id_estado_civil']) ? 'selected' : '';
                    echo "<option value='" . $row['id_estado_civil'] . "' $selected>" . $row['estado_civil'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <label for="estado">Estado:</label><br>
            <select id="estado" name="estado">
                <?php
                while ($row = $result_estados->fetch_assoc()) {
                    $selected = ($id_estado == $row['id_estado']) ? 'selected' : '';
                    echo "<option value='" . $row['id_estado'] . "' $selected>" . $row['estado'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <label for="municipio">Municipio:</label><br>
            <select id="municipio" name="municipio">
                <?php
                while ($row = $result_municipios->fetch_assoc()) {
                    $selected = ($id_municipio == $row['id_municipio']) ? 'selected' : '';
                    echo "<option value='" . $row['id_municipio'] . "' $selected>" . $row['municipio'] . "</option>";
                }
                ?>
            </select><br><br>
            <label for="colonia">Colonia:</label><br>
            <select id="colonia" name="colonia">
                <?php
                while ($row = $result_colonias->fetch_assoc()) {
                    $selected = ($id_colonia == $row['id_colonia']) ? 'selected' : '';
                    echo "<option value='" . $row['id_colonia'] . "' $selected>" . $row['colonia'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <label for="codigo_postal">Código Postal:</label><br>
            <select id="codigo_postal" name="codigo_postal">
                <?php
                while ($row = $result_codigos_postales->fetch_assoc()) {
                    $selected = ($id_codigo == $row['id_codigo']) ? 'selected' : '';
                    echo "<option value='" . $row['id_codigo'] . "' $selected>" . $row['codigo'] . "</option>";
                }
                ?>
            </select><br><br>
            
            <input type="submit" value="Modificar"> 
        </div>
    </div>
        </form>
    
</div>
<div class="boton-redondo3">
    <a id="cerrar" href="#">
        <img class="imagen" src="../imagenes/cerrar_sesion_icono.png" alt="Botón Redondo3">
    </a>
</div>
<h2 class="button-description3">Cerrar sesión</h2>


<script>
document.getElementById("cerrar").addEventListener("click", function() {
  // Mostrar una alerta con SweetAlert
  Swal.fire({
    title: '¿Deseas cerrar sesión?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, cerrar sesión'
  }).then((result) => {
    if (result.isConfirmed) {
      // Si el usuario confirma, redirecciona a la otra página
      window.location.href = "../CONTROLADORES/cerrar_sesion.php";
    }
  });
});
</script>
</body>
</html>