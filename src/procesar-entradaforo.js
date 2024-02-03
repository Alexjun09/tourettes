document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-foro');

    form.addEventListener('submit', function (e) {
        const title = form.querySelector('[name="title"]').value;
        const palabrasclave = form.querySelector('[name="palabrasclave"]').value;
        const cuerpo = form.querySelector('[name="cuerpo"]').value;
        const archivo = form.querySelector('[name="archivo"]').value;
        const terminos = form.querySelector('[name="terminos"]').checked;

        // Realiza tus validaciones aquí
        const errores = [];

        if (title.trim() === '') {
            errores.push('El campo "Título" no puede estar vacío.');
        }

        if (palabrasclave.trim() === '') {
            errores.push('El campo "Palabras Clave" no puede estar vacío.');
        }

        if (cuerpo.trim() === '') {
            errores.push('El campo "Cuerpo" no puede estar vacío.');
        }

        if (!terminos) {
            errores.push('Debes aceptar los términos y condiciones.');
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
