const $ = require('jquery');

$('.custom-file-input').on('change', (event) => {
    const inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});
