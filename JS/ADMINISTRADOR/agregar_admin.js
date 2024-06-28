let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extend: "",
      text: '<i class="fa-solid fa-user-plus"> Agregar cuenta</i>',
      titleAttr: "Agregar Cuenta de Administrador",
      className: "btn btn-success",
      action: function () {
        agregarNuevoUsuario(); // Llama a la función para agregar un nuevo usuario
      },
    },
  ],
  lengthMenu: false,
  pageLength: 5,
  destroy: true,
};

const initDataTable = async () => {
  if (dataTableIsInitializated) {
    console.log("Vamos a destruir la tabla");
    dataTable.destroy();
  }
  await listprofesor();
  dataTable = $("#administrador").DataTable(dataTableOptions);
  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const response = await fetch(
      "../../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/obtener_datos.php"
    );
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((datos) => {
      content += `
                <tr>
                    <td class="text-center">${datos.id_admin}</td>
                    <td class="text-center">${datos.nombre}</td>
                    <td class="text-center">${datos.ap_paterno}</td>
                    <td class="text-center">${datos.ap_materno}</td>
                    <td class="text-center">${datos.correo}</td>
                    <td class="text-center">
                        <button class="modificar btn btn-sm btn-primary" data-matricula="${datos.id_admin}" data-nombre="${datos.nombre}" data-paterno="${datos.ap_paterno}" data-materno="${datos.ap_materno}" data-correo="${datos.correo}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button class="eliminar btn btn-sm btn-danger" data-matricula="${datos.correo}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
    });

    $("#table_administrador").html(content);

    if (profesor.length === 1) {
      $(".eliminar").prop("disabled", true);
    }
  } catch (error) {}
};

window.addEventListener("load", async () => {
  await initDataTable();
});

//SweetAlert2
function agregarNuevoUsuario() {
  (async () => {
    const { value: formValues } = await Swal.fire({
      title: "Nuevo administrador",
      html:
        '<input type="text" class="swal2-input" id="nombre" placeholder="Nombre">' +
        '<input type="text" class="swal2-input" id="paterno" placeholder="Apellido Paterno">' +
        '<input type="text" class="swal2-input" id="materno" placeholder="Apellido Materno">' +
        '<input type="email" class="swal2-input" id="correo" placeholder="Correo">' +
        '<input type="password" class="swal2-input" id="password" placeholder="Contraseña">',
      showCancelButton: true,
      preConfirm: () => {
        const nombre = document.getElementById("nombre").value;
        const paterno = document.getElementById("paterno").value;
        const materno = document.getElementById("materno").value;
        const correo = document.getElementById("correo").value;
        const password = document.getElementById("password").value;

        // Validación del correo electrónico
        if (!isValidEmail(correo)) {
          Swal.showValidationMessage(
            "Por favor ingresa un correo electrónico válido"
          );
          return false;
        }

        return {
          nombre: nombre,
          paterno: paterno,
          materno: materno,
          correo: correo,
          password: password,
        };
      },
    });

    if (formValues) {
      var data = {
        nombre: formValues.nombre,
        paterno: formValues.paterno,
        materno: formValues.materno,
        correo: formValues.correo,
        password: formValues.password,
      };

      $.ajax({
        url: "../../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/agregar_datos.php",
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

$(document).on("click", ".modificar", async function () {
  var id = $(this).data("matricula");
  var nombre = $(this).data("nombre");
  var paterno = $(this).data("paterno");
  var materno = $(this).data("materno");
  var correo_viejo = $(this).data("correo");

  try {
    const result = await Swal.fire({
      title: "Modificar Cuenta",
      html:
        `<input id="swal-input-nombre" class="swal2-input" placeholder="Nombre" value="${nombre}">` +
        `<input id="swal-input-paterno" class="swal2-input" placeholder="Apellido Paterno" value="${paterno}">` +
        `<input id="swal-input-materno" class="swal2-input" placeholder="Apellido Materno" value="${materno}">` +
        `<input id="swal-input-correo" class="swal2-input" placeholder="Correo" value="${correo_viejo}">`,
      focusConfirm: false,
      preConfirm: () => {
        const nombre = document.getElementById("swal-input-nombre").value;
        const paterno = document.getElementById("swal-input-paterno").value;
        const materno = document.getElementById("swal-input-materno").value;
        const correo_nuevo = document.getElementById("swal-input-correo").value;

        // Función para validar el formato del correo electrónico
        function isValidEmail(email) {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          return emailRegex.test(email);
        }

        // Verificación de campos obligatorios
        if (!nombre || !paterno || !materno || !correo_nuevo) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }

        // Validación del correo electrónico
        if (!isValidEmail(correo_nuevo)) {
          Swal.showValidationMessage(
            "Por favor ingresa un correo electrónico válido"
          );
          return false;
        }

        return {
          id: id,
          nombre: nombre,
          paterno: paterno,
          materno: materno,
          correo_viejo: correo_viejo,
          correo_nuevo: correo_nuevo,
        };
      },
    });

    if (result.isConfirmed) {
      var data = result.value;

      // Enviar datos modificados por AJAX
      const response = await $.ajax({
        url: "../../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/actualizar_datos.php",
        type: "POST",
        data: data,
      });

      await Swal.fire(
        "Guardado",
        "Los datos han sido actualizados exitosamente",
        "success"
      );

      location.reload(); // Recargar la página para reflejar los cambios
    }
  } catch (error) {
    console.error("Error:", error);
    await Swal.fire(
      "Error",
      "Hubo un problema al actualizar los datos",
      "error"
    );
  }
});

$(document).on("click", ".eliminar", async function () {
  var correo = $(this).data("matricula");

  try {
    const result = await Swal.fire({
      icon: "warning",
      title: "¿Desea eliminar esta Cuenta?",
      text: "Esta acción no se puede deshacer",
      showCancelButton: true,
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
    });

    if (result.isConfirmed) {
      // Enviar el id al archivo PHP
      const response = await fetch(
        "../../ADMINISTRADOR/AGREGAR_ADMINISTRADOR/eliminar_admin.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ correo: correo }),
        }
      );

      const data = await response.json();

      if (data.success) {
        await Swal.fire(
          "Eliminado",
          "La cuenta ha sido eliminada exitosamente",
          "success"
        );
        // Opcional: refrescar la página o eliminar el elemento de la tabla
        location.reload();
      } else {
        await Swal.fire("Error", "No se pudo eliminar la cuenta", "error");
      }
    }
  } catch (error) {
    console.error("Error:", error);
    await Swal.fire(
      "Error",
      "Hubo un problema al procesar la solicitud",
      "error"
    );
  }
});
