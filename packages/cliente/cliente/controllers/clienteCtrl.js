$(function () {
  Cons_cliente("", "agregar");
});

$('#addDoc').submit(function (ev) {
  saveDocuments();
  ev.preventDefault();
});

function Cons_cliente(cod, metodo) {
  var usuario = $("#usuario").val();
  var error = 0;
  var errorMessage = " ";
  if (error == 0) {
    var parametros = {
      codigo: cod,
      metodo: metodo,
      usuario: usuario
    };
    $.ajax({
      data: parametros,
      url: "packages/cliente/cliente/views/Add_form.php",
      type: "post",
      success: function (response) {
        $("#Cont_cliente").html(response);

        if (metodo == "modificar") {
          //Desabilito el campo codigo, para evitar errores de INSERT
          $("#codPDF").val(cod);
          $("#c_codigo").attr("disabled", true);
          //Si el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
          $("#pdfC").show();
          $("#borrar_cliente").show();
          $("#agregar_cliente").show();
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
  } else {
    alert(errorMessage);
  }
}

function save_cliente() {
  var error = 0;
  var errorMessage = " ";
  var proced = "p_clientes";

  var codigo = $("#c_codigo").val();
  var abrev = $("#c_abrev").val();
  var juridico = Status($("#c_juridico:checked").val());
  var rif = $("#c_rif").val();
  var nit = $("#c_nit").val();
  var contrib = Status($("#c_contrib:checked").val());
  var nombre = $("#c_nombre").val();
  var telefono = $("#c_telefono").val();
  var fax = $("#c_fax").val();
  var cl_tipo = $("#c_cl_tipo").val();
  var region = $("#c_region").val();
  var vendedor = $("#c_vendedor").val();
  var email = $("#c_email").val();
  var website = $("#c_website").val();
  var contacto = $("#c_contacto").val();
  var direccion = $("#c_direccion").val();
  var observ = $("#c_observ").val();

  var limite_cred = $("#c_limite_cred").val();
  var plazo_pago = $("#c_plazo_pago").val();
  var desc_p_pago = $("#c_desc_p_pago").val();
  var desc_global = $("#c_desc_global").val();
  var dir_entrega = $("#c_dir_entrega").val();

  var campo01 = $("#c_campo01").val();
  var campo02 = $("#c_campo02").val();
  var campo03 = $("#c_campo03").val();
  var campo04 = $("#c_campo04").val();

  var lunes = Status($("#c_lunes:checked").val());
  var martes = Status($("#c_martes:checked").val());
  var miercoles = Status($("#c_miercoles:checked").val());
  var jueves = Status($("#c_jueves:checked").val());
  var viernes = Status($("#c_viernes:checked").val());
  var sabado = Status($("#c_sabado:checked").val());
  var domingo = Status($("#c_domingo:checked").val());

  var activo = Status($("#c_activo:checked").val());
  var usuario = $("#usuario").val();
  var metodo = $("#c_metodo").val();

  if (error == 0) {
    var parametros = {
      codigo: codigo,
      activo: activo,
      rif: rif,
      nit: nit,
      juridico: juridico,
      contrib: contrib,
      abrev: abrev,
      nombre: nombre,
      telefono: telefono,
      fax: fax,
      cl_tipo: cl_tipo,
      region: region,
      vendedor: vendedor,
      email: email,
      website: website,
      contacto: contacto,
      direccion: direccion,
      observ: observ,
      limite_cred: limite_cred,
      plazo_pago: plazo_pago,
      desc_p_pago: desc_p_pago,
      desc_global: desc_global,
      dir_entrega: dir_entrega,
      lunes: lunes,
      martes: martes,
      miercoles: miercoles,
      jueves: jueves,
      viernes: viernes,
      sabado: sabado,
      domingo: domingo,
      campo01: campo01,
      campo02: campo02,
      campo03: campo03,
      campo04: campo04,
      proced: proced,
      usuario: usuario,
      metodo: metodo
    };

    $.ajax({
      data: parametros,
      url: "packages/cliente/cliente/modelo/cliente.php",
      type: "post",
      success: function (response) {
        var resp = JSON.parse(response);
        if (resp.error) {
          alert(resp.mensaje);
        } else {
          if (metodo == "agregar") {
            alert("Actualización Exitosa!..");
            $(".TabbedPanelsTabGroup>li").show();
            //Cambio el metodo a 'modificar'
            $("#c_metodo").val("modificar");
            //Cambio el titulo de Agregar X a Modificar X
            var string = $("#title_cliente")
              .text()
              .split("Agregar")
              .join("Modificar");
            $("#title_cliente").text(string);
            //Desabilito el campo Código hasta que el formulario sufra cambios
            $("#c_codigo").attr("disabled", true);
            //Ya que el metodo es modificar muestro los botones AGREGAR Y ELIMINAR
            $("#pdfC").show();
            $("#borrar_cliente").show();
            $("#agregar_cliente").show();
          } else if (metodo == "modificar") {
            $("#codPDF").val(codigo);
            alert("Actualización Exitosa!..");
          }
          //Cambio la propiedad type del boton de RESTABLECER de reset a button
          //para Evitar errores de historial y a su evento click le una funcion que cargue
          //los datos de el registro que contenga el codigo actual y asi restablecer los valores
          $("#limpiar_cliente").prop("type", "button");
          $("#limpiar_cliente").click(function () {
            Cons_cliente(codigo, "modificar");
          });
          //Paso a false el input que almacena el valor que indica si el formulario a sufrido cambios
          //$("#c_cambios").val('false');
          //Desabilito el boton guardar hasta que el formulario sufra cambios
          //$('#salvar_cliente').attr('disabled',true);
          //Actualizo la tabla de busqueda para que se muestre con la modificacion,
          //con el parametro en true para no cambiar de vista.
          buscar_cliente(true);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
  } else {
    alert(errorMessage);
  }
}

function Borrar_cliente() {
  if (confirm("Esta seguro que desea BORRAR este Registro?..")) {
    var usuario = $("#usuario").val();
    var cod = $("#c_codigo").val();
    var parametros = {
      codigo: cod,
      tabla: "clientes",
      usuario: usuario
    };
    $.ajax({
      data: parametros,
      url: "packages/general/controllers/sc_borrar.php",
      type: "post",
      success: function (response) {
        var resp = JSON.parse(response);
        if (resp.error) {
          alert(resp.mensaje);
        } else {
          //Paso el parametro false para que cambie de vista buscar_cliente(isBuscar)->if(!isBuscar){...
          buscar_cliente(false);
          alert("Registro Eliminado con exito!..");
          //cambio la funcion del evento click del boton Volver para evitar errores de historial
          //volver_cliente -> Cons_cliente('', 'agregar'), para asi no mostrar los datos del registro antes
          //eliminado y mostrar la vista Agregar X
          $("#volver_cliente").click(function () {
            Cons_cliente("", "agregar");
          });
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
  }
}

//Funcion para ir a la vista Agregar, cuanto se esta en Modificar X
function irAAgregarCliente() {
  var msg = "Desea Agregar un NUEVO REGISTRO?.. ";
  //Obtengo el valor que define si el formulario a sufrido cambios, para definir el mensaje de confirmacion
  var cambiosSinGuardar = $("#c_cambios").val();
  if (cambiosSinGuardar == "true")
    msg =
      "Puede haber cambios sin guardar en el formulario, ¿Desea agregar un NUEVO Registro de todas formas?.";
  if (confirm(msg)) Cons_cliente("", "agregar");
}

////Funcion para ir a la vista Agregar, cuanto se esta en
//Buscar X y previamente no se ha modificado ningún registro
function volverCliente() {
  // Oculto la vista Buscar X y Muestro la vista Agregar X
  $("#add_cliente").show();
  $("#buscar_cliente").hide();
}

function irABuscarCliente() {
  //Limpio la data del campo que recibe el filtro de busqueda
  $("#filtro_clientes").val("");
  // Oculto la vista Agregar X y Muestro la vista Buscar X
  $("#add_cliente").hide();
  $("#buscar_cliente").show();
}

function buscar_cliente(isBuscar) {
  var data = $("#data_buscar_cliente").val() || "";
  var filtro = $("#filtro_buscar_cliente").val() || "";
  $.ajax({
    data: { data: data, filtro: filtro },
    url: "packages/cliente/cliente/views/Buscar_clientes.php",
    type: "post",
    beforeSend: function () {
      //Deshabilito el submit del form Buscar X
      $("#buscarCliente").attr("disabled", true);
      //Deshabilito el boton(img) de form Buscar X
      $("#buscarC").attr("disabled", true);
      //Cambio la imagen del boton Buscar X
      $("#buscarC").prop("src", "imagenes/loading3.gif");
    },
    success: function (response) {
      // Oculto la vista Agregar X y Muestro la vista Buscar X
      //solo cuando estoy fuera de la vista Buscar X (lógico)
      if (!isBuscar) {
        $("#add_cliente").hide();
        $("#buscar_cliente").show();
      }
      //Limpio el cuerpo de la tabla con los clientes y pinto el resultado de la busqueda
      $("#lista_clientes tbody tr").remove();
      $("#lista_clientes tbody").html(response);
      //habilito el boton(img) de form Buscar X
      $("#buscarCliente").attr("disabled", false);
      //Habilito el submit del form Buscar X
      $("#buscarC").attr("disabled", false);
      //Restablesco la imagen por defecto del boton buscar X
      $("#buscarC").prop("src", "imagenes/buscar.bmp");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);

      $("#buscarCliente").attr("disabled", false);
      $("#buscarC").attr("disabled", false);
      $("#buscarC").prop("src", "imagenes/buscar.bmp");
    }
  });
}
////////////////////////////////////////////////////////////////////////
var arreglo_contactos = [];
var modificar = false;
var pos_modificar;

function agregar_arreglo_contactos() {
  var datos = "{";
  var encontrado = false;
  var error = 0;
  var motivo_error = "";
  $("#data_ad *")
    .filter(":input")
    .each(function (pos, elemento) {
      if (elemento.value == "") {
        if (!(elemento.id == "c_observacion")) {
          error += 1;
          motivo_error += `Tiene que llenar el campo: ${elemento.id.replace(
            "c_",
            ""
          )}\n`;
        }
      }
      if (pos == 0) {
        datos += `"${elemento.id.replace(
          "c_",
          ""
        )}":"${elemento.value.toUpperCase()}"`;
      } else {
        datos += `,"${elemento.id.replace(
          "c_",
          ""
        )}":"${elemento.value.toUpperCase()}"`;
      }
      if (pos + 1 == $("#data_ad *").filter(":input").length && error == 0) {
        $("#add_cliente_contacto_form")[0].reset();
      } else if (pos + 1 == $("#data_ad *").filter(":input").length) {
        toastr.warning(motivo_error, "ALERTA");
      }
    });
  datos += "}";
  datos = JSON.parse(datos);
  arreglo_contactos.forEach(dato => {
    if (datos.doc == dato.doc) {
      encontrado = true;
    }
  });
  if (error == 0) {
    if (modificar) {
      arreglo_contactos[pos_modificar] = datos;

      modificar = false;
      $("#add_contacto").attr("title", "Agregar Contacto");
      $("#add_contacto").attr("src", "imagenes/ico_agregar.ico");
    } else {
      if (encontrado == false && datos.doc != "") {
        arreglo_contactos.push(datos);
      }
    }
    agregar_db();
    update_table_contactos("tabla_add", arreglo_contactos);
  }
}

function update_table_contactos(id_tabla, arreglo) {
  $("#" + id_tabla + " tbody").html("");
  if (arreglo.length > 0) {
    arreglo.forEach((res, i) => {
      $("#" + id_tabla + " tbody").append(`
			<tr>
				<td>${res.doc}</td>
				<td>${res.nombres}</td>
				<td>${res.cargo}</td>
				<td>${res.tel}</td>
				<td>${res.correo}</td>
				<td align="center"><img src="imagenes/actualizar.bmp" alt="Modificar" onclick="accionar(${i},'modificar')" title="Modificar Registro" width="20" height="20" border="null"/><img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="accionar(${i},'eliminar')" /></td> 
			</tr>
		`);
    });
  }
}

function accionar(poss, tipo) {
  switch (tipo) {
    case "eliminar":
      arreglo_contactos.splice(poss, 1);
      agregar_db();
      break;
    case "modificar":
      modificar = true;
      pos_modificar = poss;

      $("#data_ad *")
        .filter(":input")
        .each(function (pos, elemento) {
          //console.log(arreglo_contactos[pos_modificar]);
          document.getElementById(elemento.id).value =
            arreglo_contactos[pos_modificar][elemento.id.replace("c_", "")];
        });
      $("#add_contacto").attr("title", "Modificar Contacto");
      $("#add_contacto").attr("src", "imagenes/ico_guadar.ico");
      break;
  }
  update_table_contactos("tabla_add", arreglo_contactos);
}

function agregar_db() {
  var documentos = [];
  var nombres = [];
  var cargos = [];
  var telefonos = [];
  var correos = [];
  var observacion = [];
  var cliente = $("#c_codigo").val();
  arreglo_contactos.forEach(contacto => {
    documentos.push(contacto.doc);
    nombres.push(contacto.nombres);
    cargos.push(contacto.cargo);
    telefonos.push(contacto.tel);
    correos.push(contacto.correo);
    observacion.push(contacto.observacion);
  });
  var parametros = {
    cliente: cliente,
    codigos: documentos,
    nombres: nombres,
    cargos: cargos,
    telefonos: telefonos,
    correos: correos,
    observacion: observacion,
    motivo: "set_contactos"
  };
  $.ajax({
    data: parametros,
    url: "packages/cliente/cliente/modelo/cliente.php",
    type: "post",
    success: function (response) {
      toastr.success("Actualización Exitosa!..");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(xhr.status);
      toastr.error(thrownError);
    }
  });
}

function consultar_contactos() {
  var cliente = $("#c_codigo").val();
  var parametros = {
    cliente: cliente,
    motivo: "get_contactos"
  };
  $.ajax({
    data: parametros,
    url: "packages/cliente/cliente/modelo/cliente.php",
    type: "post",
    success: function (response) {
      var data = JSON.parse(response);
      arreglo_contactos = data;
      update_table_contactos("tabla_add", arreglo_contactos);
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
    }
  });
}

function Pdf() {
  $("#pdf").submit();
}


function saveDocuments() {
  $.ajax({
    type: "post",
    url: "scripts/sc_clientes_doc.php",
    data: $('#addDoc').serialize(),
    success: function () {
      toastr.success("Actualización Exitosa");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status);
      alert(thrownError);
    }
  });
}

function modalUpload(cliente, doc) {
  ModalOpen();
  $("#modal_title").text("Cargar Documento");
  $("#contenido_modal").html("");

  var error = 0;
  var errorMessage = ' ';
  if (error == 0) {
    var parametros = {
      doc, cliente
    };
    $.ajax({
      data: parametros,
      url: 'packages/cliente/cliente/views/add_imagenes_doc_cl.php',
      type: 'post',
      success: function (response) {
        $("#contenido_modal").html(response);
        //iniciar_tab(0);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });
  } else {
    alert(errorMessage);
  }

}
