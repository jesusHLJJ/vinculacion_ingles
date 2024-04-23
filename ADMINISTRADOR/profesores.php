<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFESORES</title>
    <!--DataTables-->
    <link href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!--Font-Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <nav class="contenedor" id="contenedor">
            <ul class="lista">
                <li class="menu"><a href="index.php">HOME</a></li>
                <li class="menu">PROFESORES</li>
                <li class="menu"><a href="niveles.php">NIVELES</a></li>
                <li class="menu"><a href="">AVANCE PROGRAMATICO</a></li>
                <li class="menu"><a href="../ADMINISTRADOR/Tabla_alumnos/tabla_alumnos.php">ALUMNOS</a></li>
                <li class="menu"><a href="">ACTAS DE CALIFICACION</a></li>
            </ul>
        </nav>
    </header>

    <div class="container my-5">
        <div class="row">
            <table id="profesores" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>ESTATUS</th>
                        <th>EDAD</th>
                        <th>ESTADO CIVIL</th>
                        <th>SEXO</th>
                        <th>DOMICILIO</th>
                        <th>RFC</th>
                        <th>MODALIDAD</th>
                        <th>NIVEL</th>
                        <th>TURNO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>

                <tbody id="table_profesor">

                </tbody>

                <tfoot>
                    <button class="btn btn-info" id="agregar">Nuevo Usuario</button>
                </tfoot>
            </table>
        </div>
    </div>
    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <script src="../JS/DataTable.js"></script>
    <script src="../JS/SweetAlert.js"></script>
</body>

<style>
    .lista {
    list-style-type: none;
    margin: 0;
    padding: 0;
    background-color: #333; 
    overflow: hidden; 
    font-size: 18px; 
}

.menu {
    float: left; 
    width: 16.6%; 
}

.menu a {
    display: block;
    color: white; 
    text-align: center;
    padding: 20px 0; 
    text-decoration: none;
}

.menu a:hover {
    background-color: #555; 
}


.menu a:hover {
    color: #555; 
}

.lista {
    list-style-type: none;
    margin: 0;
    padding: 0;
    background-color: #2cdd00; 
    overflow: hidden; 
}

.menu {
    float: left; 
}

.menu a {
    display: block;
    color: white; 
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

.menu a:hover {
    background-color: #ffffff; 
}
</style>
</html>