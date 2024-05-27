let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extends: "",
      text: '<i class="fa-solid fa-user-plus"> Nuevo Nivel</i>',
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
  dataTable = $("#niveles").DataTable(dataTableOptions);
  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const response = await fetch("../../ADMINISTRADOR/NIVELES/datos_nivel.php");
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((niveles) => {
      content += `
            <tr>
                <td class="text-center">${niveles.id_nivel}</td>
                <td class="text-center">${niveles.nivel}</td>
                <td class="text-center">${niveles.grupo}</td>
                <td class="text-center">${niveles.nombre}</td>
                <td class="text-center">${niveles.cupo_max}</td>
                <td class="text-center">${niveles.periodo}</td>
                <td class="text-center">${niveles.modalidad}</td>
                <td class="text-center">${niveles.horario}</td>
                <td class="text-center">${niveles.aula}</td>
                <td class="text-center">
                    <button class="modificar btn btn-sm btn-primary" data-id="${niveles.id_nivel}" data-nivel="${niveles.nivel}" data-grupo="${niveles.grupo}" data-cupo="${niveles.cupo_max}" data-modalidad="${niveles.modalidad}" data-horario="${niveles.horario}" data-aula="${niveles.aula}">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
            </tr>`;
    });

    $("#table_niveles").html(content);
  } catch (error) {}
};

window.addEventListener("load", async () => {
  await initDataTable();
});

//SweetAlert2
function agregarNuevoUsuario() {
  (async () => {
    // Obtener la lista de profesores de la base de datos
    const profesores = await obtenerProfesores();

    // Construir las opciones para el select de profesores
    let options = "";
    profesores.forEach((profesor) => {
      options += `<option value="${profesor.id_profesor}">${profesor.nombre}</option>`;
    });

    // Obtener la lista de profesores de la base de datos
    const periodos = await obtenerPeriodo();

    // Construir las opciones para el select de profesores
    let options1 = "";
    periodos.forEach((periodo) => {
      options1 += `<option value="${periodo.id_periodo}">${periodo.periodo}</option>`;
    });

    const { value: formValues } = await Swal.fire({
      title: "Nuevo Grupo",
      html:
        '<input class="swal2-input" id="nivel" placeholder="Nivel">' +
        '<input class="swal2-input" id="grupo" placeholder="Grupo">' +
        `<select class="swal2-select" id="profesor" style="width: 265px;">${options}</select>` +
        '<input class="swal2-input" id="cupo_max" placeholder="Cupo Maximo">' +
        `<select class="swal2-select" id="periodo" style="width: 265px;">${options1}</select>` +
        '<input class="swal2-input" id="modalidad" placeholder="Modalidad">' +
        '<input class="swal2-input" id="horario" placeholder="Horario">' +
        '<input class="swal2-input" id="aula" placeholder="Aula">',
      showCancelButton: true,
      preConfirm: () => {
        const nivel = $("#nivel").val();
        const grupo = $("#grupo").val();
        const profesor = $("#profesor").val();
        const cupo_max = $("#cupo_max").val();
        const periodo = $("#periodo").val();
        const modalidad = $("#modalidad").val();
        const horario = $("#horario").val();
        const aula = $("#aula").val();

        // Validar que ningún campo esté vacío
        if (
          !nivel ||
          !grupo ||
          !profesor ||
          !cupo_max ||
          !periodo ||
          !modalidad ||
          !horario ||
          !aula
        ) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
        }

        return {
          nivel,
          grupo,
          profesor,
          cupo_max,
          periodo,
          modalidad,
          horario,
          aula,
        };
      },
    });

    if (formValues) {
      $.ajax({
        url: "../../ADMINISTRADOR/NIVELES/guardar_datos.php",
        type: "post",
        data: formValues,
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
              text: "Ocurrió un error al registrar los datos",
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

// Función para obtener la lista de profesores
function obtenerProfesores() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/NIVELES/datos_profesor.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
      type: "GET",
      success: function (response) {
        resolve(JSON.parse(response));
      },
      error: function () {
        reject("Error al obtener la lista de profesores");
      },
    });
  });
}

function obtenerPeriodo() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/NIVELES/datos_periodos.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
      type: "GET",
      success: function (response) {
        resolve(JSON.parse(response));
      },
      error: function () {
        reject("Error al obtener la lista de profesores");
      },
    });
  });
}

$(document).on("click", ".modificar", async function () {
  var id = $(this).data("id");
  var nivel = $(this).data("nivel");
  var grupo = $(this).data("grupo");
  var cupo = $(this).data("cupo");
  var modalidad = $(this).data("modalidad");
  var horario = $(this).data("horario");
  var aula = $(this).data("aula");

  try {
    // Obtener la lista de profesores de la base de datos
    const profesores = await obtenerProfesores();

    // Construir las opciones para el select de profesores
    let options = "";
    profesores.forEach((profesor) => {
      options += `<option value="${profesor.id_profesor}">${profesor.nombre}</option>`;
    });

    // Obtener la lista de periodos de la base de datos
    const periodos = await obtenerPeriodo();

    // Construir las opciones para el select de periodos
    let options1 = "";
    periodos.forEach((periodo) => {
      options1 += `<option value="${periodo.id_periodo}">${periodo.periodo}</option>`;
    });

    const result = await Swal.fire({
      title: "Modificar Nivel",
      html:
        `<input id="swal-input2" class="swal2-input" placeholder="Nivel" value="${nivel}">` +
        `<input id="swal-input3" class="swal2-input" placeholder="Grupo" value="${grupo}">` +
        `<select class="swal2-select" id="profesor" style="width: 265px;">${options}</select>` +
        `<input id="swal-input4" class="swal2-input" placeholder="Cupo Maximo" value="${cupo}">` +
        `<select class="swal2-select" id="periodo" style="width: 265px;">${options1}</select>` +
        `<input class="swal2-input" id="modalidad" placeholder="Modalidad" value="${modalidad}">` +
        `<input class="swal2-input" id="horario" placeholder="Horario" value="${horario}">` +
        `<input class="swal2-input" id="aula" placeholder="Aula" value="${aula}">`,
      focusConfirm: false,
      preConfirm: () => {
        const nivel = document.getElementById("swal-input2").value;
        const grupo = document.getElementById("swal-input3").value;
        const profesor = document.getElementById("profesor").value;
        const cupo = document.getElementById("swal-input4").value;
        const periodo = document.getElementById("periodo").value;
        const modalidad = document.getElementById("modalidad").value;
        const horario = document.getElementById("horario").value;
        const aula = document.getElementById("aula").value;

        if (
          !nivel ||
          !grupo ||
          !profesor ||
          !cupo ||
          !periodo ||
          !modalidad ||
          !horario ||
          !aula
        ) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }

        return {
          id: id,
          nivel: nivel,
          grupo: grupo,
          profesor: profesor,
          cupo_max: cupo,
          periodo: periodo,
          modalidad: modalidad,
          horario: horario,
          aula: aula,
        };
      },
    });

    if (result.isConfirmed) {
      var data = result.value;

      // Ejemplo: enviar datos modificados por AJAX
      const response = await $.ajax({
        url: "actualizar.php",
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