document.addEventListener('DOMContentLoaded', (event) => {
    const form = document.getElementById('form-cita');

    form.addEventListener('submit', function (e) {
        let errores = [];

        const fechaCita = document.getElementsByName('fecha')[0].value;
        const motivoConsulta = document.getElementsByName('motivo_consulta')[0].value;
        
        // Validar la fecha de la cita
        if (new Date(fechaCita) < new Date()) {
            errores.push("La fecha de la cita no es válida o ya ha pasado.");
        }

        // Validar el motivo de la consulta
        if (!motivoConsulta.trim()) {
            errores.push("El motivo de la consulta no puede estar vacío.");
        }

        // Mostrar errores o detener el envío del formulario
        if (errores.length > 0) {
            e.preventDefault(); // Detener el envío del formulario
            const divErrores = document.getElementById('div-errores');
            divErrores.innerHTML = errores.join('<br>');
        }
    });
});
