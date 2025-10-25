<?php
include "../BD.php";
session_start();

if (!isset($_SESSION['tipo'])) {
  header('location: ../');
} else {
  if ($_SESSION['tipo'] != 2) {
    header('location: ../');
  }
}
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

  $stmt_profesor->close();
} else {
  echo "No se encontraron resultados.";
}

// Realizar las consultas para obtener los datos de los municipios, colonias, códigos postales y estados civiles
$sql_municipios = "SELECT * FROM municipios";
$result_municipios = $conexion->query($sql_municipios);

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
  <div id="loader">
    <div class="loader-container">
      <div class="loader-spinner"></div>
      <div class="loader-image">
        <img src="../imagenes/si.jpg" alt="Loading">
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Simular una carga con un timeout (por ejemplo, una consulta a una API)
      setTimeout(function() {
        // Ocultar el cargador
        document.getElementById("loader").style.display = "none";
        // Mostrar el contenido
        document.getElementById("content").style.display = "block";
      }, 400); // Ajusta el tiempo según sea necesario
    });
  </script>




  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <!-- Botón Regresar a la izquierda -->
      <a id="regresar" class="btn btn-outline-warning" href="#">Regresar</a>

      <!-- Título centrado -->
      <h1 class="text-center text-warning flex-grow-1 m-0">
        Actualizar Información
      </h1>

      <!-- Botón de Cerrar sesión a la derecha -->
      <a class="navbar-brand d-flex align-items-center" id="cerrar" href="#">
        <img src="../imagenes/cerrar_sesion_icono.png" alt="" class="rounded-circle me-2" style="width:60px; height:60px;">
        Cerrar sesión
      </a>

    </div>
  </nav>



  <div class="container my-4">
    <div class="form-floating mb-3">
      <form id="updateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $nombres; ?>">
          </div>
          <div class="col-md-4">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="<?php echo $apellido_paterno; ?>">
          </div>
          <div class="col-md-4">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" value="<?php echo $apellido_materno; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-2">
            <label for="edad" class="form-label">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $edad; ?>">
          </div>
          <div class="col-md-2">
            <label for="sexo" class="form-label">Sexo</label>
            <select id="sexo" name="sexo" class="form-select">
              <option value="M" <?php if ($sexo == 'M') echo 'selected'; ?>>M</option>
              <option value="F" <?php if ($sexo == 'F') echo 'selected'; ?>>F</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="rfc" class="form-label">RFC</label>
            <input type="text" class="form-control" id="rfc" name="rfc" value="<?php echo $rfc; ?>">
          </div>
          <div class="col-md-4">
            <label for="estado_civil" class="form-label">Estado Civil</label>
            <select id="estado_civil" name="estado_civil" class="form-select">
              <?php
              while ($row = $result_estados_civiles->fetch_assoc()) {
                $selected = ($estado_civil == $row['id_estado_civil']) ? 'selected' : '';
                echo "<option value='" . $row['id_estado_civil'] . "' $selected>" . $row['estado_civil'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control" id="calle" name="calle" value="<?php echo $calle; ?>">
          </div>
          <div class="col-md-2">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $numero; ?>">
          </div>
          <div class="col-md-4">
            <label for="colonia" class="form-label">Colonia</label>
            <input type="text" class="form-control" id="colonia" name="colonia" value="<?php echo $colonia; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado" name="estado" value="<?php echo $estado; ?>">
          </div>
          <div class="col-md-4">
            <label for="municipio" class="form-label">Municipio</label>
            <select id="municipio" name="municipio" class="form-select">
              <?php
              while ($row = $result_municipios->fetch_assoc()) {
                $selected = ($municipio == $row['id_municipio']) ? 'selected' : '';
                echo "<option value='" . $row['id_municipio'] . "' $selected>" . $row['nombre_municipio'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-4">
            <label for="codigo_postal" class="form-label">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?php echo $codigo; ?>">
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>

      </form>
    </div>
  </div>


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