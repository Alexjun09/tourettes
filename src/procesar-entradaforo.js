document.addEventListener('DOMContentLoaded', function () {
    // Estilos de error
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
    document.head.appendChild(style);

    const form = document.getElementById('form-foro');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevenir el envío predeterminado para validar
        clearErrors(); // Limpiar errores anteriores

        let isValid = true; // Bandera para seguir el estado de la validación

        // Validar título
        const title = document.getElementById('titulo');
        if (!title.value.trim()) {
            showError(title, 'El título es obligatorio');
            isValid = false;
        }

        // Validar palabras clave
        const palabrasclave = document.getElementById('clave');
        if (!palabrasclave.value.trim()) {
            showError(palabrasclave, 'Las palabras clave son obligatorias');
            isValid = false;
        }

        // Validar cuerpo
        const cuerpo = document.getElementById('cuerpo');
        if (!cuerpo.value.trim()) {
            showError(cuerpo, 'El cuerpo es obligatorio');
            isValid = false;
        }

        // Validar términos y condiciones
        const terminos = form.querySelector('input[name="terminos"]');
        if (!terminos.checked) {
            showError(terminos, 'Debe aceptar los términos y condiciones');
            isValid = false;
        }

        // Si todo es válido, enviar el formulario
        if (isValid) {
            form.submit();
        }
    });
});

function showError(element, message) {
    element.classList.add('error-border'); // Agregar clase de error para el borde

    const error = document.createElement('div');
    error.className = 'error-text';
    error.textContent = message;
    element.parentNode.insertBefore(error, element.nextSibling); // Insertar texto de error
}

function clearErrors() {
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    const errorBorders = document.querySelectorAll('.error-border');
    errorBorders.forEach(border => border.classList.remove('error-border'));
}
