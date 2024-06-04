<?php
session_start();

if (!isset($_SESSION['tipo'])) {
    header('location: ../../');
} else {
    if ($_SESSION['tipo'] != 1) {
        header('location: ../../');
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANEACION Y AVANCES</title>
    <link rel="stylesheet" href="../../estilos/administrador.css">
    <!--DataTables-->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!--Font-Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <header>
        <div class="contenedor">
            <nav class="contenedor menu">
                <ul class="menu-lista">
                    <li class="opcion"><a href="../"><i class="fa-solid fa-house"></i> HOME</a></li>
                    <li class="opcion"><a href="../PROFESORES/"><i class="fa-solid fa-chalkboard-user"></i> PROFESORES</a></li>
                    <li class="opcion"><a href="../NIVELES/"><i class="fa-solid fa-user-group"></i> NIVELES</a></li>
                    <li class="opcion disabled"><a href="../PLANEACION_Y_AVANCE/"><i class="fa-solid fa-file"></i> PLANEACION Y AVANCE</a></li>
                    <li class="opcion"><a href="../ALUMNOS/"><i class="fa-solid fa-user"></i> ALUMNOS</a></li>
                    <li class="opcion"><a href="../ACTAS_Y_CONSTANCIAS/"><i class="fa-solid fa-file"></i> ACTAS Y CONSTANCIAS</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container my-5 table-responsive" id="contenedor_tabla">
            <div class="row">
                <table id="grupos" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">GRUPO</th>
                            <th class="text-center">PLANEACION ESTRATEGICA</th>
                            <th class="text-center">AVANCE PROGRAMATICO 1</th>
                            <th class="text-center">AVANCE PROGRAMATICO 2</th>
                            <th class="text-center">AVANCE PROGRAMATICO 3</th>
                            <th class="text-center">PLANEACION PROFESOR</th>
                            <th class="text-center">AVANCE PROFESOR 1</th>
                            <th class="text-center">AVANCE PROFESOR 2</th>
                            <th class="text-center">AVANCE PROFESOR 3</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>

                    <tbody id="table_grupos">

                    </tbody>

                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="close">
            <button id="log_out" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR SESION</button>
        </div>
    </main>

    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--DataTables-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--SweetAlert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS -->
    <script src="../../JS/ADMINISTRADOR/planeacion.js"></script>
    <script src="../../JS/ADMINISTRADOR/cerrar_sesion.js"></script>
</body>

</html>