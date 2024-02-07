// Espera a que el contenido del DOM se haya cargado completamente.
document.addEventListener('DOMContentLoaded', function () {
    // Crear un elemento de estilo y agregar reglas CSS para mostrar errores.
    const style = document.createElement('style');
    style.innerHTML = `
        .error {
            border-color: red;
        }

        .error-text {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }
        .general-error {
            color: red;
            font-size: 0.8rem;
            margin-bottom: 10px;
            text-align: center;
        }`;
// Añadir el elemento de estilo al <head> del documento.

    document.head.appendChild(style);

    // Seleccionar el formulario por su ID y escuchar el evento de envío.
    const form = document.querySelector('#form-cita');
    form.addEventListener('submit', function (event) {
    // Prevenir el envío automático del formulario.
        event.preventDefault();
    // Limpiar errores previos antes de la nueva validación.
        clearErrors();

        // Recoger valores de los campos del formulario.
        const fecha = form.querySelector('input[name="fecha"]').value;
        const motivoConsulta = form.querySelector('input[name="motivo_consulta"]').value;
        const visita = form.querySelector('input[name="visita"]:checked');
        const terminos = form.querySelector('input[type="checkbox"]').checked;

        // Inicializar la validación como verdadera.
        let isValid = true;

// Validar cada campo y mostrar errores si es necesario.        
        if (!fecha) {
            showError('fecha', 'La fecha es obligatoria');
            isValid = false;
        }

        if (!motivoConsulta) {
            showError('motivo_consulta', 'El motivo de la consulta es obligatorio');
            isValid = false;
        }

        if (!visita) {
            showError('visita', 'Debe indicar si nos ha visitado antes');
            isValid = false;
        }

        if (!terminos) {
            showError('terminos', 'Debe aceptar los términos y condiciones');
            isValid = false;
        }

        // Si todos los campos son válidos, enviar el formulario.
        if (isValid) {
            form.submit();
        }
    });
});

// Función para mostrar errores específicos de los campos.
function showError(inputName, message) {
    let input;
    // Seleccionar el campo o etiqueta específica para mostrar el error.
    if (inputName === 'terminos') {
        input = document.querySelector('input[type="checkbox"]');
    } else if (inputName === 'visita') {
        input = document.querySelector('label[for="visita"]');
    } else {
        input = document.querySelector(`input[name="${inputName}"]`);
    }

// Si no se encuentra el campo, mostrar error en la consola (control de errores)
    if (!input) {
        console.error('No se encontró el campo: ' + inputName);
        return;
    }
// Crear y añadir el mensaje de error al DOM.
    const error = document.createElement('div');
    error.className = 'error-text';
    error.textContent = message;

    // Posicionar el mensaje de error en el formulario.
    if (inputName === 'visita' || inputName === 'terminos') {
        input.parentNode.parentNode.insertBefore(error, input.parentNode.nextSibling);
    } else {
        input.classList.add('error');
        input.parentNode.insertBefore(error, input.nextSibling);
    }
}

// Función para limpiar todos los errores mostrados anteriormente.
function clearErrors() {
        // Eliminar todos los mensajes de error.
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());
    // Quitar la clase de error de todos los campos de entrada.
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('error'));
}
