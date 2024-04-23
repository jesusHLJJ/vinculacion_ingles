<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
</head>

<body>
    <div class="contenedor" id="contenedor">
        <ul class="lista">
            <li class="menu">HOME</li>
            <li class="menu"><a href="profesores.php">PROFESORES</a></li>
            <li class="menu"><a href="niveles.php">NIVELES</a></li>
            <li class="menu"><a href="">AVANCE PROGRAMATICO</a></li>
            <li class="menu"><a href="../ADMINISTRADOR/Tabla_alumnos/tabla_alumnos.php">ALUMNOS</a></li>
            <li class="menu"><a href="">ACTAS DE CALIFICACION</a></li>
        </ul>
    </div>

    <div class="cerrar_sesion">
    </div>
</body>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contenedor {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .lista {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .menu {
            display: block;
            padding: 10px 20px;
            background-color: #343a40;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin: 10px 0;
        }

        .menu:hover {
            background-color: #495057;
        }

        .menu a {
            color: #ffffff;
            text-decoration: none;
        }

        .cerrar_sesion {
            text-align: center;
            margin-top: 20px;
        }
    </style>

</html>