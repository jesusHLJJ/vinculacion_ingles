$(document).ready(function() {
    $('#example').DataTable({
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