let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extend: "",
      text: '<i class="fa-solid fa-file-circle-plus"> SUBIR DOCUMENTOS</i>',
      titleAttr: "Agregar un nuevo Nivel",
      className: "btn btn-info",
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
    console.log("Vamos a destruit la tabla");
    dataTable.destroy();
  }
  await listprofesor();
  dataTable = $("#grupos").DataTable(dataTableOptions);
  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const extractFileName = (filePath) => {
      return filePath ? filePath.split("/").pop() : "N/A";
    };

    const createDownloadLink = (filePath) => {
      const fileName = extractFileName(filePath);
      return filePath
        ? `<a href="${filePath}" download>${fileName}</a>`
        : "N/A";
    };

    const response = await fetch(
      "../../ADMINISTRADOR/PLANEACION_Y_AVANCE/documentos.php"
    );
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((planeacion) => {
      content += `
        <tr>
          <td class="text-center">${planeacion.id_documento}</td>
          <td class="text-center">${planeacion.grupo}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.planeacion_estrategica
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avance_programatico_1
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avance_programatico_2
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avance_programatico_3
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.planeacion_profesor
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avace_profesor_1
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avace_profesor_2
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.avace_profesor_3
          )}</td>
          <td class="text-center">
            <button class="modificar btn btn-sm btn-primary" data-id="${planeacion.id_documento}">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
          </td>
        </tr>`;
    });

    $("#table_grupos").html(content);
  } catch (error) {}
};

window.addEventListener("load", async () => {
  await initDataTable();
});

//SweetAlert2
function agregarNuevoUsuario() {
  (async () => {
    const nivel_grupos = await obtenerNivel();

    let niveles = "";
    nivel_grupos.forEach((niveles_g) => {
      niveles += `<option value="${niveles_g.id_nivel}">${niveles_g.nivel} - ${niveles_g.grupo}</option>`;
    });

    const { value: formValues } = await Swal.fire({
      title: "Documentos por Grupo",
      html:
        `<select class="swal2-select" id="nivel" style="width: 265px;">${niveles}</select>` +
        `<label for="planeacion" style="color: black;">Planeación Estratégica</label>` +
        `<input type="file" id="planeacion" class="swal2-file" accept=".pdf, .docx">` +
        `<label for="avance1" style="color: black;">Avance Programático 1</label>` +
        `<input type="file" id="avance1" class="swal2-file" accept=".pdf, .docx">`,
      showCancelButton: true,
      preConfirm: () => {
        const nivel = document.getElementById("nivel").value;
        const planeacion = document.getElementById("planeacion").files[0];
        const avance1 = document.getElementById("avance1").files[0];

        // Validar que ningún campo esté vacío
        if (!nivel || !planeacion || !avance1) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false; // Agrega esta línea para asegurarte de que la validación funcione correctamente
        }

        return {
          nivel,
          planeacion,
          avance1,
        };
      },
    });

    if (formValues) {
      const formData = new FormData();
      formData.append("nivel", formValues.nivel);
      formData.append("planeacion", formValues.planeacion);
      formData.append("avance1", formValues.avance1);

      $.ajax({
        url: "../../ADMINISTRADOR/PLANEACION_Y_AVANCE/guardar_datos.php",
        type: "post",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
          const responseData = JSON.parse(response);
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
              title: "Error",
              text:
                responseData.message ||
                "Ocurrió un error al registrar los datos",
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error al procesar la solicitud",
          });
        },
      });
    }
  })();
}

$(document).on("click", ".modificar", async function () {
  var id = $(this).data("id");

  const nivel_grupos = await obtenerNivel();

  let niveles = "";
  nivel_grupos.forEach((niveles_g) => {
    niveles += `<option value="${niveles_g.id_nivel}">${niveles_g.nivel} - ${niveles_g.grupo}</option>`;
  });

  try {
    const result = await Swal.fire({
      title: "Modificar Documentos",
      html: `
        <select class="swal2-select" id="nivel" style="width: 265px;">${niveles}</select>
        <label for="planeacion" style="color: black;">Planeación Estratégica</label>
        <input type="file" id="planeacion" class="swal2-file" accept=".pdf, .docx">
        <label for="avance1" style="color: black;">Avance Programático 1</label> 
        <input type="file" id="avance1" class="swal2-file" accept=".pdf, .docx">
        <label for="avance2" style="color: black;">Avance Programático 2</label> 
        <input type="file" id="avance2" class="swal2-file" accept=".pdf, .docx">
        <label for="avance3" style="color: black;">Avance Programático 3</label> 
        <input type="file" id="avance3" class="swal2-file" accept=".pdf, .docx">
      `,
      focusConfirm: false,
      preConfirm: () => {
        const nivel = document.getElementById("nivel").value;
        const planeacion = document.getElementById("planeacion").files[0];
        const avance1 = document.getElementById("avance1").files[0];
        const avance2 = document.getElementById("avance2").files[0];
        const avance3 = document.getElementById("avance3").files[0];

        return {
          id,
          nivel,
          planeacion,
          avance1,
          avance2,
          avance3,
        };
      },
    });

    if (result.isConfirmed) {
      const formValues = result.value;
      const formData = new FormData();
      formData.append("id", formValues.id);
      formData.append("nivel", formValues.nivel);

      if (formValues.planeacion) {
        formData.append("planeacion", formValues.planeacion);
      }
      if (formValues.avance1) {
        formData.append("avance1", formValues.avance1);
      }
      if (formValues.avance2) {
        formData.append("avance2", formValues.avance2);
      }
      if (formValues.avance3) {
        formData.append("avance3", formValues.avance3);
      }

      const response = await $.ajax({
        url: "../../ADMINISTRADOR/PLANEACION_Y_AVANCE/actualizar.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
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

function obtenerNivel() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/PLANEACION_Y_AVANCE/niveles.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
      type: "GET",
      success: function (response) {
        resolve(JSON.parse(response));
      },
      error: function () {
        reject("Error al obtener la lista de estatus");
      },
    });
  });
}
