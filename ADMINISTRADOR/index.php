<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="../estilos/administrador.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <main class="principal">
        <div class="contenedor-inicio">
            <nav class="contenedor-menu-inicio">
                <ul class="menu-lista-inicio">
                    <li class="opcion-inicio disabled"><a href=""><i class="fa-solid fa-house"></i> HOME</a></li>
                    <li class="opcion-inicio"><a href="PROFESORES/"><i class="fa-solid fa-chalkboard-user"></i> PROFESORES</a></li>
                    <li class="opcion-inicio"><a href="NIVELES/"><i class="fa-solid fa-user-group"></i> NIVELES</a></li>
                    <li class="opcion-inicio"><a href="PLANEACION_Y_AVANCE/"><i class="fa-solid fa-file"></i> PLANEACION Y AVANCE</a></li>
                    <li class="opcion-inicio"><a href="ALUMNOS/"><i class="fa-solid fa-user"></i> ALUMNOS</a></li>
                    <li class="opcion-inicio"><a href="ACTAS_Y_CONSTANCIAS/"><i class="fa-solid fa-file"></i> ACTAS Y CONSTANCIAS</a></li>
                </ul>
            </nav>
        </div>

        <div class="close">
            <button id="log_out" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> CERRAR SESION</button>
        </div>
    </main>

    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS -->
    <script src="../JS/cerrar_sesion.js"></script>
</body>

</html>