document.addEventListener('DOMContentLoaded', function () {
    // Agregar estilos CSS para errores
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
    document.head.appendChild(style);

    // Evento de envío del formulario
    const form = document.querySelector('#form-cita');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();

        // Valores del formulario
        const fecha = form.querySelector('input[name="fecha"]').value;
        const motivoConsulta = form.querySelector('input[name="motivo_consulta"]').value;
        const visita = form.querySelector('input[name="visita"]:checked');
        const terminos = form.querySelector('input[type="checkbox"]').checked;

        // Validaciones
        let isValid = true;
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

        // Si todo es válido, se podría proceder con el envío del formulario
        if (isValid) {
            form.submit();
        }
    });
});

function showError(inputName, message) {
    let input;
    if (inputName === 'terminos') {
        input = document.querySelector('input[type="checkbox"]');
    } else if (inputName === 'visita') {
        input = document.querySelector('label[for="visita"]');
    } else {
        input = document.querySelector(`input[name="${inputName}"]`);
    }

    if (!input) {
        console.error('No se encontró el campo: ' + inputName);
        return;
    }

    const error = document.createElement('div');
    error.className = 'error-text';
    error.textContent = message;
    if (inputName === 'visita' || inputName === 'terminos') {
        input.parentNode.parentNode.insertBefore(error, input.parentNode.nextSibling);
    } else {
        input.classList.add('error');
        input.parentNode.insertBefore(error, input.nextSibling);
    }
}

function clearErrors() {
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('error'));
}
