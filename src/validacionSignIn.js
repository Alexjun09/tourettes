// Espera a que el contenido del DOM esté completamente cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Crea y agrega estilos CSS para visualizar errores en el formulario.
    const style = document.createElement('style');
    style.innerHTML = `
        .error { border-color: red; }
        .error-text { color: red; font-size: 0.8rem; margin-top: 5px; }
        .general-error { color: red; font-size: 0.8rem; margin-bottom: 10px; text-align: center; }`;
    document.head.appendChild(style); // Añade los estilos al <head> del documento.

    // Selecciona el formulario y añade un controlador para el evento de envío.
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Previene el envío predeterminado del formulario.
        clearErrors(); // Limpia los errores de validaciones anteriores.

        // Obtiene los valores de email y contraseña del formulario.
        const email = form.email.value;
        const password = form.password.value;

        // Valida el email y la contraseña.
        if (validateEmail(email) && validatePassword(password)) {
            // Si ambos son válidos, intenta iniciar sesión.
            signIn(email, password);
        }
    });
});

// Valida el formato del email usando una expresión regular.
function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(email)) {
        showError('email', 'El email no tiene un formato válido');
        return false;
    }
    return true;
}

// Valida la longitud de la contraseña.
function validatePassword(password) {
    if (password.length < 8) {
        showError('password', 'La contraseña debe tener al menos 8 caracteres');
        return false;
    }
    return true;
}
//-------------------------------------------------------------------------------------------//
//JSON AJAX
// Intenta iniciar sesión enviando los datos a un servidor.
function signIn(email, password) {
    //La función fetch es una forma de hacer solicitudes HTTP asincrónicas
    fetch('iniciar_sesion.php', { // Realiza una petición POST a iniciar_sesion.php.
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json()) // Espera una respuesta en formato JSON.
    .then(data => {
        if (data.success) {
            // Si el inicio de sesión es exitoso, redirige al usuario.
            window.location.href = data.redirectUrl;
        } else {
            // Muestra un mensaje de error general si el inicio de sesión falla.
            showError('general', data.error);
        }
    })
    .catch(error => {
        // Captura errores de conexión y muestra un mensaje de error general.
        console.error('Error:', error);
        showError('general', 'Error en la conexión con el servidor');
    });
}
// ----------------------------------------------------------------//


// Muestra mensajes de error en el formulario.
function showError(inputName, message) {
    if (inputName === 'general') {
        // Para errores generales, crea un div y lo añade al principio del formulario.
        const form = document.querySelector('form');
        const error = document.createElement('div');
        error.className = 'error-text general-error';
        error.textContent = message;
        form.prepend(error);
    } else {
        // Para errores específicos de campos, encuentra el input y añade un mensaje de error.
        const input = document.querySelector(`input[name="${inputName}"]`);
        if (!input) {
            console.error('No se encontró el campo: ' + inputName);
            return;
        }
        input.classList.add('error');
        const error = document.createElement('div');
        error.className = 'error-text';
        error.textContent = message;
        input.parentNode.insertBefore(error, input.nextSibling);
    }
}

// Limpia todos los mensajes de error previos antes de una nueva validación.
function clearErrors() {
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('error'));
}
