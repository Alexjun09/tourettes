document.getElementById('bannerInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var errorElement = document.getElementById('uploadError');

    // Limpiar errores previos
    errorElement.textContent = '';

    // Validar el tipo de archivo
    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
        errorElement.textContent = 'Solo se admite archivos .jpg o .png';
        return;
    }

    // Preparar FormData
    var formData = new FormData();
    formData.append('banner', file);

    // Realizar la petición fetch para subir el archivo
    fetch('../server/procesar_EditarPerfil.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())  // Asegúrate de que tu PHP devuelve una respuesta JSON
    .then(data => {
        if(data.bannerPath) {
            // Actualiza la imagen del banner con la nueva ruta
            document.getElementById('profileBanner').src = data.bannerPath;
        } else if(data.error) {
            errorElement.textContent = data.error;
        }
    })
    .catch(error => {
        errorElement.textContent = 'Error al subir el archivo.';
        console.error(error);
    });
});
