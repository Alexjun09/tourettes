// Espera a que todo el contenido del DOM esté cargado antes de ejecutar la lógica.
document.addEventListener('DOMContentLoaded', function () {
    // Crea un elemento de estilo y define reglas CSS para visualizar los errores.
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
    // Añade el elemento de estilo al <head> del documento.
    document.head.appendChild(style);

    // Selecciona el formulario por su ID y escucha el evento de envío.
    const form = document.querySelector('#form-contacto');
    form.addEventListener('submit', function (event) {
        // Previene el envío automático del formulario para realizar validaciones.
        event.preventDefault();
        // Limpia los mensajes de error previos antes de validar de nuevo.
        clearErrors();

        // Recoge los valores ingresados en los campos del formulario.
        const nombreCompleto = form.querySelector('input[name="nombre_completo"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const motivo = form.querySelector('textarea[name="motivo"]').value;
        const terminos = form.querySelector('input[name="terminos"]').checked;

        // Inicializa la variable de validez como verdadera.
        let isValid = true;
        // Realiza las validaciones de cada campo y muestra errores si es necesario.
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

        // Si todos los campos son válidos, se procede con el envío del formulario.
        if (isValid) {
            form.submit();
        }
    });

        // Función para validar el formato del correo electrónico usando una expresión regular.
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

        // Función para mostrar errores de validación específicos de los campos.
    function showError(inputName, message) {
        const input = document.querySelector(`[name="${inputName}"]`);
        const error = document.createElement('div');
        error.className = 'error-text';
        error.textContent = message;
        input.classList.add('error');
        // Inserta el mensaje de error en el DOM, justo después del campo con error.
        input.parentNode.insertBefore(error, input.nextSibling);
    }

    // Función para limpiar todos los mensajes de error mostrados anteriormente.
    function clearErrors() {
        const errors = document.querySelectorAll('.error-text');
        errors.forEach(error => error.remove());
        // Remueve la clase de error de todos los campos de entrada y área de texto.
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => input.classList.remove('error'));
    }
});
