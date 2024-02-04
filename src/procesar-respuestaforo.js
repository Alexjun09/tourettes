document.addEventListener("DOMContentLoaded", function () {
  // Insertar estilos CSS para indicar errores
  const style = document.createElement("style");
  style.innerHTML = `
        .error-border {
            border-color: red !important;
        }

        .error-text {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }`;
  document.head.appendChild(style);

  const form = document.querySelector("form");
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevenir el envío del formulario
    clearErrors(); // Limpiar errores previos

    // Validación del cuerpo de la respuesta
    const cuerpo = document.getElementById("cuerpo");
    if (!cuerpo.value.trim()) {
      showError(cuerpo, "El cuerpo de la respuesta no puede estar vacío");
      return; // Detener la función si hay un error
    }

    // Si todo es válido, enviar el formulario
    form.submit();
  });
});

function showError(element, message) {
  element.classList.add("error-border"); // Agregar clase de error para el borde

  const error = document.createElement("div");
  error.className = "error-text";
  error.textContent = message;
  element.parentNode.insertBefore(error, element.nextSibling); // Insertar texto de error
}

function clearErrors() {
  const errors = document.querySelectorAll(".error-text");
  errors.forEach((error) => error.remove());

  const errorBorders = document.querySelectorAll(".error-border");
  errorBorders.forEach((border) => border.classList.remove("error-border"));
}
