let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
    dom: "Bfrtilp",
    buttons: [
        {
            extend: "",
            text: '<i class="fa-solid fa-file-csv"></i>',
            titleAttr: "Exportar a Excel",
            className: "btn btn-success",
            action: function () {
                exportExcel();
            }
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
        const response = await fetch('../ADMINISTRADOR/NIVELES/datos_niveles.php');
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
function exportExcel() {
    Swal.fire({
        title: "Exportar a Excel",
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'exportar_excel.php', // Ruta a tu archivo PHP con la lógica para exportar a Excel
                type: 'GET',
                success: function(response) {
                    // Manejar la respuesta si es necesario
                    Swal.fire({
                        icon: 'success',
                        title: 'Exportación exitosa',
                        text: 'Los datos se han exportado correctamente a Excel'
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al exportar los datos a Excel'
                    });
                }
            });
        }
    });
}

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
                const grupo = $('#grupo').val();
                const profesor = $('#profesor').val();
                const nivel = $('#nivel').val();
                const periodo = $('#periodo').val();
                const modalidad = $('#modalidad').val();
                const horario = $('#horario').val();
                const cupo_min = $('#cupo_min').val();
                const cupo_max = $('#cupo_max').val();
                const aula = $('#aula').val();
                const ciclo = $('#ciclo').val();
                const turno = $('#turno').val();

                // Validar que ningún campo esté vacío
                if (!grupo || !profesor || !nivel || !periodo || !modalidad || !horario || !cupo_min || !cupo_max || !aula || !ciclo || !turno) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                }

                return { grupo, profesor, nivel, periodo, modalidad, horario, cupo_min, cupo_max, aula, ciclo, turno };
            }
        });

        if (formValues) {
            $.ajax({
                url: '../ADMINISTRADOR/NIVELES/niveles_logica.php',
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
            url: '../ADMINISTRADOR/NIVELES/datos_select.php', // Ruta a tu archivo PHP que obtiene la lista de profesores
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
            url: '../ADMINISTRADOR/NIVELES/datos_periodos.php', // Ruta a tu archivo PHP que obtiene la lista de profesores
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