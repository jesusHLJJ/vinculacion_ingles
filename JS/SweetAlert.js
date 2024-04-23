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

$('#agregar').click(function(){
    (async() => {
        const{value:formValues} = await Swal.fire({
            title: 'Nuevo Registro',
            html:
            '<input class="swal2-input" id="nombre" placeholder="Nombre">' +
            '<input class="swal2-input" id="correo" placeholder="Correo">' +
            '<input class="swal2-input" id="password" placeholder="Contraseña">',
            showCancelButton: true
        })

        if (formValues) {
            var data=
            {
                nombre: $('#nombre').val(),
                correo: $('#correo').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/profesores_logica.php',
                type: 'post',
                data: data,
                success: function(){
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos registrados exitosamente'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
        }
    }) ()
});

$('[id^=editar]').click(function(){
    (async() => {
        const{value:formValues} = await Swal.fire({
            title: 'Nuevo Registro',
            html:
            '<input class="swal2-input" id="estatus" placeholder="estatus">',
            showCancelButton: true
        })

        if (formValues) {
            var data=
            {
                estatus: $('#estatus').val()
            };

            $.ajax({
                url: '../ADMINISTRADOR/CONTROLADORES/profesores_logica.php',
                type: 'post',
                data: data,
                success: function(){
                    Swal.fire({
                        icon: 'success',
                        title: 'Estatus actualizado exitosamente'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
        }
    }) ()
})