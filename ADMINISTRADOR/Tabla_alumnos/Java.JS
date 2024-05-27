let dataTable;
let dataTableIsInitializated = false;

$(document).ready(function() {
    $('#alumnos').DataTable({
        "columns": [
            {"data": "MATRICULA"},
            {"data": "NOMBRES"},
            {"data": "AP. PATERNO"},
            {"data": "AP. MATERNO"},
            {"data": "CARRERA"},
            {"data": "TELEFONO"},
            {"data": "SEXO"},
            {"data": "NIVEL"},
            {"data": "ESTATUS"},
            {"data": "USUARIOS"}
        ]
    });
});

const dataTableOptions = {
    dom: "Bfrtilp",
    buttons: [
        {
            extends: "excelHtml5",
            text: '<i class="fa-solid fa-file-csv"></i>',
            titleAttr: "Exportar a Excel",
            className: "btn btn-success",
        }
    ],
    lengthMenu: [10, 50, 100],
    pageLength: 10,
    destroy: true
};

const initDataTable = async() => {
    if (dataTableIsInitializated) {
        console.log('Vamos a destruit la tabla');
        dataTable.destroy();
    }
    await listalumno();
    dataTable = $('#alumnos').DataTable(dataTableOptions);
    dataTableIsInitializated = true;
};

const listalumno = async() => {
    try {
        const response = await fetch('');
        const alumno = await response.json();

        let content = ``;

        alumno.forEach((alumno, index) =>{
            content += `
            <tr>
                <td class="text-center">${alumno.matricula}</td>
                <td class="text-center">${alumno.nombres}</td>
                <td class="text-center">${alumno.apellido_paterno}</td>
                <td class="text-center">${alumno.apellido_materno}</td>
                <td class="text-center">${alumno.carrera}</td>
                <td class="text-center">${alumno.telefono}</td>
                <td class="text-center">${alumno.sexo}</td>
                <td class="text-center">${alumno.nivel}</td>
                <td class="text-center">${alumno.estatus}</td>
                <td class="text-center">${alumno.usuarios}</td>
                <td class="text-center">
                </td>
            </tr>`
        });

        $('#table_alumnos').html(content);
    } catch (error) {
        
    }
}

window.addEventListener("load", async() => {
    await initDataTable();
})
