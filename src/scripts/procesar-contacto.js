document.addEventListener("DOMContentLoaded", function () {
    
    const form = document.getElementById("formulario"); // Asegúrate de asignar este id a tu formulario
    console.log(form);
    if (!form) return; // Asegura que el formulario exista antes de añadir listeners
    // Estilos para errores
    const style = document.createElement("style");
    style.innerHTML = `
        .error { border-color: red; }
        .error-text { color: red; font-size: 0.8rem; margin-top: 5px; display: block; }`;
    document.head.appendChild(style);

    form.addEventListener("submit", async function (event) {
        event.preventDefault(); // Previene el envío por defecto del formulario.
        clearErrors(); // Limpia errores previos antes de la validación.

        // Validaciones
        const nombreCompletoValid = validateCampoRequerido(form.nombre.value, "nombre");
        const emailValid = await checkEmailAvailability(form.email.value);
        const telefonoValid = validateTelefono(form.telefono.value);
        const motivoValid = validateCampoRequerido(form.motivo.value, "motivo");
        const terminosValid = validateTerminos(); // Validación de los términos y condiciones

        // Si todas las validaciones son exitosas, envía el formulario.
        if (nombreCompletoValid && emailValid && telefonoValid && motivoValid && terminosValid) {
            form.submit(); // Considerar el uso de AJAX para el envío si quieres evitar la recarga de página
        }
    });
});

function validateCampoRequerido(valor, campo) {
    const input = document.querySelector(`[name="${campo}"]`);
    if (valor.trim() === "") {
        showError(campo, "Este campo no puede estar vacío");
        return false;
    }
    return true;
}

async function checkEmailAvailability(email) {
    const esCampoValido = validateCampoRequerido(email, "email");
    if (!esCampoValido) return false;

    if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
        showError("email", "El email no tiene un formato válido");
        return false;
    }
    // Simula una comprobación de disponibilidad de email
    return true;
}

function validateTelefono(telefono) {
    const esCampoValido = validateCampoRequerido(telefono, "telefono");
    if (!esCampoValido) return false;

    if (!/^\d{9}$/.test(telefono)) {
        showError("telefono", "El teléfono debe tener 9 dígitos");
        return false;
    }
    return true;
}

function validateTerminos() {
    const terminos = document.querySelector(`input[name="terminos"]`).checked;
    if (!terminos) {
        showError("terminos", "Debe aceptar los términos y condiciones para continuar");
        return false;
    }
    return true;
}

function showError(inputName, message) {
    const input = document.querySelector(`[name="${inputName}"]`);
    const error = document.createElement("div");
    error.className = "error-text";
    error.textContent = message;
    input.classList.add("error");
    if (inputName === "terminos") {
        // Posiciona el mensaje de error de manera diferente para el checkbox si es necesario
        input.parentNode.parentNode.insertBefore(error, input.parentNode.nextSibling);
    } else {
        input.parentNode.insertBefore(error, input.nextSibling);
    }
}

function clearErrors() {
    const errors = document.querySelectorAll(".error-text");
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll(".error");
    inputs.forEach(input => input.classList.remove("error"));
}

