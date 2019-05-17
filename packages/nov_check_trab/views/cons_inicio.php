<?php
$sql = "SELECT CONCAT(preingreso.nombres,' ',preingreso.apellidos) FROM preingreso WHERE preingreso.cedula='" . $cedula . "'";
$query  = $bd->consultar($sql);
$filtro = "CEDULA";
$cedula = "";
$nombre = "";
$usuario = $_SESSION['usuario_cod'];
$fecha_sistema = conversion($date);
while ($datos = $bd->obtener_fila($query, 0)) {
    $nombre = $datos[0];
}
?>
<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<script src="packages/nov_check_trab/controllers/check_trab.js"></script>

<form name="form_reportes" id="form_reportes" action="<?php echo $archivo; ?>" method="post" target="_blank">
    <table id="datos_b" width="100%">
        <tr>
            <td width="15%">Codigo:</td>
            <td width="25%"><input type="text" name="cod" id="cod" style="width:220px;"></td>
            <td width="15%">Fecha del Sistema</td>
            <td width="25%"><input type="text" name="fec_sis" id="fec_sis" disabled value="<?php echo $fecha_sistema; ?>" style="width:220px;"></td>

        </tr>
        <tr>
            <td>Filtro Supervisor:</td>
            <td>
                <select  onchange="habilitar(this.id,this.value)" id="filtro_supervisor" style="width:220px;">
                    <option value="TODOS"> TODOS</option>
                    <option value="codigo"> <?php echo $leng['ficha'] ?> </option>
                    <option value="cedula"><?php echo $leng['ci'] ?> </option>
                    <option value="trabajador"><?php echo $leng['trabajador'] ?> </option>
                    <option value="nombres"> Nombre </option>
                    <option value="apellidos"> Apellido </option>
                </select>
            </td>
            <td>Buscar Supervisor:</td>
            <td><input type="text" id="descripcion_supervisor" style="width:220px;" value="" disabled></td>
            <input type="hidden" name="codigo_supervisor" id="codigo_supervisor" value="">
        </tr>
        
        <tr>
            <td>Filtro Trabajador:</td>
            <td>
                <select onchange="habilitar(this.id,this.value)" id="filtro_trabajador" style="width:220px;">
                    <option value="TODOS"> TODOS</option>
                    <option value="cedula"><?php echo $leng["ci"]; ?></option>
                    <option value="trabajador"> <?php echo $leng["trabajador"]; ?> </option>
                    <option value="nombres"> Nombre </option>
                    <option value="apellidos"> Apellido </option>
                </select>
            </td>
            <td>Buscar Trabajador:</td>
            <td><input type="text" id="descripcion_trabajador" style="width:220px;" disabled value=""></td>
            <input type="hidden" name="codigo_trabajador" id="codigo_trabajador" value="">
        </tr>

        <tr>
            <td class="etiqueta">Observacion:</td>
            <td id="textarea01"><textarea name="observacion" cols="42" rows="2" readonly="readonly"></textarea>
                <span id="Counterror_mess1" class="texto">&nbsp;</span><br />
                <span class="textareaRequiredMsg">El Campo es Requerido.</span>
                <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 500.</span></td>
            <td class="etiqueta">Repuesta:</td>
            <td id="textarea02"><textarea name="repuesta" id="respuesta"cols="42" rows="2" readonly="readonly"></textarea>
                <span id="Counterror_mess2" class="texto">&nbsp;</span><br />
                <span class="textareaRequiredMsg">El Campo es Requerido.</span>
                <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 500.</span></td>
        </tr>
        <tr>
            <td class="etiqueta">Status:</td>
            <td id="select10"><select name="status" style="width:200px">

                </select><br />
                <span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
            <td class="etiqueta">Usuario Mod. Sistema: </td>
            <td></td>
        </tr>
        <tr>
            <td class="etiqueta" colspan="2">&nbsp;</td>
            <td class="etiqueta">Fecha Usuario Mod.: </td>
            <td></td>
        </tr>
        </tr>
    </table>
    <fieldset>
        <legend>Filtros:</legend>
        <table width="100%">
            <tr id="Contenedor02">
                <td class="etiqueta" width="15%">CLASIFICACION:</td>
                <td width="25%" id="select04"><select name="clasif" required="required" id="clasif" onchange="llenar_nov_tipo(this.value)" style="width:220px;">
                        <option value="TODOS">TODOS</option>
                        <?php
                        $sql = "SELECT codigo, descripcion from nov_clasif where campo04 ='T'";
                        $query01 = $bd->consultar($sql);
                        while ($row01 = $bd->obtener_fila($query01, 0)) {
                            echo '<option value="' . $row01[0] . '">' . $row01[1] . '</option>';
                        } ?>
                    </select> </td>
                <td class="etiqueta">TIPO:</td>
                <td id="select05"><select name="tipo" required="required" id="tipo" style="width:150px;" onchange="valores(this.value);">

                    </select></td>
            </tr>
        </table>
    </fieldset>
    <div id="contenedor" style="max-height:200px;overflow:scroll;
overflow-y:auto;
overflow-x:auto;padding:3px;
border:1px solid;"></div>
    <button type="submit">sub</button>
    <input name="usuario" type="hidden" value="<?php echo $usuario;?>" />
    
</form>

<script>
    new Autocomplete("descripcion_trabajador", function() {
        filtro_trabajador = $('#filtro_trabajador').val();
        this.setValue = function(id) {
            document.getElementById("codigo_trabajador").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return;
        return "autocompletar/tb/ingreso.php?q=" + this.text.value + "&filtro=" + filtro_trabajador + ""
    });

    new Autocomplete("descripcion_supervisor", function() {
        filtro_supervisor = $('#filtro_supervisor').val();
        this.setValue = function(id) {
            document.getElementById("codigo_supervisor").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return;
        return "autocompletar/tb/trabajador.php?q=" + this.text.value + "&filtro=" + filtro_supervisor;
    });

    function habilitar(id, valor) {
        var text = id.replace("filtro", 'descripcion');
        $("#" + text).prop("disabled", (valor == "TODOS" || valor == ""));
       
    }
</script>