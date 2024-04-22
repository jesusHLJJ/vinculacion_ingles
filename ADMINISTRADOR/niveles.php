<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <title>NIVELES</title>
</head>

<body>
    <header>
        <nav class="contenedor" id="contenedor">
            <ul class="lista">
                <li class="menu"><a href="index.php">HOME</a></li>
                <li class="menu"><a href="profesores.php">PROFESORES</a></li>
                <li class="menu">NIVELES</li>
                <li class="menu"><a href="">AVANCE PROGRAMATICO</a></li>
                <li class="menu"><a href="">ALUMNOS</a></li>
                <li class="menu"><a href="">ACTAS DE CALIFICACION</a></li>
            </ul>
        </nav>
    </header>

    <table id="niveles" class="display" style="width:100%">
        <thead>
            <tr>
                <th>NIVEL</th>
                <th>GRUPO</th>
                <th>PROFESOR</th>
                <th>CUPO MAXIMO</th>
                <th>MODALIDAD</th>
                <th>HORARIO</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php

            ?>
        </tbody>

        <tfoot>
            <button class="btn btn-agregar" id="add">Nuevo Registro</button>
        </tfoot>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../JS/DataTable.js"></script>
    <script src="../JS/SweetAlert.js"></script>
</body>

</html>