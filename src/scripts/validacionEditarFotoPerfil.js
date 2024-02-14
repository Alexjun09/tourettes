document.getElementById('ProfileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var errorElement = document.getElementById('uploadErrorProfile');

    // Limpiar errores previos 
    errorElement.textContent = '';

    // Validar el tipo de archivo
    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
        errorElement.textContent = 'Solo se admite archivos .jpg o .png';
        return;
    }

    // Preparar FormData
    var formData = new FormData();
    formData.append('profile', file);

    // Realizar la petición fetch para subir el archivo
    fetch('./server/procesar_EditarFotoPerfil.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())  // Asegúrate de que tu PHP devuelve una respuesta JSON
    .then(data => {
        if(data.bannerPath) {
            // Actualiza la imagen del banner con la nueva ruta
            document.getElementById('ProfileInput').src = data.bannerPath;
            window.location.reload();
        } else if(data.error) {
            errorElement.textContent = data.error;
        }
    })
    .catch(error => {
        errorElement.textContent = 'Error al subir el archivo.';
        console.error(error);
    });
});
