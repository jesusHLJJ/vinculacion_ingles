let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extend: "",
      text: '<i class="fa-solid fa-file-circle-plus"> SUBIR CONSTANCIAS</i>',
      titleAttr: "Agregar un nuevo Nivel",
      className: "btn btn-info",
      action: function () {
        agregarNuevoUsuario(); // Llama a la función para agregar un nuevo usuario
      },
    },
  ],
  lengthMenu: [10, 50, 100],
  pageLength: 10,
  destroy: true,
};

const initDataTable = async () => {
  if (dataTableIsInitializated) {
    console.log("Vamos a destruit la tabla");
    dataTable.destroy();
  }
  await listprofesor();
  dataTable = $("#actas").DataTable(dataTableOptions);
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

    const createFolderLink = (folderPath) => {
      return folderPath
        ? `<a href="${folderPath}" target="_blank">${folderPath}</a>`
        : "N/A";
    };

    const response = await fetch(
      "../../ADMINISTRADOR/ACTAS_Y_CONSTANCIAS/documentos.php"
    );

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const profesor = await response.json();

    let content = ``;

    profesor.forEach((planeacion) => {
      content += `
        <tr>
          <td class="text-center">${planeacion.id_documento}</td>
          <td class="text-center">${planeacion.nivel}</td>
          <td class="text-center">${createFolderLink(
            planeacion.acta_calificacion
          )}</td>
          <td class="text-center">${createFolderLink(
            planeacion.acta_liberacion
          )}</td>
          <td class="text-center">
            <button class="modificar btn btn-sm btn-primary" data-id="${
              planeacion.id_documento
            }">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
          </td>
        </tr>`;
    });

    $("#table_actas").html(content);
  } catch (error) {
    console.error("An error occurred:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Ocurrió un error al cargar los datos. Por favor, inténtalo de nuevo más tarde.",
    });
  }
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
      niveles += `<option value="${niveles_g.id_nivel}">Nivel ${niveles_g.nivel}</option>`;
    });

    const { value: formValues } = await Swal.fire({
      title: "Constancias por Nivel",
      html:
        `<select class="swal2-select" id="nivel" style="width: 300px;">${niveles}</select>` +
        `<label for="constancias" style="color: black;">Constancias</label><br>` +
        `<input type="file" id="constancias" class="swal2-file" accept=".pdf" multiple>`,
      showCancelButton: true,
      preConfirm: () => {
        const nivel = document.getElementById("nivel").value;
        const constanciasInput = document.getElementById("constancias");
        const constancias = constanciasInput ? constanciasInput.files : [];

        // Validar que ningún campo esté vacío
        if (!nivel || constancias.length === 0) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }

        return {
          nivel,
          constancias: Array.from(constancias), // Convertir FileList a Array
        };
      },
    });

    if (formValues) {
      const formData = new FormData();
      formData.append("nivel", formValues.nivel);
      for (const file of formValues.constancias) {
        formData.append("constancias[]", file);
      }

      $.ajax({
        url: "../../ADMINISTRADOR/ACTAS_Y_CONSTANCIAS/guardar_datos.php",
        type: "post",
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
          try {
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
          } catch (e) {
            console.error("Error al analizar la respuesta JSON:", e);
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Respuesta del servidor no válida",
            });
          }
          console.log(response); // Mostrar la respuesta del servidor en la consola para depuración
        },
        error: function (xhr, status, error) {
          console.error("Error al procesar la solicitud:", error);
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

function obtenerNivel() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/ACTAS_Y_CONSTANCIAS/niveles.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
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
