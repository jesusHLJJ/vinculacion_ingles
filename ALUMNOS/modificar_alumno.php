<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../');
} else {
    if ($_SESSION['tipo'] != 3) {
        header('location: ../');
    }
}
include '../BD.php';

$ingreso = $_SESSION['correo'];

//CONSULTAS SQL PARA OBTENER LOS DATOS DEL ALUMNO//


$t_nombres = '';
$t_ap_pa = '';
$t_ap_ma = '';

$t_edad = '';
$t_sexo = '';
$t_telefono = '';

$t_id_carrera = '';

//DATOS DEL ALUMNO
$sql = "select alumnos.matricula,alumnos.nombre,alumnos.ap_paterno,alumnos.ap_materno,alumnos.edad,alumnos.sexo,alumnos.telefono,alumnos.id_carrera from alumnos join usuarios on alumnos.id_usuarios=usuarios.id_usuario where usuarios.correo='$ingreso'";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
//Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener el nombre de la fila
    $fila = $result->fetch_assoc();
    $t_matricula = $fila['matricula'];
    $t_nombres = $fila['nombre'];
    $t_ap_pa = $fila['ap_paterno'];
    $t_ap_ma = $fila['ap_materno'];

    $t_edad = $fila['edad'];
    $t_sexo = $fila['sexo'];
    $t_telefono = $fila['telefono'];

    $t_id_carrera = $fila['id_carrera'];
}

$nombres = $t_nombres;
$ap_pa = $t_ap_pa;
$ap_ma = $t_ap_ma;

$edad = $t_edad;
$sexo = $t_sexo;
$telefono = $t_telefono;

$id_carrera = $t_id_carrera;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS DATOS</title>
    <link rel="stylesheet" href="estilos/modificar_alumno.css">
</head>

<body>

    <div class="contenedor_botones">
        <form action='' method="POST">

            <label>CORREO ELECTRONICO: <br><span><?php echo $ingreso; ?></span></label><br>

            <label for="nombre">NOMBRE(S)</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombres; ?>" required><br>

            <label for="ap_pa">APELLIDO PATERNO</label>
            <input type="text" id="ap_pa" name="ap_pa" value="<?php echo $ap_pa; ?>" required><br>

            <label for="ap_ma">APELLIDO MATERNO</label>
            <input type="text" id="ap_ma" name="ap_ma" value="<?php echo $ap_ma; ?>" required><br>

            <label for="edad">EDAD</label>
            <input type="text" id="edad" name="edad" value="<?php echo $edad; ?>" maxlength="2" required><br>

            <label for="sexo">SEXO</label>
            <select name="sexo" id="sexo" required>
                <?php
                $sql="select alumnos.sexo from alumnos join usuarios on alumnos.id_usuarios=usuarios.id_usuario where usuarios.correo='$ingreso'";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                //Verificar si se encontraron resultados
                if ($result->num_rows > 0) {
                    // Obtener el nombre de la fila
                    $fila = $result->fetch_assoc();
                    $d_sexo = $fila['sexo'];
                    if($sexo=='F'){
                        echo "<option value='M'>MASCULINO</option>";
                        echo "<option value='F' selected>FEMENINO</option>"; 
                    }else{
                        echo "<option value='M' selected>MASCULINO</option>";
                        echo "<option value='F'>FEMENINO</option>"; 
                    }
                }
                ?>
            </select><br>
            

            <label for="numero">NÚMERO TELEFÓNICO</label>
            <input type="text" id="numero" name="numero" value="<?php echo $telefono; ?>" maxlength="10" required><br>

            <label for="carrera">CARRERA</label>
            <select name="carrera" id="carrera" required>
                <option value=''>Selecciona una opción...</option>
                <?php
                $sql = "SELECT * FROM carreras";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id_carr = $row['id_carrera'];
                        $nom_carr = $row["nombre_carrera"];
                        if ($id_carrera == $id_carr) {
                            echo '<option value="' . $id_carr . '"selected>' . $nom_carr . '</option>';
                        } else {
                            echo '<option value="' . $id_carr . '">' . $nom_carr . '</option>';
                        }
                    }
                }
                $stmt->close();
                ?>
            </select><br>


            <input type="submit" name="modificar" id="modificar" value="MODIFICAR">
            <input type="submit" name="volver" id="volver" value="VOLVER">



        </form>
    </div>

</body>

</html>


<?php
if (isset($_POST['modificar'])) {
    $f_nombre = $_POST['nombre'];
    $f_ap_pa = $_POST['ap_pa'];
    $f_ap_ma = $_POST['ap_ma'];
    $f_edad = $_POST['edad'];
    $f_sexo = $_POST['sexo'];
    $f_numero = $_POST['numero'];
    $f_carrera = $_POST['carrera'];
    $sql = "update alumnos set nombre='$f_nombre',ap_paterno='$f_ap_pa',ap_materno='$f_ap_ma',edad=$f_edad,sexo='$f_sexo',telefono='$f_numero',id_carrera=$f_carrera where matricula='$t_matricula'";
    $sql_query = mysqli_query($conexion, $sql);
    if ($sql_query) {
        echo "operacion realizada con exito";
        header("Location: ../ALUMNOS/datos_alumno.php");
    } else {
        echo "ocurrio un error a la hora de hacer la modificacion";
    }
    mysqli_close($conexion);
}

if (isset($_POST['volver'])) {
    header("Location: ../ALUMNOS/datos_alumno.php");
}
?>