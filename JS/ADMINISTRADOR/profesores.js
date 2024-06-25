let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extends: "",
      text: '<i class="fa-solid fa-user-plus"> Agregar Profesor</i>',
      titleAttr: "Agregar un nuevo Profesor",
      className: "btn btn-info",
      action: function () {
        agregarNuevoUsuario(); // Llama a la función para agregar un nuevo usuario
      },
    },
  ],
  lengthMenu: false,
  pageLength: 8,
  destroy: true,
};

const initDataTable = async () => {
  if (dataTableIsInitializated) {
    console.log("Vamos a destruit la tabla");
    dataTable.destroy();
  }
  await listprofesor();
  dataTable = $("#profesores").DataTable(dataTableOptions);
  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const response = await fetch(
      "../../ADMINISTRADOR/PROFESORES/datos_profesor.php"
    );
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((profesor) => {
      content += `
            <tr>
                <td>${profesor.id_profesor}</td>
                <td class="text-center">${profesor.nombre}</td>
                <td class="text-center">${profesor.estatus}</td>
                <td class="text-center">${profesor.edad}</td>
                <td class="text-center">${profesor.estado_civil}</td>
                <td class="text-center">${profesor.sexo}</td>
                <td class="text-center">${profesor.calle}</td>
                <td class="text-center">${profesor.rfc}</td>
                <td class="text-center">${profesor.turno}</td>
                <td class="text-center">
                    <button class="modificar btn btn-sm btn-primary" data-id="${profesor.id_profesor}" data-estatus="${profesor.estatus}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
            </tr>`;
    });

    $("#table_profesor").html(content);
  } catch (error) {}
};

window.addEventListener("load", async () => {
  await initDataTable();
});

//SweetAlert2
function agregarNuevoUsuario() {
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Nuevo Profesor",
      html:
        '<input type="email" class="swal2-input" id="correo" placeholder="Correo">' +
        '<input type="password" class="swal2-input" id="password" placeholder="Contraseña">',
      showCancelButton: true,
      preConfirm: () => {
        const correo = document.getElementById("correo").value;
        const password = document.getElementById("password").value;

        // Validación del correo electrónico
        if (!isValidEmail(correo)) {
          Swal.showValidationMessage(
            "Por favor ingresa un correo electrónico válido"
          );
          return false;
        }

        return { correo: correo, password: password };
      },
    });

    if (formValues) {
      var data = {
        correo: formValues.correo,
        password: formValues.password,
      };

      $.ajax({
        url: "../../ADMINISTRADOR/PROFESORES/guardar_datos.php",
        type: "post",
        data: data,
        success: function (response) {
          var responseData = JSON.parse(response);
          if (responseData.success) {
            Swal.fire({
              icon: "success",
              title: "Datos registrados exitosamente",
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error al procesar los datos",
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error al procesar la solicitud",
          });
        },
      });
    }
  })();

  function isValidEmail(email) {
    // Utilizando una expresión regular para validar el formato del correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
}

$(document).on("click", ".modificar", function () {
  var id = $(this).data("id");
  var estatus = $(this).data("estatus");

  Swal.fire({
    title: "Modificar Profesor",
    html: `
          <input id="swal-input2" class="swal2-input" placeholder="Estatus" value="${estatus}">
      `,
    focusConfirm: false,
    preConfirm: () => {
      const estatus = document.getElementById("swal-input2").value;
      if (!estatus) {
        Swal.showValidationMessage("El campo Estatus no puede estar vacío");
        return false;
      }
      return {
        estatus: estatus,
      };
    },
  }).then((result) => {
    if (result.isConfirmed) {
      var data = {
        id: id, // Aquí capturamos el id
        estatus: result.value.estatus,
      };
      // Ejemplo: enviar datos modificados por AJAX
      $.ajax({
        url: "actualizar.php",
        type: "POST",
        data: data,
        success: function (response) {
          Swal.fire(
            "Guardado",
            "Los datos han sido actualizados exitosamente",
            "success"
          ).then(() => {
            location.reload(); // Recargar la página para reflejar los cambios
          });
        },
        error: function (xhr, status, error) {
          Swal.fire(
            "Error",
            "Hubo un problema al actualizar los datos",
            "error"
          );
        },
      });
    }
  });
});
