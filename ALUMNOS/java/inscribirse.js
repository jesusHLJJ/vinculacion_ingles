document.getElementById('soli_aspirante').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});

document.getElementById('lin_captura_d').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label1');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});

document.getElementById('comp_pago').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label2');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});

document.getElementById('ine').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label3');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});

document.getElementById('act_nacimiento').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label4');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});

document.getElementById('comp_estudios').addEventListener('change', function() {
    var fileInput = this;
    var fileLabel = document.getElementById('file-label5');

    if (fileInput.files.length > 0) {
        fileLabel.classList.add('file-selected');
    } else {
        fileLabel.classList.remove('file-selected');
    }
});