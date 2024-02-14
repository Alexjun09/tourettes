document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formularioPerfil");
    if (!form) return; // Asegura que el form exista antes de añadir listeners
    const style = document.createElement("style");
    style.innerHTML = `
        .error { border-color: red; }
        .error-text { color: red; font-size: 0.8rem; margin-top: 5px; }`;
    document.head.appendChild(style);

    form.addEventListener("submit", async function (event) {
        event.preventDefault(); // Previene el envío por defecto del formulario.
        clearErrors(); // Limpia errores previos antes de la validación.

        // Validaciones
        const nombreValid = validateCampoRequerido(form.nombre.value, "nombre");
        const emailValid = await checkEmailAvailability(form.email.value);
        const telefonoValid = validateTelefono(form.telefono.value); // Validación del teléfono con la expresión regular
        const edadValid = validateEdad(form.edad.value);

        // Si todas las validaciones son exitosas, envía el formulario.
        if (nombreValid && emailValid && telefonoValid && edadValid) {
            form.submit(); // Considerar el uso de AJAX para el envío si quieres evitar la recarga de página
        }
    });
});

function validateCampoRequerido(valor, campo) {
    if (valor.trim() === "") {
        showError(campo, "Este campo no puede estar vacío");
        return false;
    }
    return true;
}

async function checkEmailAvailability(email) {
    const esCampoValido = validateCampoRequerido(email, "email");
    if (!esCampoValido) return false;

    // Comprueba si el email tiene un formato válido.
    if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
        showError("email", "El email no tiene un formato válido");
        return false;
    }
  
    // Aquí asumimos que la función retorna true por simplicidad, ajusta según tu lógica de disponibilidad
    return true; // Retorna true para permitir la continuación del flujo, ajusta según tu implementación real
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

function validateEdad(edad) {
    const esCampoValido = validateCampoRequerido(edad, "edad");
    if (!esCampoValido) return false;

    if (edad < 0 || edad > 120) { // Asumiendo un rango razonable para la edad
        showError("edad", "La edad debe ser un número entre 0 y 120");
        return false;
    }
    return true;
}

function showError(inputName, message) {
    const input = document.querySelector(`input[name="${inputName}"]`);
    input.classList.add("error");

    const error = document.createElement("div");
    error.className = "error-text";
    error.textContent = message;
    input.parentNode.insertBefore(error, input.nextSibling);
}

function clearErrors() {
    const errors = document.querySelectorAll(".error-text");
    errors.forEach(error => error.remove());

    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => input.classList.remove("error"));
}
