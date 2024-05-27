  <?php
  include "../BD.php";

  session_start();

  // Inicializar la variable de mensaje
  $mensaje = "";
  $id_carrera = '';
  // Si se ha enviado el formulario (se ha presionado el botón "Guardar")
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $matricula = isset($_POST["matricula"]) ? $_POST["matricula"] : '';
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $ap_paterno = isset($_POST["ap_paterno"]) ? $_POST["ap_paterno"] : '';
    $ap_materno = isset($_POST["ap_materno"]) ? $_POST["ap_materno"] : '';
    $id_carrera = isset($_POST["id_carrera"]) ? $_POST["id_carrera"] : '';
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : '';


    $nota_parcial1 = isset($_POST["parcial1"]) ? $_POST["parcial1"] : '';
    $nota_parcial2 = isset($_POST["parcial2"]) ? $_POST["parcial2"] : '';
    $nota_parcial3 = isset($_POST["parcial3"]) ? $_POST["parcial3"] : '';
    $id_nivel = $_SESSION['id_nivel'];
    // Actualizar los datos en la base de datos


    //falta cambiar lo de las carreras volverlos listas y agregar el id
    $sql_actualizar = "UPDATE alumnos SET nombre=?, ap_paterno=?, ap_materno=?, id_carrera=?, telefono=? WHERE matricula=?";
    //$sql_actualizar = "UPDATE alumnos SET nombre=?, ap_paterno=?, ap_materno=?, id_carrera=?, telefono=? WHERE matricula=?";
    $stmt_actualizar = $conexion->prepare($sql_actualizar);
    $stmt_actualizar->bind_param("sssiss", $nombre, $ap_paterno, $ap_materno, $id_carrera, $telefono, $matricula);

    if ($stmt_actualizar->execute()) {
      $mensaje = "Los datos se actualizaron correctamente.";
    } else {
      var_dump($stmt_actualizar);
      $mensaje = "Hubo un error al actualizar los datos.";
    }

    //nuevo
    if ($stmt_actualizar->execute()) {
      // Verificar si ya existen notas para el alumno
      $sql_verificar_notas = "SELECT * FROM notas WHERE matricula = ?";
      $stmt_verificar_notas = $conexion->prepare($sql_verificar_notas);
      $stmt_verificar_notas->bind_param("s", $matricula);
      $stmt_verificar_notas->execute();
      $result_verificar_notas = $stmt_verificar_notas->get_result();

      if ($result_verificar_notas->num_rows > 0) {
        // Actualizar las notas existentes
        $sql_actualizar_notas = "UPDATE notas SET nota_parcial1=?, nota_parcial2=?, nota_parcial3=? WHERE matricula=?";
        $stmt_actualizar_notas = $conexion->prepare($sql_actualizar_notas);
        $stmt_actualizar_notas->bind_param("ssss", $nota_parcial1, $nota_parcial2, $nota_parcial3, $matricula);
      } else {
        // Insertar nuevas notas
        $sql_insertar_notas = "INSERT INTO notas (matricula, nota_parcial1, nota_parcial2, nota_parcial3, id_nivel) VALUES (?, ?, ?, ?, ?)";
        $stmt_insertar_notas = $conexion->prepare($sql_insertar_notas);
        $stmt_insertar_notas->bind_param("siiii", $matricula, $nota_parcial1, $nota_parcial2, $nota_parcial3, $id_nivel);
      }

      if (($result_verificar_notas->num_rows > 0 && $stmt_actualizar_notas->execute()) || $stmt_insertar_notas->execute()) {
        $mensaje = "Los datos y las notas se actualizaron correctamente.";
      } else {
        $mensaje = "Hubo un error al actualizar las notas.";
      }
    } else {
      $mensaje = "Hubo un error al actualizar los datos.";
    }
  }
  $id_nivel = $_SESSION['id_nivel'];
  $grupo = $_SESSION['grupo'];
  $modalidad = $_SESSION['modalidad'];
  $horario = $_SESSION['horario'];

  // Verificar si se ha enviado un término de búsqueda
  if (isset($_GET["search"]) && !empty($_GET["search"])) {
    // Sanitizar y obtener el término de búsqueda
    $search = mysqli_real_escape_string($conexion, $_GET["search"]);

    // Realizar la consulta SQL para buscar coincidencias en el nombre
    $sql_buscar = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, carreras.nombre_carrera, alumnos.telefono FROM alumnos JOIN carreras on carreras.id_carrera = alumnos.id_carrera WHERE (nombre LIKE '%$search%' OR ap_paterno LIKE '%$search%' OR ap_materno LIKE '%$search%') AND id_nivel = ?";
    $sql_buscar = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, alumnos.id_carrera, carreras.nombre_carrera, alumnos.telefono FROM alumnos JOIN carreras on carreras.id_carrera = alumnos.id_carrera JOIN niveles on alumnos.id_nivel = niveles.id_nivel JOIN notas on alumnos.id_nota = notas.id_nota WHERE (nombre LIKE '%$search%' OR ap_paterno LIKE '%$search%' OR ap_materno LIKE '%$search%' or  notas.nota_parcial1 LIKE '%$search%' OR  notas.nota_parcial2 LIKE'%$search%' or  notas.nota_parcial3 LIKE '%$search%') AND niveles.id_nivel = ?";

    $stmt_buscar = $conexion->prepare($sql_buscar);
    $stmt_buscar->bind_param("i", $id_nivel);
    $stmt_buscar->execute();
    $result_alumnos = $stmt_buscar->get_result();
  } else {
    // Si no se envió un término de búsqueda, mostrar todos los registros
    $sql_alumnos = "SELECT alumnos.matricula, alumnos.nombre, alumnos.ap_paterno, alumnos.ap_materno, carreras.id_carrera,carreras.nombre_carrera, telefono FROM alumnos JOIN carreras on carreras.id_carrera = alumnos.id_carrera WHERE id_nivel = ?";
    $stmt_alumnos = $conexion->prepare($sql_alumnos);
    $stmt_alumnos->bind_param("i", $id_nivel); // "i" indica que se espera un valor entero para id_nivel
    $stmt_alumnos->execute();
    $result_alumnos = $stmt_alumnos->get_result();
  }
  if (isset($_FILES['archivo2'])) {
    // Obtener el nombre del profesor y sus apellidos de las variables de sesión
    $nombre_profesor = isset($_SESSION['nombre_profesor']) ? $_SESSION['nombre_profesor'] : '';
    $ap_paterno = isset($_SESSION['ap_1']) ? $_SESSION['ap_1'] : '';
    $ap_materno = isset($_SESSION['ap_2']) ? $_SESSION['ap_2'] : '';
    $id_nivel = $_SESSION['id_nivel']; 

    // Combinar el nombre y los apellidos para formar el nombre completo
    $nombre_completo = $nombre_profesor . "_" . $ap_paterno . "_" . $ap_materno;

    // Crear la ruta de la carpeta
    $carpeta = "../DOCUMENTOS_PROFESOR/" . $nombre_completo;

    // Verificar si la carpeta ya existe, si no, crearla
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    // Obtener el nombre del archivo subido
    $nombre_archivo = basename($_FILES["archivo2"]["name"]);

    // Construir la ruta completa del archivo
    $ruta_completa = $carpeta . '/' . $nombre_archivo;

    // Verificar si ya existe un documento para este nivel
    $sql_verificacion = "SELECT COUNT(*) as count FROM documentos_profesor WHERE id_nivel = ?";
    $stmt_verificacion = $conexion->prepare($sql_verificacion);
    $stmt_verificacion->bind_param("i", $id_nivel);
    $stmt_verificacion->execute();
    $result_verificacion = $stmt_verificacion->get_result();
    $row_verificacion = $result_verificacion->fetch_assoc();
    $num_documentos = $row_verificacion['count'];
    echo $num_documentos; 
    if ($num_documentos > 0) {
        // Si ya existe un documento para este nivel, actualiza en lugar de insertar
        $sql = "UPDATE documentos_profesor SET avance_profesor = ? WHERE id_nivel = ?";
    } else {
        // Si no existe un documento para este nivel, inserta uno nuevo
        $sql = "INSERT INTO documentos_profesor (avance_profesor, id_nivel) VALUES (?, ?)";
    }

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $ruta_completa, $id_nivel);

    if (move_uploaded_file($_FILES['archivo2']['tmp_name'], $ruta_completa)) {
      // Ejecutar la consulta SQL
      if ($stmt->execute()) {
        $mensaje = "Éxito al subir y registrar el archivo.";
      } else {
        $mensaje = "Error al registrar el archivo en la base de datos.";
        $tipo_mensaje = "error";
      }
    } else {
      // Si hubo un error al mover el archivo, mostrar un mensaje de error
      $mensaje = "Error al mover el archivo subido.";
      $tipo_mensaje = "error";
    }
}


if (isset($_FILES['archivoCalificaciones'])) {

  // Obtener el nombre del profesor y sus apellidos de las variables de sesión
  $nombre_profesor = isset($_SESSION['nombre_profesor']) ? $_SESSION['nombre_profesor'] : '';
  $ap_paterno = isset($_SESSION['ap_1']) ? $_SESSION['ap_1'] : '';
  $ap_materno = isset($_SESSION['ap_2']) ? $_SESSION['ap_2'] : '';
  $id_nivel = $_SESSION['id_nivel']; 

  // Combinar el nombre y los apellidos para formar el nombre completo
  $nombre_completo = $nombre_profesor . "_" . $ap_paterno . "_" . $ap_materno;

  // Crear la ruta de la carpeta
  $carpeta = "../DOCUMENTOS_PROFESOR/" . $nombre_completo;

  // Verificar si la carpeta ya existe, si no, crearla
  if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
  }

  $nombre_archivo = basename($_FILES["archivoCalificaciones"]["name"]);
  $ruta_completa = $carpeta . '/' . $nombre_archivo;

  if (move_uploaded_file($_FILES['archivoCalificaciones']['tmp_name'], $ruta_completa)) {
      // Verificar si ya existe un documento para este nivel
      $sql_verificacion = "SELECT COUNT(*) as count FROM documentos_nivel WHERE id_nivel = ?";
      $stmt_verificacion = $conexion->prepare($sql_verificacion);
      $stmt_verificacion->bind_param("i", $id_nivel);
      $stmt_verificacion->execute();
      $result_verificacion = $stmt_verificacion->get_result();
      $row_verificacion = $result_verificacion->fetch_assoc();
      $num_documentos = $row_verificacion['count'];

      if ($num_documentos > 0) {
          // Si ya existe un documento para este nivel, actualiza en lugar de insertar
          $sql = "UPDATE documentos_nivel SET acta_calificacion = ? WHERE id_nivel = ?";
      } else {
          // Si no existe un documento para este nivel, inserta uno nuevo
          $sql = "INSERT INTO documentos_nivel (acta_calificacion, id_nivel) VALUES (?, ?)";
      }

      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("si", $ruta_completa, $id_nivel);

      if ($stmt->execute()) {
          $mensaje = "Éxito al subir y registrar el archivo de calificaciones.";
      } else {
          $mensaje = "Error al registrar el archivo de calificaciones en la base de datos.";
          $tipo_mensaje = "error";
      }
  } else {
      $mensaje = "Error al mover el archivo de calificaciones subido.";
      $tipo_mensaje = "error";
  }
}


  if (isset($_FILES['archivoPlaneacion'])) {

    // Obtener el nombre del profesor y sus apellidos de las variables de sesión
    $nombre_profesor = isset($_SESSION['nombre_profesor']) ? $_SESSION['nombre_profesor'] : '';
    $ap_paterno = isset($_SESSION['ap_1']) ? $_SESSION['ap_1'] : '';
    $ap_materno = isset($_SESSION['ap_2']) ? $_SESSION['ap_2'] : '';
    $id_nivel = $_SESSION['id_nivel']; 

    // Combinar el nombre y los apellidos para formar el nombre completo
    $nombre_completo = $nombre_profesor . "_" . $ap_paterno . "_" . $ap_materno;

    // Crear la ruta de la carpeta
    $carpeta = "../DOCUMENTOS_PROFESOR/" . $nombre_completo;

    // Verificar si la carpeta ya existe, si no, crearla
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }

    $nombre_archivo = basename($_FILES["archivoPlaneacion"]["name"]);
    $ruta_completa = $carpeta . '/' . $nombre_archivo;

    // Verificar si el documento ya existe para este nivel
    $sql_verificacion = "SELECT COUNT(*) as count FROM documentos_profesor WHERE id_nivel = ?";
    $stmt_verificacion = $conexion->prepare($sql_verificacion);
    $stmt_verificacion->bind_param("i", $id_nivel);
    $stmt_verificacion->execute();
    $result_verificacion = $stmt_verificacion->get_result();
    $row_verificacion = $result_verificacion->fetch_assoc();
    $num_documentos = $row_verificacion['count'];

    if ($num_documentos > 0) {
        // Si ya existe un documento para este nivel, actualiza en lugar de insertar
        $sql = "UPDATE documentos_profesor SET plan_profesor = ? WHERE id_nivel = ?";
    } else {
        // Si no existe un documento para este nivel, inserta uno nuevo
        $sql = "INSERT INTO documentos_profesor (plan_profesor, id_nivel) VALUES (?, ?)";
    }

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $ruta_completa, $id_nivel);

    if ($stmt->execute()) {
        $mensaje = "Éxito al subir y registrar el archivo de planeación.";
    } else {
        $mensaje = "Error al registrar el archivo de planeación en la base de datos.";
        $tipo_mensaje = "error";
    }
}
  
  ?>

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Alumnos</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="../estilos/style_info_profesor.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  </head>

  <body>

    <?php if (!empty($mensaje)) : ?>
      <script>
        swal({
          text: "<?php echo $mensaje; ?>",
          icon: "success"
        });
      </script>
    <?php endif; ?>

    <div class="container">
      <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="formBuscar">
        <input type="text" name="search" id="inputBuscar" class="si" placeholder="Buscar">
        <button type="submit" class="btn1" id="btnBuscar"><i class="fa fa-search"></i></button>
      </form>
    </div>

    <div class="info-container">
      <!-- Información del grupo, modalidad y horario -->
      <h2 class="grupo">Grupo: <?php echo $grupo; ?></h2>
      <h2 class="modalidad">Modalidad: <?php echo $modalidad; ?></h2>
      <h2 class="horario">Horario: <?php echo $horario; ?></h2>
    </div>

    <button id="mostrarTodos" class="btn2">Todos</button>
    <header>
      <div class="logo">ALUMNOS</div>
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
            <a href="#" id="openModalCalificaciones">Subir actas</a>

            <div id="modalCalificaciones" class="modal">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Subir calificaciones</h2>
                  <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                  <form method="POST" enctype="multipart/form-data" id="uploadCalificacionesForm">
                    <input type="file" name="archivoCalificaciones" id="archivoCalificaciones">
                    <label for="archivoCalificaciones">Cargar archivo de calificaciones</label>
                    <button class="custom-button" type="submit"><i class="fas fa-upload"></i></button>
                  </form>
                </div>
              </div>
            </div>
          </li>
          <li>
            <a href="descargar_avance.php?id_nivel=<?php echo $id_nivel; ?>">Descargar avance programatico</a>
          </li>
          <li>
            <a href="descargar_plan.php?id_nivel=<?php echo $id_nivel; ?>">Descargar planeación</a>
          </li>
          <li>
            <a href="#" id="openModalPlaneacion">Subir planeación</a>

            <div id="modalPlaneacion" class="modal">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Subir planeación</h2>
                  <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                  <form method="POST" enctype="multipart/form-data" id="uploadPlaneacionForm">
                    <input type="file" name="archivoPlaneacion" id="archivoPlaneacion">
                    <label for="archivoPlaneacion">Cargar archivo de planeación</label>
                    <button class="custom-button" type="submit"><i class="fas fa-upload"></i></button>
                  </form>
                </div>
              </div>
            </div>

          </li>
          <li>
            <a href="#" id="openModalBtn">Subir avance programático</a>
            <div id="modal" class="modal">
              <div class="modal-content">
                <div class="modal-header">
                  <h2>Subir avance programático</h2>
                  <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                  <!-- Formulario de carga de archivos -->
                  <form method="POST" enctype="multipart/form-data" id="uploadForm">
                    <input type="file" name="archivo2" id="archivo2">
                    <label for="archivo2">Cargar archivo</label>
                    <button class="custom-button" type="submit"><i class="fas fa-upload"></i></button>
                  </form>
                </div>
              </div>
            </div>
          </li>
          <li>
            <a href="descargar_tabla.php">Generar</a>
          </li>
          <li>
            <a id="cerrar" href="#" class="active">Cerrar sesion</a>
          </li>
        </ul>
      </nav>

    </header>
    <script>
      bars = document.querySelector(".bars");
      bars.onclick = function() {
        navBar = document.querySelector(".nav-bar");
        navBar.classList.toggle("active")

      }
    </script>
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
              <th>ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result_alumnos->fetch_assoc()) : ?>
              <tr>
                <form method="post">
                  <td><?php echo $row['matricula']; ?></td>
                  <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                  <td><input type="text" name="ap_paterno" value="<?php echo $row['ap_paterno']; ?>"></td>
                  <td><input type="text" name="ap_materno" value="<?php echo $row['ap_materno']; ?>"></td>
                  <td>
                    <select name="id_carrera" class="styled-select">
                      <option value="1" <?php echo $row['id_carrera'] == 1 ? 'selected' : ''; ?>>INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
                      <option value="2" <?php echo $row['id_carrera'] == 2 ? 'selected' : ''; ?>>INGENIERIA ELECTRONICA</option>
                      <option value="3" <?php echo $row['id_carrera'] == 3 ? 'selected' : ''; ?>>INGENIERIA AMBIENTAL</option>
                      <option value="4" <?php echo $row['id_carrera'] == 4 ? 'selected' : ''; ?>>INGENIERIA BIOMEDICA</option>
                      <option value="5" <?php echo $row['id_carrera'] == 5 ? 'selected' : ''; ?>>INGENIERIA INFORMATICA</option>
                      <option value="6" <?php echo $row['id_carrera'] == 6 ? 'selected' : ''; ?>>LICENCIATURA EN ADMINISTRACION</option>
                      <option value="7" <?php echo $row['id_carrera'] == 7 ? 'selected' : ''; ?>>ARQUITECTURA</option>
                    </select>
                  </td>

                  <td><input type="text" name="telefono" value="<?php echo $row['telefono']; ?>"></td>
                  <?php
                  // Aquí debes definir $parcial1, $parcial2 y $parcial3 con valores vacíos por defecto

                  // Obtener las notas del alumno actual
                  $sql_verificar_notas = "SELECT * FROM notas WHERE matricula = ?";
                  $stmt_verificar_notas = $conexion->prepare($sql_verificar_notas);
                  $stmt_verificar_notas->bind_param("s", $row['matricula']);
                  $stmt_verificar_notas->execute();
                  $result_verificar_notas = $stmt_verificar_notas->get_result();

                  // Si existen notas para el alumno, obtener los valores de parciales
                  if ($result_verificar_notas->num_rows > 0) {
                    $row_notas = $result_verificar_notas->fetch_assoc();
                    $parcial1 = $row_notas['nota_parcial1'];
                    $parcial2 = $row_notas['nota_parcial2'];
                    $parcial3 = $row_notas['nota_parcial3'];
                  }
                  ?>

                  <td><input type="text" name="parcial1" value="<?php echo htmlspecialchars($parcial1); ?>"></td>
                  <td><input type="text" name="parcial2" value="<?php echo htmlspecialchars($parcial2); ?>"></td>
                  <td><input type="text" name="parcial3" value="<?php echo htmlspecialchars($parcial3); ?>"></td>

                  <td><input type="hidden" name="matricula" value="<?php echo $row['matricula']; ?>"><input type="submit" class="btn" value="Guardar"></td>
                </form>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
    <script>
      document.getElementById("cerrar").addEventListener("click", function() {
        // Mostrar una alerta con SweetAlert
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
            // Si el usuario confirma, redirecciona a la otra página
            window.location.href = "../CONTROLADORES/cerrar_sesion.php";
          }
        });
      });

      document.getElementById("regresar").addEventListener("click", function() {
        // Mostrar una alerta con SweetAlert
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
            // Si el usuario confirma, redirecciona a la otra página
            window.location.href = "index.php";
          }
        });
      });
    </script>

    <script>
      const formBuscar = document.getElementById('formBuscar');

      // Agregar un evento de escucha para el envío del formulario
      formBuscar.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener el término de búsqueda del campo de entrada
        const searchTerm = document.getElementById('inputBuscar').value;

        // Redirigir a la misma página con el término de búsqueda como parámetro GET
        window.location.href = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' + '?search=' + encodeURIComponent(searchTerm);
      });

      document.getElementById("mostrarTodos").addEventListener("click", function() {
        // Redireccionar a la misma página sin ningún parámetro de búsqueda
        window.location.href = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>';
      });
    </script>

    <script>
      // Obtener elementos del DOM
      var modal = document.getElementById("modal");
      var openModalBtn = document.getElementById("openModalBtn");
      var closeBtn = document.querySelector("#modal .close");

      // Función para abrir la ventana modal
      openModalBtn.onclick = function() {
        modal.style.display = "block";
      }

      // Función para cerrar la ventana modal
      closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
      });


      document.getElementById("openModalPlaneacion").addEventListener("click", function() {
        document.getElementById("modalPlaneacion").style.display = "block";
      });

      // Cerrar modal de subir planeación al hacer clic en el botón de cerrar
      document.querySelector("#modalPlaneacion .close").addEventListener("click", function() {
        document.getElementById("modalPlaneacion").style.display = "none";
      });

      // Cerrar la ventana modal si el usuario hace clic fuera de ella
      window.onclick = function(event) {
        var modalPlaneacion = document.getElementById("modalPlaneacion");
        if (event.target == modalPlaneacion) {
          modalPlaneacion.style.display = "none";
        }
      };


      document.getElementById("openModalCalificaciones").addEventListener("click", function() {
        document.getElementById("modalCalificaciones").style.display = "block";
      });

      // Cerrar modal de subir calificaciones al hacer clic en el botón de cerrar
      document.getElementsByClassName("close")[1].addEventListener("click", function() {
        document.getElementById("modalCalificaciones").style.display = "none";
      });
      // Cerrar la ventana modal si el usuario hace clic fuera de ella
      window.onclick = function(event) {
        if (event.target == modal || event.target == modalCalificaciones) {
          modal.style.display = "none";
          modalCalificaciones.style.display = "none"; // Ocultar el modal de calificaciones también
        }

        var closeCalificacionesBtn = document.querySelector("#modalCalificaciones .close");

        // Agregar un event listener para el clic en el botón de cerrar del modal de calificaciones
        closeCalificacionesBtn.addEventListener("click", function() {
          document.getElementById("modalCalificaciones").style.display = "none";
        });
      }
    </script>
  </body>

  </html>