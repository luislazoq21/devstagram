import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const imagenInput = document.querySelector('[name="imagen"]');

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: '.png,.jpg,.jpeg,.gif,.webp',
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function() {
        if( imagenInput.value.trim() ) {
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = imagenInput.value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    },
});

dropzone.on('success', function(file, response) {
    imagenInput.value = response.imagen;
    // console.log(imagenInput.value);
});

dropzone.on('removedfile', function() {
    imagenInput.value = '';
});
