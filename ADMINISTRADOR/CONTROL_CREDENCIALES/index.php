<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREDENCIALES</title>
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
                    <li class="opcion"><a href="../PLANEACION_Y_AVANCE/"><i class="fa-solid fa-file"></i> PLANEACION Y AVANCE</a></li>
                    <li class="opcion"><a href="../ALUMNOS/"><i class="fa-solid fa-user"></i> ALUMNOS</a></li>
                    <li class="opcion"><a href="../ACTAS_Y_CONSTANCIAS/"><i class="fa-solid fa-file"></i> ACTAS Y CONSTANCIAS</a></li>
                    <li class="opcion disabled"><a href="../CONTROL_CREDENCIALES/"><i class="fa-solid fa-ticket-simple"></i> CONTROL DE CREDENCIALES</a></li>
                    <li class="opcion"><a href="../AGREGAR_ADMINISTRADOR/"><i class="fa-solid fa-user-tie"></i> AGREGAR ADMINISTRADORES</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="filtro container mt-5">
            <!-- Filtro personalizado para tipo de usuario -->
            <label for="tipoUsuario">Filtrar por tipo de usuario:</label>
            <select id="tipoUsuario">
                <option value="">Todos</option>
                <option value="Administrador">Administrador</option>
                <option value="Profesor">Profesor</option>
                <option value="Alumno">Alumno</option>
            </select>
        </div>

        <div class="container mt-3 table table-responsive">
            <div class="row">
                <table id="credenciales" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">NOMBRE</th>
                            <th class="text-center">AP. PATERNO</th>
                            <th class="text-center">AP. MATERNO</th>
                            <th class="text-center">TIPO DE USUARIO</th>
                            <th class="text-center">CORREO ELECTRONICO</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="table_credenciales">
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <div class="close">
            <button id="log_out" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR SESION</button>
        </div>
    </footer>

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
    <script src="../../JS/ADMINISTRADOR/credenciales.js"></script>
    <script src="../../JS/ADMINISTRADOR/cerrar_sesion.js"></script>
</body>

</html>