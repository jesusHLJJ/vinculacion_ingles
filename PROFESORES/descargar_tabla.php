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
$sql = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, carreras.nombre_carrera, alumnos.telefono 
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

  <!-- Agrega la referencia a jsPDF aquí -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="../estilos/style_info_profesor.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  
</head>
<body>
    <header>
        <h1>Descargar</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="submit" name="cerrar_sesion" value="Cerrar Sesión">
        </form>
    </header>

    <div class="table-container">
        <div class="table-scroll">
            <table id="miTabla" class="table">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Carrera</th>
                        <th>Teléfono</th>
                        <th>Parcial 1</th>
                        <th>Parcial 2</th>
                        <th>Parcial 3</th>
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
                            $sql_verificar_notas = "SELECT * FROM notas WHERE matricula = ?";
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

    <button onclick="generarPDF()">Descargar PDF</button>
    <button onclick="exportToExcel()">Exportar a Excel</button>

    <script>
        function generarPDF() {
            const doc = new jsPDF();
            doc.autoTable({ html: '#miTabla' });
            doc.save('tabla_alumnos.pdf');
        }

        function exportToExcel() {
  // Obtener la tabla HTML
  var table = document.getElementById('miTabla');

  // Crear un nuevo libro de Excel
  var wb = XLSX.utils.table_to_book(table);

  // Guardar el libro como archivo Excel
  XLSX.writeFile(wb, 'tabla.xlsx');
}

    </script>
</body>

</html>
