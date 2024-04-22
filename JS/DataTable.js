$(document).ready(function() {
    $('#niveles').DataTable({
        "columns": [
            {"data": "NIVEL"},
            {"data": "GRUPO"},
            {"data": "PROFESOR"},
            {"data": "CUPO MAXIMO"},
            {"data": "MODALIDAD"},
            {"data": "HORARIO"},
            {"defaultContent": "<button class='btn btn-modificar'>Modificar</button>"}
        ]
    });
});

$(document).ready(function() {
    $('#profesores').DataTable({
        "columns": [
            {"data": "NOMBRE"},
            {"data": "EDAD"},
            {"data": "ESTADO CIVIL"},
            {"data": "SEXO"},
            {"data": "DEMICILIO"},
            {"data": "RFC"},
            {"data": "PERIODO"},
            {"data": "MODALIDAD"},
            {"data": "NIVEL"},
            {"data": "TURNO"},
            {"defaultContent": "<button class='btn btn-modificar'>Modificar</button>"}
        ]
    });
});