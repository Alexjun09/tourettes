document.addEventListener('DOMContentLoaded', function () {
    // Crear un elemento de estilo y agregar reglas CSS para mostrar errores.
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

    // Añadir el elemento de estilo al <head> del documento.
    document.head.appendChild(style);

    const form = document.querySelector('#form-cita');
    const inputFecha = form.querySelector('input[name="fecha"]');
    const inputPsicologoId = form.querySelector('input[name="psicologo_id"]').value;
    const idPaciente= form.dataset.idPaciente;

    inputFecha.addEventListener('input', function () {
        // Validar que la fecha y hora sean durante la semana laboral y en el futuro.
        const fechaHora = new Date(this.value);
        const diaSemana = fechaHora.getDay();
        const hora = fechaHora.getHours();

        // Limpiar errores previos
        clearErrors();

        // Verificar que no sea fin de semana
        if (diaSemana == 0 || diaSemana == 6) {
            showError('fecha', 'Las citas no están disponibles los fines de semana.');
            this.value = ''; // Resetea el input
        }

        // Verificar que la hora sea entre las 8 am y las 6 pm
        else if (hora < 8 || hora > 17) {
            showError('fecha', 'Nuestro horario laboral: 8am / 18pm');
            this.value = ''; // Resetea el input
        }

        // Verificar que la fecha no sea un día pasado
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0); // Resetear horas para comparar solo fecha
        if (fechaHora < hoy) {
            showError('fecha', 'No puede seleccionar días pasados.');
            this.value = ''; // Resetea el input
        }

        if (this.value !== '') {
            verificarCitaPrevia(inputFecha, inputPsicologoId, idPaciente);
        }

    });

    form.addEventListener('submit', function (event) {
        // Prevenir el envío automático del formulario.
        event.preventDefault();

        // Recoger valores de los campos del formulario.
        const motivoConsulta = form.querySelector('input[name="motivo_consulta"]').value;
        const visita = form.querySelector('input[name="visita"]:checked');
        const terminos = form.querySelector('input[type="checkbox"]').checked;

        // Inicializar la validación como verdadera.
        let isValid = true;

        // Validar cada campo y mostrar errores si es necesario.        
        if (!inputFecha.value) {
            showError('fecha', 'La fecha es obligatoria');
            isValid = false;
        }

        if (!motivoConsulta) {
            showError('motivo_consulta', 'El motivo de la consulta es obligatorio');
            isValid = false;
        }

        if (!visita) {
            showError('visita', 'Debe indicar si nos ha visitado antes');
            isValid = false;
        }

        if (!terminos) {
            showError('terminos', 'Debe aceptar los términos y condiciones');
            isValid = false;
        }

        // Si todos los campos son válidos, enviar el formulario.
        if (isValid) {
            form.submit();
        }
    });
});

function verificarCitaPrevia(inputFecha, psicologo_id, paciente_id) {
    const fechaHora = inputFecha.value;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../server/verificar-cita-previa.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.yaTieneCita) {
                showError('fecha', 'Ya tiene una cita programada con este psicólogo.');
                inputFecha.value = ''; // Resetea el input
            }
        }
    };
    xhr.send('psicologo_id=' + encodeURIComponent(psicologo_id) + '&paciente_id=' + encodeURIComponent(paciente_id) + '&fecha=' + encodeURIComponent(fechaHora));
}

// Función para mostrar errores específicos de los campos.
function showError(inputName, message) {
    let input;
    // Seleccionar el campo o etiqueta específica para mostrar el error.
    if (inputName === 'terminos') {
        input = document.querySelector('input[type="checkbox"]');
    } else if (inputName === 'visita') {
        input = document.querySelector('label[for="visita"]');
    } else {
        input = document.querySelector(`input[name="${inputName}"]`);
    }

    // Si no se encuentra el campo, mostrar error en la consola (control de errores)
    if (!input) {
        console.error('No se encontró el campo: ' + inputName);
        return;
    }
    // Crear y añadir el mensaje de error al DOM.
    const error = document.createElement('div');
    error.className = 'error-text';
    error.textContent = message;

    // Posicionar el mensaje de error en el formulario.
    if (inputName === 'visita' || inputName === 'terminos') {
        input.parentNode.parentNode.insertBefore(error, input.parentNode.nextSibling);
    } else {
        input.classList.add('error');
        input.parentNode.insertBefore(error, input.nextSibling);
    }
}

// Función para limpiar todos los errores mostrados anteriormente.
function clearErrors() {
        // Eliminar todos los mensajes de error.
    const errors = document.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());
    // Quitar la clase de error de todos los campos de entrada.
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('error'));
}
