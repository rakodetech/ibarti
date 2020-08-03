function Add_filtroX() {
    var ficha = $("#stdID").val();
    var cliente = $("#cliente").val();
    var ubicacion = $("#ubicacion").val();
    if (ficha && cliente && cliente != 'TODOS') {
        var parametros = {
            cliente, ficha, ubicacion
        };
        $.ajax({
            data: parametros,
            url: 'packages/planif/planif_marcaje/views/Add_actividades.php',
            type: 'post',
            beforeSend: function () {
                $("#actividades").html('<img src="imagenes/loading3.gif" border="null" class="imgLink" width="30px" height="30px">');
            },
            success: function (response) {
                $("#actividades").html(response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
}

function setRealizado(codigo) {
    if (codigo) {
        if (confirm("Esta seguro de que desea marcar como realizada esta actividad (" + codigo + "), Esta operación es irreversible!.")) {
            var usuario = $("#usuario").val();
            var parametros = {
                codigo, usuario
            };
            $.ajax({
                data: parametros,
                url: 'packages/planif/planif_marcaje/modelo/marcar.php',
                type: 'post',
                success: function (response) {
                    var resp = JSON.parse(response);
                    if (resp.error) {
                        toastr.error("A ocurrido un error al intentar marcar la actividad!..");
                    } else {
                        toastr.success("Actividad Marcada con Exitoso!..");
                        Add_filtroX();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    }
}

function changeCliente(cliente) {
    Add_Cl_Ubic(cliente, 'contenido_ubic', 'T', '120');
    Add_filtroX();
}