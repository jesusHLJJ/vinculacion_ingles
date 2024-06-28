let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
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
  dataTable = $("#credenciales").DataTable(dataTableOptions);

  // Filtro personalizado por tipo de usuario
  $('#tipoUsuario').on('change', function() {
    var filterValue = $(this).val();
    dataTable.column(3).search(filterValue).draw();
  });

  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const response = await fetch("../../ADMINISTRADOR/CONTROL_CREDENCIALES/obtener_datos.php");
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((grupos) => {
      content += `
                <tr>
                    <td class="text-center">${grupos.nombre}</td>
                    <td class="text-center">${grupos.ap_paterno}</td>
                    <td class="text-center">${grupos.ap_materno}</td>
                    <td class="text-center">${grupos.tipo_usuario}</td>
                    <td class="text-center">${grupos.correo}</td>
                    <td class="text-center">
                        <button class="modificar btn btn-sm btn-primary" data-correo="${grupos.correo}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>`;
    });

    $("#table_credenciales").html(content);
  } catch (error) {
    console.error("Error:", error);
  }
};

window.addEventListener("load", async () => {
  await initDataTable();
});

$(document).on("click", ".modificar", async function () {
  var correo = $(this).data("correo");

  console.log(correo);

  try {
    const result = await Swal.fire({
      title: "Cambiar Contraseña",
      html:
        `<input id="swal-input-pass" class="swal2-input" placeholder="Contraseña Nueva">`,
      focusConfirm: false,
      preConfirm: () => {
        const pass = document.getElementById("swal-input-pass").value;

        if (!pass) {
          Swal.showValidationMessage("Campo obligatorio, favor de llenar");
          return false;
        }

        return {
          new_pass: pass,
          correo: correo,
        };
      },
    });


    if (result.isConfirmed) {
      var data = result.value;

      // Ejemplo: enviar datos modificados por AJAX
      const response = await $.ajax({
        url: "../../ADMINISTRADOR/CONTROL_CREDENCIALES/cambiar_contraseña.php",
        type: "POST",
        data: data,
      });

      await Swal.fire(
        "Guardado",
        "Contraseña actualizada exitosamente",
        "success"
      );
      
      location.reload(); // Recargar la página para reflejar los cambios
    }
  } catch (error) {
    console.error("Error:", error);
    await Swal.fire(
      "Error",
      "Hubo un problema al actualizar la contraseña",
      "error"
    );
  }
});
