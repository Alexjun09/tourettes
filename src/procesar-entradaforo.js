// Espera a que el contenido del DOM esté completamente cargado antes de ejecutar la lógica.
document.addEventListener('DOMContentLoaded', function () {
    // Crear un elemento de estilo y definir reglas CSS para visualizar los errores.
    const style = document.createElement('style');
    style.innerHTML = `
        .error-border {
            border-color: red !important;
        }
        
        .error-text {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }`;
    // Añade el elemento de estilo al <head> del documento.
    document.head.appendChild(style);

    // Seleccionar el formulario por su ID y escuchar el evento de envío.
    const form = document.getElementById('form-foro');
    form.addEventListener('submit', function (event) {
        // Prevenir el envío automático del formulario para realizar validaciones.
        event.preventDefault(); 
        // Limpiar mensajes de error previos antes de validar nuevamente.
        clearErrors();
        // Inicializar la variable de validez como verdadera.
        let isValid = true;

        // Validar título: debe tener contenido.
        const title = document.getElementById('titulo');
        if (!title.value.trim()) {
            showError(title, 'El título es obligatorio');
            isValid = false;
        }

        // Validar palabras clave: deben tener contenido.
        const palabrasclave = document.getElementById('clave');
        if (!palabrasclave.value.trim()) {
            showError(palabrasclave, 'Las palabras clave son obligatorias');
            isValid = false;
        }

        // Validar cuerpo del mensaje: debe tener contenido.
        const cuerpo = document.getElementById('cuerpo');
        if (!cuerpo.value.trim()) {
            showError(cuerpo, 'El cuerpo es obligatorio');
            isValid = false;
        }

        // Validar aceptación de términos y condiciones.
        const terminos = form.querySelector('input[name="terminos"]');
        if (!terminos.checked) {
            showError(terminos, 'Debe aceptar los términos y condiciones');
            isValid = false;
        }

        // Si todos los campos son válidos, permitir el envío del formulario.
        if (isValid) {
            form.submit();
        }
    });
});

// Función para mostrar errores de validación específicos de los campos.
function showError(element, message) {
    // Agregar clase de error para visualizar el borde rojo.
    element.classList.add('error-border');
    // Crear y añadir el mensaje de error justo después del campo con error.
    const error = document.createElement('div');
    error.className = 'error-text';
    error.textContent = message;
    element.parentNode.insertBefore(error, element.nextSibling); // Insertar texto de error
}

// Función para limpiar todos los mensajes de error y bordes rojos mostrados previamente.
function clearErrors() {
    // Eliminar todos los mensajes de error.
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());
    // Quitar la clase de error de los bordes para todos los campos afectados.
    const errorBorders = document.querySelectorAll('.error-border');
    errorBorders.forEach(border => border.classList.remove('error-border'));
}
