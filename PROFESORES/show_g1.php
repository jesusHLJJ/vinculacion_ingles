<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 2) {
        header('location: ../');
    }
}
include "../BD.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
    <link rel="stylesheet" href="../estilos/style_show_groups.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <!-- Contenedor del cargador -->
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

    <div class="container">
        <h1>Nivel: 1</h1>

        <?php
        // Consulta para obtener los grupos del nivel 1 del profesor actual
        $sql = "SELECT * FROM niveles WHERE id_profesor = " . $_SESSION['id_profesor'] . " AND nivel = 1";
        $result = mysqli_query($conexion, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<div class='grupos'>";
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['id_nivel'] = $row['id_nivel'];
                $grupo = $row['grupo'];
                $_SESSION['grupo'] = $grupo;
                $cupo_max = $row['cupo_max'];
                $id_periodo = $row['id_periodo'];
                $modalidad = $row['modalidad'];
                $_SESSION['modalidad'] = $modalidad;
                $horario = $row['horario'];
                $_SESSION['horario'] = $horario; 
                $aula = $row['aula'];

                // Puedes agregar más campos aquí según sea necesario

                // Mostrar los detalles de cada grupo
        ?>
                <details class="groups">
                    <summary><?php echo $grupo; ?></summary>
                    <p>Cupo máximo: <?php echo $cupo_max; ?></p>
                    <!-- Agrega más información según tus necesidades -->
                    <!-- Aquí tienes un ejemplo con algunos campos -->
                    <p>Modalidad: <?php echo $modalidad; ?></p>
                    <p>Horario: <?php echo $horario; ?></p>
                    <p>Aula:<?php echo $aula; ?></p> </p>
                    <!-- Puedes agregar más detalles aquí -->
                    <a href="info_grupo.php">Ir al grupo</a>
                </details>
        <?php
            }
            echo "</div>";
        } else {
            echo "<p>No se encontraron grupos para este nivel.</p>";
        }
        ?>
    </div>

    <form action="" method="post">
        <input type="submit" id="volver" name="volver" value="VOLVER">
    </form>

    
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

<?php
if (isset($_POST['volver'])) {
    header("Location: index.php");
    exit; // Asegúrate de salir después de redirigir
}
?>
