// Archivo: validacion-respuesta-foro.js

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        const cuerpo = form.querySelector('[name="cuerpo"]').value;
        const archivo = form.querySelector('[name="archivo"]').value;

        // Realiza tus validaciones aquí
        const errores = [];

        if (cuerpo.trim() === '') {
            errores.push('El campo "Cuerpo" no puede estar vacío.');
        }

        // Validación de archivo (puedes agregar más validaciones si es necesario)
        if (archivo.trim() === '') {
            errores.push('Debes seleccionar un archivo.');
        }

        if (errores.length > 0) {
            e.preventDefault(); // Detener el envío del formulario

            // Mostrar errores al usuario (puedes hacerlo como prefieras)
            alert(errores.join('\n'));
        }
    });
});
