<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

function confirmarCerrarSesion() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres cerrar la sesión?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1D3A46',
        cancelButtonColor: '#92AAB3',
        confirmButtonText: 'Cerrar Sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Asumiendo que tienes un archivo logout.php que maneja el cierre de sesión
            window.location.href = '../server/logout.php';
        }
    });
    return false; // Evita la navegación
}