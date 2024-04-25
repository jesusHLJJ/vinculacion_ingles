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
        },
        {
            extends: "",
            text: '<i class="fa-solid fa-user-plus"></i>',
            titleAttr: "Agregar un nuevo Usuario",
            className: "btn btn-info",
            action: function () {
                agregarNuevoUsuario(); // Llama a la función para agregar un nuevo usuario
            }
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
    dataTable = $('#niveles').DataTable(dataTableOptions);
    dataTableIsInitializated = true;
};

const listprofesor = async() => {
    try {
        const response = await fetch('../ADMINISTRADOR/CONTROLADORES/datos_niveles.php');
        const profesor = await response.json();

        let content = ``;

        profesor.forEach((niveles) =>{
            content += `
            <tr id="${niveles.id_grupo}">
                <td class="text-center">${niveles.id_grupo}</td>
                <td class="text-center">${niveles.nivel}</td>
                <td class="text-center">${niveles.nombre_grupo}</td>
                <td class="text-center">${niveles.nombres}</td>
                <td class="text-center">${niveles.cupo_maximo}</td>
                <td class="text-center">${niveles.modalidad}</td>
                <td class="text-center">${niveles.turno}</td>
                <td class="text-center">${niveles.horario}</td>
                <td class="text-center">
                    <button class="modificar btn btn-sm btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
            </tr>`
        });

        $('#table_niveles').html(content);
    } catch (error) {
        
    }
}

window.addEventListener("load", async() => {
    await initDataTable();
});

//SweetAlert2
function agregarNuevoUsuario() {
    (async () => {
        // Obtener la lista de profesores de la base de datos
        const profesores = await obtenerProfesores();

        // Construir las opciones para el select de profesores
        let options = '';
        profesores.forEach(profesor => {
            options += `<option value="${profesor.id_profesor}">${profesor.nombres}</option>`;
        });

        // Obtener la lista de profesores de la base de datos
        const periodos = await obtenerPeriodo();

        // Construir las opciones para el select de profesores
        let options1 = '';
        periodos.forEach(periodo => {
            options1 += `<option value="${periodo.id_periodo}">${periodo.periodo}</option>`;
        });

        const { value: formValues } = await Swal.fire({
            title: 'Nuevo Grupo',
            html:
                '<input class="swal2-input" id="grupo" placeholder="Grupo">' +
                `<select class="swal2-select" id="profesor">${options}</select>` +
                '<input class="swal2-input" id="nivel" placeholder="Nivel">' +
                `<select class="swal2-select" id="periodo">${options1}</select>` +
                '<input class="swal2-input" id="modalidad" placeholder="Modalidad">' +
                '<input class="swal2-input" id="horario" placeholder="Horario">' +
                '<input class="swal2-input" id="cupo_min" placeholder="Cupo Minimo">' +
                '<input class="swal2-input" id="cupo_max" placeholder="Cupo Maximo">' +
                '<input class="swal2-input" id="aula" placeholder="Aula">' +
                '<input class="swal2-input" id="ciclo" placeholder="Ciclo Escolar">' +
                '<input class="swal2-input" id="turno" placeholder="Turno">',
            showCancelButton: true,
            preConfirm: () => {
                return {
                    grupo: $('#grupo').val(),
                    profesor: $('#profesor').val(),
                    nivel: $('#nivel').val(),
                    periodo: $('#periodo').val(),
                    modalidad: $('#modalidad').val(),
                    horario: $('#horario').val(),
                    cupo_min: $('#cupo_min').val(),
                    cupo_max: $('#cupo_max').val(),
                    aula: $('#aula').val(),
                    ciclo: $('#ciclo').val(),
                    turno: $('#turno').val()
                };
            }
        });

        if (formValues) {
            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/niveles_logica.php',
                type: 'post',
                data: formValues,
                success: function (response) {
                    const responseData = JSON.parse(response);
                    if (responseData.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos registrados exitosamente'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al registrar los datos'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud'
                    });
                }
            });
        }
    })();
};

// Función para obtener la lista de profesores
function obtenerProfesores() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../ADMINISTRADOR/CONTROLADORES/datos_select.php', // Ruta a tu archivo PHP que obtiene la lista de profesores
            type: 'GET',
            success: function (response) {
                resolve(JSON.parse(response));
            },
            error: function () {
                reject('Error al obtener la lista de profesores');
            }
        });
    });
};

function obtenerPeriodo() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../ADMINISTRADOR/CONTROLADORES/datos_periodos.php', // Ruta a tu archivo PHP que obtiene la lista de profesores
            type: 'GET',
            success: function (response) {
                resolve(JSON.parse(response));
            },
            error: function () {
                reject('Error al obtener la lista de profesores');
            }
        });
    });
}