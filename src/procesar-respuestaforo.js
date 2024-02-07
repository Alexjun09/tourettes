// Espera a que el contenido del DOM esté completamente cargado antes de ejecutar la lógica.
document.addEventListener("DOMContentLoaded", function () {
  // Crea un elemento de estilo y define reglas CSS para señalar errores.
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
  // Añade el elemento de estilo al <head> del documento para aplicar los estilos.
  document.head.appendChild(style);

  // Selecciona el formulario y escucha el evento de envío.
  const form = document.querySelector("form");
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Previene el envío automático del formulario para realizar validaciones primero.
    clearErrors(); // Llama a la función para limpiar errores previos antes de la nueva validación.

    // Validación del campo "cuerpo" del formulario.
    const cuerpo = document.getElementById("cuerpo");
    if (!cuerpo.value.trim()) {
      showError(cuerpo, "El cuerpo de la respuesta no puede estar vacío"); // Muestra error si el campo está vacío.
      return; // Detiene la ejecución de la función si se encuentra un error.
    }

    // Si pasa todas las validaciones, se procede al envío del formulario.
    form.submit();
  });
});

// Función para mostrar errores de validación específicos de los campos.
function showError(element, message) {
  element.classList.add("error-border"); // Agrega una clase para indicar visualmente el error con un borde rojo.
  // Crea y añade un mensaje de error justo después del campo con error.
  const error = document.createElement("div");
  error.className = "error-text";
  error.textContent = message;
  element.parentNode.insertBefore(error, element.nextSibling); // Insertar texto de error
}

// Función para limpiar todos los mensajes de error y los bordes rojos mostrados anteriormente.
function clearErrors() {
  // Elimina todos los mensajes de error presentes.
  const errors = document.querySelectorAll(".error-text");
  errors.forEach((error) => error.remove());
  // Quita la clase de error de los bordes para todos los campos que la tenían.
  const errorBorders = document.querySelectorAll(".error-border");
  errorBorders.forEach((border) => border.classList.remove("error-border"));
}
