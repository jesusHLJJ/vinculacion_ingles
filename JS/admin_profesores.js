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
    dataTable = $('#profesores').DataTable(dataTableOptions);
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
                <td class="text-center">${profesor.rfc}</td>
                <td class="text-center">${profesor.modalidad}</td>
                <td class="text-center">${profesor.nivel}</td>
                <td class="text-center">${profesor.turno}</td>
                <td>
                    <button class="modificar btn btn-sm btn-primary">
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
            title: 'Nuevo Profesor',
            html:
                '<input type="text" class="swal2-input" id="nombre" placeholder="Nombre">' +
                '<input type="email" class="swal2-input" id="correo" placeholder="Correo">' +
                '<input type="password" class="swal2-input" id="password" placeholder="Contraseña">',
            showCancelButton: true,
            preConfirm: () => {
                const nombre = document.getElementById('nombre').value;
                const correo = document.getElementById('correo').value;
                const password = document.getElementById('password').value;
    
                // Validación del correo electrónico
                if (!isValidEmail(correo)) {
                    Swal.showValidationMessage('Por favor ingresa un correo electrónico válido');
                    return false;
                }
    
                return { nombre: nombre, correo: correo, password: password };
            }
        })
    
        if (formValues) {
            var data = {
                nombre: formValues.nombre,
                correo: formValues.correo,
                password: formValues.password
            };
    
            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/profesores_logica.php',
                type: 'post',
                data: data,
                success: function (response) {
                    var responseData = JSON.parse(response);
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
                            title: 'Error al procesar los datos'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al procesar la solicitud'
                    });
                }
            })
        }
    })();
    
    function isValidEmail(email) {
        // Utilizando una expresión regular para validar el formato del correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
};