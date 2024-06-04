let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
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

const extractFolderName = (filePath) => {
  if (!filePath) return "N/A";
  const parts = filePath.split("/");
  return parts.length > 1 ? parts[parts.length - 2] : "N/A";
};

const createFolderDownloadLink = (filePath) => {
  const folderName = extractFolderName(filePath);
  if (folderName === "N/A") return "N/A";

  const folderPath = filePath.split("/").slice(0, -1).join("/") + "/";
  const downloadUrl = folderPath + folderName + ".zip"; // Asumiendo que el servidor provee un archivo ZIP

  return `<a href="${downloadUrl}" download>${folderName}</a>`;
};

// Uso de las funciones actualizadas
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
      "../../ADMINISTRADOR/ACTAS_Y_CONSTANCIAS/documentos.php"
    );
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((planeacion) => {
      content += `
        <tr>
          <td class="text-center">${planeacion.id_documento}</td>
          <td class="text-center">${planeacion.grupo}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.acta_calificacion
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.acta_calificacion_2
          )}</td>
          <td class="text-center">${createDownloadLink(
            planeacion.acta_calificacion_3
          )}</td>
          <td class="text-center">${createFolderDownloadLink(
            planeacion.acta_liberacion
          )}</td>
          <td class="text-center">
            <button class="modificar btn btn-sm btn-primary" data-id="${
              planeacion.id_documento
            }" data-grupo="${
              planeacion.grupo
            }">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
          </td>
        </tr>`;
    });

    $("#table_actas").html(content);
  } catch (error) {
    console.error("Error:", error);
  }
};

window.addEventListener("load", async () => {
  await initDataTable();
});



//SweetAlert2
$(document).on("click", ".modificar", async function () {
  var id = $(this).data("id");
  var grupo = $(this).data("grupo");

  console.log(id, grupo);

  try {
    const result = await Swal.fire({
      title: `Modificar Documentos ${grupo}`,
      html: `
        <label for="constancias" style="color: black;">Actas de Liberacion</label>
        <input type="file" id="constancias" class="swal2-file" accept=".pdf" multiple>
      `,
      focusConfirm: false,
      preConfirm: () => {
        const constancias = document.getElementById("constancias").files;
        return {
          id,
          grupo,
          constancias
        };
      },
    });

    if (result.isConfirmed) {
      const formValues = result.value;
      const formData = new FormData();
      formData.append("id", formValues.id);
      formData.append("grupo", formValues.grupo);
      
      for (let i = 0; i < formValues.constancias.length; i++) {
        formData.append("constancias[]", formValues.constancias[i]);
      }

      const response = await $.ajax({
        url: "../../ADMINISTRADOR/ACTAS_Y_CONSTANCIAS/actulizar.php",
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


