<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos/style_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        
    </header>

    <div class="wrapper">
        <form action="validar_log.php" method="post">
            <h1>INICIAR SESIÓN</h1>

            <div class="input-box">
                <input type="email" id="correo" name="correo" placeholder="Correo electronico" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" id="pass" name="pass" placeholder="Contraseña" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
           
            <button type="submit" class="btn" >Entrar</button>
            
            <div class="olvide-c">
                <a href="#">Registrarse</a>
            </div>
        </form>
    </div>
</body>
</html>