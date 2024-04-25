<?php
session_start();

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

    
    <h1>Nivel: 3</h1>

    <?php
    include "../BD.php";

    $sql = "SELECT * FROM grupos WHERE id_profesor = " . $_SESSION['id_profesor'] . " AND nivel = 3";

    $result = mysqli_query($conexion, $sql);
    if ($result) {
        echo "<div class='grupos'>";
        while ($row = $result->fetch_array()) {
            $id_grupo = $row['id_grupo'];
            $nombre_grupo = $row['nombre_grupo'];
            $id_profesor = $row['id_profesor'];
            $nivel = $row['nivel'];
            $id_periodo = $row['id_periodo'];
            $modalidad = $row['modalidad'];
            $horario = $row['horario'];
            $cupo_minimo = $row['cupo_minimo'];
            $cupo_maximo = $row['cupo_maximo'];
            $aula = $row['aula'];
            $ciclo_escolar = $row['ciclo_escolar'];
            $id_planeacion = $row['id_planeacion'];
            $id_avance = $row['id_avance'];
    ?>

            <details class="groups">
                <summary><?php echo $nombre_grupo; ?></summary>
                <p>Aula: <?php echo $aula; ?></p>
                <a href="grupos_as.php?id_grupo=<?php echo $id_grupo; ?>">Ir al grupo</a>
            </details>

    <?php
        }
        echo "</div>";
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
}

?>
