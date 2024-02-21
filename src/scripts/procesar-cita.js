// Esperar a que el DOM esté completamente cargado antes de ejecutar el script.
document.addEventListener("DOMContentLoaded", function () {
  // Crear un elemento de estilo y definir reglas CSS para mostrar errores.
  const style = document.createElement("style");
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

  // Añadir el elemento de estilo al <head> del documento para aplicar los estilos definidos.
  document.head.appendChild(style);

  // Seleccionar elementos clave del formulario para su manipulación.
  const form = document.querySelector("#form-cita");
  const inputFecha = form.querySelector('input[name="fecha"]');
  const inputPsicologoId = form.querySelector(
    'input[name="psicologo_id"]'
  ).value;
  const idPaciente = form.dataset.idPaciente;

  // Añadir un manejador de eventos al campo de fecha para validar la entrada del usuario.
  inputFecha.addEventListener("input", function () {
    // Crear un objeto Date basado en el valor del campo de fecha.
    const fechaHora = new Date(this.value);
    // Obtener el día de la semana y la hora de la fecha seleccionada.
    const diaSemana = fechaHora.getDay();
    const hora = fechaHora.getHours();

    // Limpiar errores previos antes de realizar la validación.
    clearErrors();

    // Validaciones de fecha y hora: fin de semana, horario laboral y día futuro.
    if (diaSemana == 0 || diaSemana == 6) {
      showError("fecha", "Las citas no están disponibles los fines de semana.");
      this.value = ""; // Resetea el input
    } else if (hora < 8 || hora > 17) {
      showError("fecha", "Nuestro horario laboral: 8am / 18pm");
      this.value = ""; // Resetea el input
    }

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0); // Resetear horas para comparar solo la fecha.
    if (fechaHora < hoy) {
      showError("fecha", "No puede seleccionar días pasados.");
      this.value = ""; // Resetea el input
    }

    // Verificar si la fecha seleccionada ya tiene una cita previa.
    if (this.value !== "") {
      verificarCitaPrevia(inputFecha, inputPsicologoId, idPaciente);
    }
  });

  // Añadir un manejador de eventos al formulario para validar todos los campos al intentar enviarlo.
  form.addEventListener("submit", function (event) {
    // Prevenir el envío automático del formulario.
    event.preventDefault();

    // Limpiar errores previos antes de realizar la validación.
    clearErrors();

    // Recoger valores de los campos del formulario.
    const motivoConsulta = form.querySelector(
      'input[name="motivo_consulta"]'
    ).value;
    const visita = form.querySelector('input[name="visita"]:checked');
    const terminos = form.querySelector('input[type="checkbox"]').checked;

    // Inicializar la variable de validación.
    let isValid = true;

    // Validar los campos del formulario y mostrar errores si es necesario.
    if (!inputFecha.value) {
      showError("fecha", "La fecha es obligatoria");
      isValid = false;
    }

    if (!motivoConsulta) {
      showError("motivo_consulta", "El motivo de la consulta es obligatorio");
      isValid = false;
    }

    if (!visita) {
      showError("visita", "Debe indicar si nos ha visitado antes");
      isValid = false;
    }

    if (!terminos) {
      showError("terminos", "Debe aceptar los términos y condiciones");
      isValid = false;
    }

    // Si todos los campos son válidos, permitir el envío del formulario.
    if (isValid) {
      form.submit();
    }
  });
});

// Función para verificar si ya existe una cita previa en la fecha seleccionada.
function verificarCitaPrevia(inputFecha, psicologo_id, paciente_id) {
    const fechaHora = inputFecha.value;
    const url = '../src/server/verificar-cita-previa.php' ;
    const data = {
        psicologo_id: psicologo_id,
        paciente_id: paciente_id,
        fecha: fechaHora
    };

    // Usar fetch para enviar los datos al servidor.
    fetch(url, {
        method: 'POST', // Método de solicitud.
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Tipo de contenido.
        },
        body: Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&') // Convertir el objeto de datos a una cadena de consulta.
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok'); // Lanzar un error si la respuesta no es exitosa.
        }
        return response.json(); // Convertir la respuesta a JSON.
    })
    .then(respuesta => {
        if (respuesta.yaTieneCita) {
            mostrarPopupCitaExistente(); // Muestra el pop-up personalizado
            inputFecha.value = ''; // Opcionalmente, resetea el campo de fecha
        }
    })
    .catch(error => {
        console.error('Error en la solicitud: ', error);
        showError('general', 'Ocurrió un error al verificar la cita previa. Inténtalo de nuevo más tarde.'); // Mostrar error general si falla la solicitud.
    });
}


// Función para mostrar errores específicos de los campos en el formulario.
function showError(inputName, message) {
  let input;
  // Seleccionar el campo específico para mostrar el error.
  if (inputName === "terminos") {
    input = document.querySelector('input[type="checkbox"]');
  } else if (inputName === "visita") {
    input = document.querySelector('label[for="visita"]');
  } else {
    input = document.querySelector(`input[name="${inputName}"]`);
  }

  // Control de errores: si no se encuentra el campo, mostrar un error en la consola.
  if (!input) {
    console.error("No se encontró el campo: " + inputName);
    return;
  }
  // Crear y añadir el mensaje de error al lado del campo correspondiente.
  const error = document.createElement("div");
  error.className = "error-text";
  error.textContent = message;
  if (inputName === "visita" || inputName === "terminos") {
    input.parentNode.parentNode.insertBefore(
      error,
      input.parentNode.nextSibling
    );
  } else {
    input.classList.add("error");
    input.parentNode.insertBefore(error, input.nextSibling);
  }
}

// Función para limpiar los errores mostrados previamente en el formulario.
function clearErrors() {
  // Eliminar todos los mensajes de error.
  const errors = document.querySelectorAll(".error-text");
  errors.forEach((error) => error.remove());
  // Quitar la clase de error de todos los campos de entrada.
  const inputs = document.querySelectorAll("input");
  inputs.forEach((input) => input.classList.remove("error"));
}

// Función para mostrar el pop-up personalizado
function mostrarPopupCitaExistente() {
    document.getElementById('popupCitaExistente').style.display = 'flex';
}

// Función para cerrar el pop-up
function cerrarPopup() {
    document.getElementById('popupCitaExistente').style.display = 'none';
}

