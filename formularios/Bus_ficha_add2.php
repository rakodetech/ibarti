<?php
$Nmenu = 410;
$area = "pestanas/add_ficha2";
require_once('autentificacion/aut_verifica_menu.php');


if ($_SESSION['ficha_preingreso'] == "N") {
    Redirec("inicio.php?area=" . $area . "&Nmenu=" . $Nmenu . "&mod=" . $mod . "&codigo=&metodo=agregar");
}
?>
<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>

<fieldset>
    <legend> Agregar <?php echo $leng["ficha"]; ?> <?php echo $leng["trabajador"]; ?>: </legend>
    <form action="inicio.php" method="get" name="add" id="add">
        <table width="750" border="0" align="center">
            <tr>
                <td class="etiqueta">Filtro:</td>
                <td id="select01">
                    <select id="paciFiltro" onchange="EstadoFiltro()" style="width:200px">
                        <option value=""> Seleccione el campo a filtrar </option>
                        <option value="cedula"> <?php echo $leng["ci"]; ?> </option>
                        <option value="trabajador"><?php echo $leng["trabajador"]; ?> </option>
                        <option value="nombres"> Nombre </option>
                        <option value="apellidos"> Apellido </option>
                    </select><br />
                    <span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
                </td>
            </tr>
            <tr>
                <td class="etiqueta"><?php echo $leng["trabajador"]; ?>:</td>
                <td><input id="stdName" type="text" style="width:300px" disabled="disabled" />
                    <span id="input01"><input type="hidden" name="codigo" id="stdID" /><br />
                        <span class="textfieldRequiredMsg">Debe De Seleccionar Un Campo De la Lista.</span>
                        <span class="textfieldInvalidFormatMsg">El Formato es Invalido</span> </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <hr>
                </td>
            </tr>
        </table>
        <div align="center">
            <span class="art-button-wrapper">
                <span class="art-button-l"> </span>
                <span class="art-button-r"> </span>
                <input type="button" onclick="validateAddFicha()" name="salvar" id="salvar" value="Procesar" class="readon art-button" />
            </span>&nbsp;
            <span class="art-button-wrapper">
                <span class="art-button-l"> </span>
                <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
            </span>&nbsp;
            <span class="art-button-wrapper">
                <span class="art-button-l"> </span>
                <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
            </span>
            <input type="hidden" name="area" value="<?php echo $area ?>" />
            <input type="hidden" name="Nmenu" value="<?php echo $Nmenu ?>" />
            <input type="hidden" name="mod" value="<?php echo $mod; ?>" />
            <input type="hidden" name="metodo" value="agregar" />
        </div>
    </form>
</fieldset>
<div id="ContendorConsulta">
</div>
<script type="text/javascript">
    function validateAddFicha() {
        var cedula = $("#stdID").val()
        $.ajax({
            data: {
                cedula
            },
            url: 'packages_mant/general/views/validateAddFicha.php',
            type: 'post',
            success: function(response) {
                var resp = JSON.parse(response);
                if (resp.error) {
                    toastr.error(resp.mensaje);
                } else {
                    $("#add").submit();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
    var select01 = new Spry.Widget.ValidationSelect("select01", {
        validateOn: ["blur", "change"]
    });
    var input01 = new Spry.Widget.ValidationTextField("input01", "none", {
        minChars: 2,
        validateOn: ["blur", "change"]
    });

    filtroId = document.getElementById("paciFiltro");
    filtroIndice = filtroId.selectedIndex;
    filtroValue = filtroId.options[filtroIndice].value;

    new Autocomplete("stdName", function() {
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return;
        return "autocompletar/tb/ficha_agregar.php?q=" + this.text.value + "&filtro=" + filtroValue + ""
    });
</script>