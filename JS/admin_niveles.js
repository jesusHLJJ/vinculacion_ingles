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
        const response = await fetch('../ADMINISTRADOR/CONTROLADORES/datos_profesor.php');
        const profesor = await response.json();

        let content = ``;

        profesor.forEach((profesor) =>{
            content += `
            <tr id="${profesor.id_profesor}">
                <td>${profesor.id_profesor}</td>
                <td class="text-center">${profesor.nombres}</td>
                <td class="text-center">${profesor.estatus_profesor}</td>
                <td class="text-center">${profesor.edad}</td>
                <td class="text-center">${profesor.estado_civil}</td>
                <td class="text-center">${profesor.sexo}</td>
                <td class="text-center">${profesor.calle}</td>
                <td>
                    <button class="modificar btn btn-sm btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
            </tr>`
        });

        $('#table_alumno').html(content);
    } catch (error) {
        
    }
}

window.addEventListener("load", async() => {
    await initDataTable();
});

//SweetAlert2
$('#add').click(function(){
    (async() => {
        const{value:formValues} = await Swal.fire({
            title: 'Nuevos Grupos',
            html:
            '<input class="swal2-input" id="nivel" placeholder="Nivel">' +
            '<input class="swal2-input" id="grupo" placeholder="Grupo">' +
            '<input class="swal2-input" id="profesor" placeholder="Profesor">' +
            '<input class="swal2-input" id="cupo_min" placeholder="Cupo Minimo">' +
            '<input class="swal2-input" id="cupo_max" placeholder="Cupo Maximo">' +
            '<input class="swal2-input" id="modalidad" placeholder="Modalidad">' +
            '<input class="swal2-input" id="horario" placeholder="Horario">' +
            '<input class="swal2-input" id="aula" placeholder="Aula">' + 
            '<input class="swal2-input" id="ciclo" placeholder="Ciclo Escolar">',
            showCancelButton: true
        })

        if (formValues) {
            var data =
            {
                nivel: $('#nivel').val(),
                grupo: $('#grupo').val(),
                profesor: $('#profesor').val(),
                cupo_min: $('#cupo_min').val(),
                cupo_max: $('#cupo_max').val(),
                modalidad: $('#modalidad').val(),
                horario: $('#horario').val(),
                aula: $('#aula').val(),
                ciclo: $('#ciclo').val()
            };

            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/niveles_logica.php',
                type: 'post',
                data: data,
                success: function(){
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos registrados exitosamente'
                    })
                }
            })
        }
    }) ()
});

function agregarNuevoUsuario() {
    (async () => {
        const { value: formValues } = await Swal.fire({
            title: 'Nuevo Grupo',
            html:
            '<input class="swal2-input" id="nivel" placeholder="Nivel">' +
            '<input class="swal2-input" id="grupo" placeholder="Grupo">' +
            '<input class="swal2-input" id="profesor" placeholder="Profesor">' +
            '<input class="swal2-input" id="cupo_max" placeholder="Cupo Maximo">' +
            '<input class="swal2-input" id="modalidad" placeholder="Modalidad">' +
            '<input class="swal2-input" id="horario" placeholder="Horario">',
            showCancelButton: true
        })

        if (formValues) {
            var data = {
                nombre: $('#nivel').val(),
                correo: $('#grupo').val(),
                password: $('#profesor').val(),
                password: $('#cupo_max').val(),
                password: $('#modalidad').val(),
                password: $('#horario').val()
            };

            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/profesores_logica.php',
                type: 'post',
                data: data,
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos registrados exitosamente'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
        }
    })()
};