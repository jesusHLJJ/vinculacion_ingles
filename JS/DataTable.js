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

$(alumnos).ready(function() {
    $('#alumnos').DataTable({
        "columns": [
            {"data": "MATRICULA"},
            {"data": "NOMBRES"},
            {"data": "AP. PATERNO"},
            {"data": "AP. MATERNO"},
            {"data": "EDAD"},
            {"data": "NIVEL"},
            {"data": "SEXO"},
            {"data": "CORREO"},
            {"data": "TEL.MOVIL"},
            {"data": "CARRERA"},
            {"data": "GRUPO"},
            {"data": "TURNO"},
            {"data": "LINEA CAP."},
            {"data": "DOCUMENTOS"},
            {"defaultContent": "<button class='btn btn-modificar'>Modificar</button>"}
        ]
    });
});