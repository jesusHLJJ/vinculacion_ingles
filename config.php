<?php
// Ruta al archivo donde se guarda el estado
$archivo_estado = __DIR__ . '/estado_sistema.txt';

// Si no existe, se crea con valor 1 (activo)
if (!file_exists($archivo_estado)) {
    file_put_contents($archivo_estado, "1");
}

// Leer el estado actual del sistema
$control_sistema = (int)trim(file_get_contents($archivo_estado));

// Si se envía desde el formulario del admin, actualiza
if (isset($_POST['control_sistema'])) {
    $control_sistema = (int)$_POST['control_sistema'];
    file_put_contents($archivo_estado, $control_sistema); // <-- guarda el valor
    echo $control_sistema == 1 ? "Sistema activado" : "Sistema desactivado";
    header('Location: ADMINISTRADOR/');
    exit();
}
?>
