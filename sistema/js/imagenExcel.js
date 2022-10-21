function mostrarImagenExcel(event) {
    var imagenSource = event.target.result;
    var previewImageEX = document.getElementById('preview');

    previewImageEX.src = imagenSource;
}

function procesarArchivoEXCEL(event) {
    var imagenEX = event.target.files[0];

    var lector = new FileReader();

    lector.addEventListener('load', mostrarImagenExcel, false);

    lector.readAsDataURL(imagenEX);
}

document.getElementById('archivoex')
    .addEventListener('change', procesarArchivoEXCEL, false)