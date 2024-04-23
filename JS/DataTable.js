let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
    dom: "Bfrtilp",
    buttons: [
        {
            extend: "excelHtml5",
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
    await listprofesor();
    dataTable = $('#profesores').DataTable(dataTableOptions);
    dataTableIsInitializated = true;
};

const listprofesor = async() => {
    try {
        const response = await fetch('../ADMINISTRADOR/CONTROLADORES/ver_datos_p.php');
        const profesor = await response.json();

        let content = ``;

        profesor.forEach((profesor, index) =>{
            content += `
            <tr>
                <td class="text-center">${profesor.nombres}</td>
                <td class="text-center">${profesor.estatus_profesor}</td>
                <td class="text-center">${profesor.edad}</td>
                <td class="text-center">${profesor.estado_civil}</td>
                <td class="text-center">${profesor.sexo}</td>
                <td class="text-center">${profesor.calle}</td>
                <td class="text-center">${profesor.rfc}</td>
                <td class="text-center">${profesor.modalidad}</td>
                <td class="text-center">${profesor.nivel}</td>
                <td class="text-center">${profesor.turno}</td>
                <td class="text-center">
                    <button id="editar-${index}" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
            </tr>`
        });

        $('#table_profesor').html(content);
    } catch (error) {
        
    }
}

window.addEventListener("load", async() => {
    await initDataTable();
})