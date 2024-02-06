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
    const form = document.querySelector('#form-contacto');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();

        // Valores del formulario
        const nombreCompleto = form.querySelector('input[name="nombre_completo"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const motivo = form.querySelector('textarea[name="motivo"]').value;
        const terminos = form.querySelector('input[name="terminos"]').checked;

        // Validaciones
        let isValid = true;
        if (!nombreCompleto) {
            showError('nombre_completo', 'El nombre completo es obligatorio');
            isValid = false;
        }

        if (!email) {
            showError('email', 'El email es obligatorio');
            isValid = false;
        } else if (!validateEmail(email)) {
            showError('email', 'El email no tiene un formato válido');
            isValid = false;
        }

        if (!motivo) {
            showError('motivo', 'El motivo es obligatorio');
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

    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function showError(inputName, message) {
        const input = document.querySelector(`[name="${inputName}"]`);
        const error = document.createElement('div');
        error.className = 'error-text';
        error.textContent = message;
        input.classList.add('error');
        input.parentNode.insertBefore(error, input.nextSibling);
    }

    function clearErrors() {
        const errors = document.querySelectorAll('.error-text');
        errors.forEach(error => error.remove());
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => input.classList.remove('error'));
    }
});
