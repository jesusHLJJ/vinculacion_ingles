<?php
// Incluir el archivo de conexión a la base de datos
include "../BD.php";

// Iniciar la sesión
session_start();

// Cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    // Eliminar todas las variables de sesión
    session_unset();
    // Destruir la sesión
    session_destroy();
    // Redireccionar al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}

$id_nivel = $_SESSION['id_nivel'];
// Realizar la consulta SQL para obtener los datos de los alumnos
$sql = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, carreras.nombre_carrera, alumnos.telefono,alumnos.id_nota 
FROM alumnos join carreras on alumnos.id_carrera = carreras.id_carrera where alumnos.id_nivel = $id_nivel";
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    // Si hay un error en la consulta, mostrar el mensaje de error y terminar el script
    echo "Error en la consulta: " . mysqli_error($conexion);
    exit();
}

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultado) > 0) {
    // Array para almacenar los datos de los alumnos
    $alumnos = array();

    // Recorrer los resultados y guardarlos en el array de alumnos
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $alumnos[] = $fila;
    }
} else {
    $alumnos = array(); // Si no hay resultados, inicializar el array de alumnos como vacío
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabla de Alumnos</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="../estilos/style_info_profesor.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
  <header>
    <div class="logo">Alumnos</div>
    <div class="bars">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <nav class="nav-bar">
      <ul>
        <li>
          <a id="regresar" href="#" class="active2">Inicio</a>
        </li>
        <li>
            <a id="regresar2" href="#">Regresar</a>
        </li>
        <li>
          <a href="#" onclick="generarPDF()">Descargar PDF</a>
        </li>
        <li>
          <a href="#" onclick="exportToExcel()">Exportar a Excel</a>
        </li>
        <li>
          <a id="cerrar" href="#" class="active">Cerrar sesión</a>
        </li>
      </ul>
    </nav>
  </header>
  <div class="table-container">
    <div class="table-scroll">
      <table id="miTabla" class="table">
        <thead>
          <tr>
              <th>MATRICULA</th>
              <th>NOMBRE</th>
              <th>APELLIDO PATERNO</th>
              <th>APELLIDO MATERNO</th>
              <th>CARRERA</th>
              <th>TELEFONO</th>
              <th>PARCIAL 1</th>
              <th>PARCIAL 2</th>
              <th>PARCIAL 3</th>
              
          </tr>
        </thead>
        <tbody>
          <?php foreach ($alumnos as $alumno) : ?>
            <tr>
              <td><?php echo $alumno['matricula']; ?></td>
              <td><?php echo $alumno['nombre']; ?></td>
              <td><?php echo $alumno['ap_paterno']; ?></td>
              <td><?php echo $alumno['ap_materno']; ?></td>
              <td><?php echo $alumno['nombre_carrera']; ?></td>
              <td><?php echo $alumno['telefono']; ?></td>
              <?php
              // Obtener las notas del alumno actual
              $sql_verificar_notas = "SELECT * FROM notas join alumnos on notas.id_nota=alumnos.id_nota WHERE alumnos.matricula =?";
              $stmt_verificar_notas = $conexion->prepare($sql_verificar_notas);
              $stmt_verificar_notas->bind_param("s", $alumno['matricula']);
              $stmt_verificar_notas->execute();
              $result_verificar_notas = $stmt_verificar_notas->get_result();

              // Definir las variables de notas con valores vacíos por defecto
              $parcial1 = "";
              $parcial2 = "";
              $parcial3 = "";

              // Si existen notas para el alumno, obtener los valores de parciales
              if ($result_verificar_notas->num_rows > 0) {
                $row_notas = $result_verificar_notas->fetch_assoc();
                $parcial1 = $row_notas['nota_parcial1'];
                $parcial2 = $row_notas['nota_parcial2'];
                $parcial3 = $row_notas['nota_parcial3'];
              }
              ?>
              <td><?php echo htmlspecialchars($parcial1); ?></td>
              <td><?php echo htmlspecialchars($parcial2); ?></td>
              <td><?php echo htmlspecialchars($parcial3); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function generarPDF() {
      const doc = new jsPDF();
      doc.autoTable({ html: '#miTabla' });
      doc.save('tabla_alumnos.pdf');
    }

    function exportToExcel() {
      var table = document.getElementById('miTabla');
      var wb = XLSX.utils.table_to_book(table);
      XLSX.writeFile(wb, 'tabla.xlsx');
    }

    document.getElementById("cerrar").addEventListener("click", function() {
      swal({
        title: '¿Deseas cerrar sesión?',
        text: "Esta acción cerrará tu sesión actual.",
        icon: 'warning',
        buttons: {
          confirm: {
            text: 'Sí, cerrar sesión',
            value: true,
            visible: true,
            className: 'swal-button--confirm',
            closeModal: true
          },
          cancel: {
            text: 'Cancelar',
            visible: true,
            className: 'swal-button--cancel',
            closeModal: true,
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = "../CONTROLADORES/cerrar_sesion.php";
        }
      });
    });

    document.getElementById("regresar").addEventListener("click", function() {
      swal({
        title: '¿Deseas regresar al menú principal?',
        text: "Si aplicaste cambios y no guardaste, se perderán",
        icon: 'warning',
        buttons: {
          confirm: {
            text: 'Sí, regresar',
            value: true,
            visible: true,
            className: 'swal-button--confirm',
            closeModal: true
          },
          cancel: {
            text: 'Cancelar',
            visible: true,
            className: 'swal-button--cancel',
            closeModal: true,
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = "index.php";
        }
      });
    });

    document.getElementById("regresar2").addEventListener("click", function() {
      swal({
        title: '¿Deseas regresar al menú principal?',
        text: "Si aplicaste cambios y no guardaste, se perderán",
        icon: 'warning',
        buttons: {
          confirm: {
            text: 'Sí, regresar',
            value: true,
            visible: true,
            className: 'swal-button--confirm',
            closeModal: true
          },
          cancel: {
            text: 'Cancelar',
            visible: true,
            className: 'swal-button--cancel',
            closeModal: true,
          }
        }
      }).then((confirm) => {
        if (confirm) {
          window.location.href = "descarga_documento/info_grupo.php";
        }
      });
    });
  </script>
</body>
</html>