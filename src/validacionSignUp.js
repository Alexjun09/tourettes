document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const style = document.createElement('style');
    style.innerHTML = `
        .error {
            border-color: red;
        }

        .error-text {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }`;
    document.head.appendChild(style);

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors();

        const nombreCompletoValid = validateNombreCompleto(form.nombreCompleto.value);
        const emailValid = validateEmail(form.email.value);
        const telefonoValid = validateTelefono(form.telefono.value);
        const contrasenaValid = validateContrasena(form.contrasena.value);

        // Verificar nombre de usuario de forma asincrónica
        const nombreUsuarioValid = await checkUsernameAvailability(form.nombreUsuario.value);

        if (nombreCompletoValid && nombreUsuarioValid && emailValid && telefonoValid && contrasenaValid) {
            form.submit();
        }
    });
});

function validateNombreCompleto(nombreCompleto) {
    if (nombreCompleto.trim() === '') {
        showError('nombreCompleto', 'El nombre no puede estar vacío');
        return false;
    }
    return true;
}

function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(email)) {
        showError('email', 'El email no tiene un formato válido');
        return false;
    }
    return true;
}

function validateTelefono(telefono) {
    if (!/^\d{9}$/.test(telefono)) {
        showError('telefono', 'El teléfono debe tener 9 dígitos');
        return false;
    }
    return true;
}

function validateContrasena(contrasena) {
    if (!/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/.test(contrasena) || contrasena.length < 8 || !/[A-Z]/.test(contrasena)) {
        showError('contrasena', 'La contraseña debe tener al menos 8 caracteres alfanuméricos y una mayúscula');
        return false;
    }
    return true;
}

async function checkUsernameAvailability(nombreUsuario) {
    if (/\s/.test(nombreUsuario)) {
        showError('nombreUsuario', 'El nombre de usuario no debe contener espacios');
        return false;
    }

    const response = await fetch('check_username.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json'
        },
        body: `nombreUsuario=${encodeURIComponent(nombreUsuario)}`
    });

    const data = await response.json();
    if (data.exists) {
        showError('nombreUsuario', 'Este nombre de usuario ya está en uso');
        return false;
    }

    return true;
}

function showError(inputName, message) {
    const input = document.querySelector(`input[name="${inputName}"]`);
    input.style.borderColor = 'red';

    const error = document.createElement('div');
    error.style.color = 'red';
    error.style.fontSize = '0.8rem';
    error.style.marginTop = '5px';
    error.className = 'error-text';
    error.textContent = message;
    input.parentNode.insertBefore(error, input.nextSibling);
}

function clearErrors() {
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.style.borderColor = '');
}


