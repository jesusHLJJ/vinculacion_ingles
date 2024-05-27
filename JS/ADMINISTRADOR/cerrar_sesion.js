document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('log_out').addEventListener('click', function() {
        // Mostrar el diálogo de confirmación de SweetAlert
        Swal.fire({
            icon: 'question',
            title: '¿Estás seguro de cerrar sesión?',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma la acción
            if (result.isConfirmed) {
                // Redirigir a tu documento PHP para cerrar la sesión
                window.location.href = '../../VALIDACIONES/cerrar_sesion.php';
            }
        });
    });
});
