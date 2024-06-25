let dataTable;
let dataTableIsInitializated = false;

const dataTableOptions = {
  dom: "Bfrtilp",
  buttons: [
    {
      extend: "excelHtml5",
      text: '<i class="fa-solid fa-file-csv"> Descargar Listas</i>',
      titleAttr: "Descargar listas",
      className: "btn btn-success",
    },
  ],
  lengthMenu: false,
  pageLength: 3,
  destroy: true,
};

const initDataTable = async () => {
  if (dataTableIsInitializated) {
    console.log("Vamos a destruir la tabla");
    dataTable.destroy();
  }
  await listprofesor();
  dataTable = $("#alumnos").DataTable(dataTableOptions);
  dataTableIsInitializated = true;
};

const listprofesor = async () => {
  try {
    const response = await fetch("../../ADMINISTRADOR/ALUMNOS/alumnos.php");
    const profesor = await response.json();

    let content = ``;

    profesor.forEach((grupos) => {
      content += `
                <tr>
                    <td class="text-center">${grupos.matricula}</td>
                    <td class="text-center">${grupos.nombre}</td>
                    <td class="text-center">${grupos.ap_paterno}</td>
                    <td class="text-center">${grupos.ap_materno}</td>
                    <td class="text-center">${grupos.correo}</td>
                    <td class="text-center">${grupos.nombre_carrera}</td>
                    <td class="text-center">${grupos.telefono}</td>
                    <td class="text-center">${grupos.lin_captura_t}</td>
                    <td class="text-center">${grupos.fecha_pago}</td>
                    <td class="text-center">${grupos.fecha_entrega}</td>
                    <td class="text-center">
                        <button class="modificar btn btn-sm btn-primary" data-matricula="${grupos.matricula}" data-nombre="${grupos.nombre}" data-paterno="${grupos.ap_paterno}" data-materno="${grupos.ap_materno}" data-telefono="${grupos.telefono}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>`;
    });

    $("#table_alumno").html(content);
  } catch (error) {}
};

window.addEventListener("load", async () => {
  await initDataTable();
});

$(document).on("click", ".modificar", async function () {
  var old_matricula = $(this).data("matricula");
  var nombre = $(this).data("nombre");
  var paterno = $(this).data("paterno");
  var materno = $(this).data("materno");
  var telefono = $(this).data("telefono");

  const profesores = await obtenerCarreras();

  let carrera = "";
  profesores.forEach((carreras) => {
    carrera += `<option value="${carreras.id_carrera}">${carreras.nombre_carrera}</option>`;
  });

  const estatus = await obtenerEstatus();

  let estatu = "";
  estatus.forEach((estatus_a) => {
    estatu += `<option value="${estatus_a.id_estatus_alumno}">${estatus_a.estatus_alumno}</option>`;
  });

  const nivel_grupos = await obtenerNivel();

  let niveles = "";
  nivel_grupos.forEach((niveles_g) => {
    niveles += `<option value="${niveles_g.id_nivel}">${niveles_g.nivel} - ${niveles_g.grupo}</option>`;
  });

  try {
    const result = await Swal.fire({
      title: "Modificar Alumno",
      html:
        `<input id="swal-input-matricula" class="swal2-input" placeholder="Matricula" value="${old_matricula}">` +
        `<input id="swal-input-nombre" class="swal2-input" placeholder="Nombre" value="${nombre}">` +
        `<input id="swal-input-paterno" class="swal2-input" placeholder="Apellido Paterno" value="${paterno}">` +
        `<input id="swal-input-materno" class="swal2-input" placeholder="Apellido Materno" value="${materno}">` +
        `<select class="swal2-select" id="carreras" style="width: 265px;">${carrera}</select>` +
        `<input id="swal-input-telefono" class="swal2-input" placeholder="Telefono" value="${telefono}">` +
        `<select class="swal2-select" id="nivel" style="width: 265px;">${niveles}</select>` +
        `<select class="swal2-select" id="estatus" style="width: 265px;">${estatu}</select>`,
      focusConfirm: false,
      //width: '650px',
      preConfirm: () => {
        const new_matricula = document.getElementById(
          "swal-input-matricula"
        ).value;
        const nombre = document.getElementById("swal-input-nombre").value;
        const paterno = document.getElementById("swal-input-paterno").value;
        const materno = document.getElementById("swal-input-materno").value;
        const carreras = document.getElementById("carreras").value;
        const telefono = document.getElementById("swal-input-telefono").value;
        const nivel = document.getElementById("nivel").value;
        const estatus = document.getElementById("estatus").value;

        if (
          !new_matricula ||
          !nombre ||
          !paterno ||
          !materno ||
          !carreras ||
          !telefono ||
          !nivel ||
          !estatus
        ) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }

        // Validar el formato del teléfono
        const phoneNumberPattern = /^\d{2} \d{4} \d{4}$/;
        if (!phoneNumberPattern.test(telefono)) {
          Swal.showValidationMessage(
            "El teléfono debe tener el formato correcto: XX XXXX XXXX"
          );
          return false;
        }

        return {
          old_matricula: old_matricula,
          new_matricula: new_matricula,
          nombre: nombre,
          paterno: paterno,
          materno: materno,
          carreras: carreras,
          telefono: telefono,
          nivel: nivel,
          estatus: estatus,
        };
      },
    });

    if (result.isConfirmed) {
      var data = result.value;

      // Ejemplo: enviar datos modificados por AJAX
      const response = await $.ajax({
        url: "../../ADMINISTRADOR/ALUMNOS/actualizar.php",
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

// Formatear el número de teléfono en el campo de entrada
document.addEventListener("input", function (e) {
  if (e.target && e.target.id === "swal-input-telefono") {
    let phoneNumber = e.target.value.replace(/\D/g, ""); // Eliminar todos los caracteres que no sean dígitos

    let formattedPhoneNumber = "";

    // Formatear el número de teléfono
    if (phoneNumber.length > 0) {
      formattedPhoneNumber += phoneNumber.slice(0, 2);
      if (phoneNumber.length > 2) {
        formattedPhoneNumber += " " + phoneNumber.slice(2, 6);
      }
      if (phoneNumber.length > 6) {
        formattedPhoneNumber += " " + phoneNumber.slice(6, 10);
      }
    }

    // Actualizar el valor del campo de entrada
    e.target.value = formattedPhoneNumber;
  }
});

function obtenerCarreras() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/ALUMNOS/carreras.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
      type: "GET",
      success: function (response) {
        resolve(JSON.parse(response));
      },
      error: function () {
        reject("Error al obtener la lista de carreras");
      },
    });
  });
}

function obtenerEstatus() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/ALUMNOS/estatus.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
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

function obtenerNivel() {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../../ADMINISTRADOR/ALUMNOS/niveles.php", // Ruta a tu archivo PHP que obtiene la lista de profesores
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