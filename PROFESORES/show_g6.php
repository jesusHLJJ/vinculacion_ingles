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
</head>

<body>
    <div class="container">
        <h1>Nivel: 6</h1>

        <?php
        // Consulta para obtener los grupos del nivel 1 del profesor actual
        $sql = "SELECT * FROM niveles WHERE id_profesor = " . $_SESSION['id_profesor'] . " AND nivel = 6";
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

</body>

</html>

<?php
if (isset($_POST['volver'])) {
    header("Location: index.php");
    exit; // Asegúrate de salir después de redirigir
}
?>
