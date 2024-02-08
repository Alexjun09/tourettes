// Espera a que el contenido del DOM esté completamente cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Selecciona el formulario y crea un elemento de estilo para los errores.
    const form = document.querySelector('form');
    const style = document.createElement('style');
    style.innerHTML = `
        .error { border-color: red; }
        .error-text { color: red; font-size: 0.8rem; margin-top: 5px; }`;
    document.head.appendChild(style); // Añade el estilo al <head> para su uso global.

    // Maneja el evento de envío del formulario de manera asíncrona.
    form.addEventListener('submit', async function (event) {
        event.preventDefault(); // Previene el envío por defecto.
        clearErrors(); // Limpia errores previos antes de la validación.

        // Realiza validaciones síncronas para nombre completo, email, teléfono y contraseña.
        const nombreCompletoValid = validateNombreCompleto(form.nombreCompleto.value);
        const telefonoValid = validateTelefono(form.telefono.value);
        const contrasenaValid = validateContrasena(form.contrasena.value);

        // Verifica la disponibilidad del nombre de usuario de manera asíncrona.
        const nombreUsuarioValid = await checkUsernameAvailability(form.nombreUsuario.value);
        const emailUsuarioValid = await checkEmailAvailability(form.email.value);

        // Si todas las validaciones son exitosas, envía el formulario.
        if (nombreCompletoValid && nombreUsuarioValid && telefonoValid && contrasenaValid && emailUsuarioValid) {
            form.submit();
        }
    });
});

// Valida que el nombre completo no esté vacío.
function validateNombreCompleto(nombreCompleto) {
    if (nombreCompleto.trim() === '') {
        showError('nombreCompleto', 'El nombre no puede estar vacío');
        return false;
    }
    return true;
}

// Valida que el teléfono tenga 9 dígitos.
function validateTelefono(telefono) {
    if (!/^\d{9}$/.test(telefono)) {
        showError('telefono', 'El teléfono debe tener 9 dígitos');
        return false;
    }
    return true;
}

// Valida la contraseña con requisitos específicos de longitud, alfanuméricos y mayúscula.
function validateContrasena(contrasena) {
    if (!/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/.test(contrasena) || contrasena.length < 8 || !/[A-Z]/.test(contrasena)) {
        showError('contrasena', 'La contraseña debe tener al menos 8 caracteres alfanuméricos y una mayúscula');
        return false;
    }
    return true;
}

//-------------------------------------------------------------------------------------------------------------------//
// Define una función asíncrona para verificar la disponibilidad del nombre de usuario.
async function checkUsernameAvailability(nombreUsuario) {
    // Comprueba si el nombre de usuario contiene espacios en blanco.
    if (/\s/.test(nombreUsuario)) {
        // Muestra un mensaje de error si el nombre de usuario contiene espacios.
        showError('nombreUsuario', 'El nombre de usuario no debe contener espacios');
        // Retorna falso indicando que el nombre de usuario no es válido.
        return false;
    }
    
    // Realiza una petición asíncrona al servidor para verificar la disponibilidad del nombre de usuario.
    const response = await fetch('../src/server/check_username.php', {
        method: 'POST', // Especifica el método HTTP de la petición como POST.
        headers: {
            // Indica el tipo de contenido que se está enviando en la petición.
            'Content-Type': 'application/x-www-form-urlencoded',
            // Acepta una respuesta en formato JSON.
            'Accept': 'application/json'
        },
        // Codifica el nombre de usuario para su envío y lo incluye en el cuerpo de la petición.
        body: `nombreUsuario=${encodeURIComponent(nombreUsuario)}`
    });

    // Espera por la respuesta del servidor y convierte el cuerpo de la respuesta a formato JSON.
    const data = await response.json();
    // Comprueba si el nombre de usuario ya existe según la respuesta del servidor.
    if (data.exists) {
        // Muestra un mensaje de error si el nombre de usuario ya está en uso.
        showError('nombreUsuario', 'Este nombre de usuario ya está en uso');
        // Retorna falso indicando que el nombre de usuario no está disponible.
        return false;
    }
    // Retorna verdadero si el nombre de usuario está disponible.
    return true;
}

async function checkEmailAvailability(email) {
    // Comprueba si el email tiene un formato válido.
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        // Muestra un mensaje de error si el email no es válido.
        showError('email', 'El email no tiene un formato válido');
        return false;
    }
    
    // Realiza una petición asíncrona al servidor para verificar la disponibilidad del email.
    const response = await fetch('../src/server/check_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json'
        },
        body: `email=${encodeURIComponent(email)}`
    });

    const data = await response.json();
    // Comprueba si el email ya existe según la respuesta del servidor.
    if (data.exists) {
        // Muestra un mensaje de error si el email ya está en uso.
        showError('email', 'Este email ya está en uso');
        return false;
    }
    // Retorna verdadero si el email está disponible.
    return true;
}

//-----------------------------------------------------------------------------------------------------------//



// Muestra mensajes de error debajo del campo correspondiente.
function showError(inputName, message) {
    const input = document.querySelector(`input[name="${inputName}"]`);
    input.style.borderColor = 'red'; // Marca el campo con un borde rojo para indicar error.

    // Crea y añade un mensaje de error debajo del campo.
    const error = document.createElement('div');
    error.style.color = 'red';
    error.style.fontSize = '0.8rem';
    error.style.marginTop = '5px';
    error.className = 'error-text';
    error.textContent = message;
    input.parentNode.insertBefore(error, input.nextSibling);
}

// Limpia todos los errores visualizados previamente antes de una nueva validación.
function clearErrors() {
    // Elimina los mensajes de error.
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    // Restablece el estilo de los campos de entrada.
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.style.borderColor = '');
}
