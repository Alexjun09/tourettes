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
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();

        const email = form.email.value;
        const password = form.password.value;

        if (validateEmail(email) && validatePassword(password)) {
            signIn(email, password);
        }
    });
});

function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!regex.test(email)) {
        showError('email', 'El email no tiene un formato válido');
        return false;
    }
    return true;
}

function validatePassword(password) {
    if (password.length < 8) {
        showError('password', 'La contraseña debe tener al menos 8 caracteres');
        return false;
    }
    return true;
}

function signIn(email, password) {
    fetch('iniciar_sesion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirectUrl;
        } else {
            showError('general', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('general', 'Error en la conexión con el servidor');
    });
}

function showError(inputName, message) {
    if (inputName === 'general') {
        // Mostrar errores generales
        const form = document.querySelector('form');
        const error = document.createElement('div');
        error.className = 'error-text general-error';
        error.textContent = message;
        form.prepend(error);
    } else {
        // Mostrar errores específicos de un campo
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


function clearErrors() {
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('error'));
}

