<?php
$metodo =  isset($_GET['metodo'])?$_GET['metodo']:'agregar';
$titulo  = strtoupper($metodo) . " REGISTRO CHECK LIST";
if (isset($_SESSION['usuario_cod'])) {
    //require_once('autentificacion/aut_verifica_menu.php');
    $us = $_SESSION['usuario_cod'];
} else {
    $us = $_POST['usuario'];
}
$codigo = "";
$codigo_supervisor = '';
$nombre_supervisor = '';
$codigo_trabajador = '';
$nombre_trabajador = '';
$clasificacion     = '';
$tipo              = '';
$observacion       = '';
$respuesta         = '';
$us_mod            = '';
$fec_mod           = '';
if ($metodo == "agregar") {
    if (isset($_GET['cedula'])) {
        $codigo_trabajador = $_GET['cedula'];
        $sql = "SELECT CONCAT(preingreso.nombres,' ',preingreso.apellidos) FROM preingreso WHERE preingreso.cedula='" . $codigo_trabajador . "'";
        $query  = $bd->consultar($sql);
        while ($datos = $bd->obtener_fila($query, 0)) {
            $nombre_trabajador = $datos[0];
        }
    }
} elseif ($metodo == "modificar") {
    if (isset($_GET['codigo'])) {
        $cod = $_GET['codigo'];
        $sql = "SELECT
        nov_check_list_trab.codigo,
        CONCAT(
            preingreso.nombres,
            ' ',
            preingreso.apellidos
        ) nombre_trabajador,
        CONCAT(
            ficha.nombres,
            ' ',
            ficha.apellidos
        ) nombre_supervisor,
        nov_check_list_trab.cod_nov_clasif clasificacion,
        nov_check_list_trab.cod_nov_tipo tipo,
        nov_check_list_trab.cod_ficha codigo_supervisor,
        nov_check_list_trab.cedula codigo_trabajador,
        nov_check_list_trab.observacion,
        nov_check_list_trab.repuesta respuestas,
        nov_check_list_trab.cod_us_mod,
        nov_check_list_trab.fec_us_mod
    FROM
        nov_check_list_trab,
        preingreso,
        ficha,
        nov_status
    WHERE
        nov_check_list_trab.codigo = '$cod'
    AND preingreso.cedula = nov_check_list_trab.cedula
    AND ficha.cod_ficha = nov_check_list_trab.cod_ficha
    AND nov_status.codigo = nov_check_list_trab.cod_nov_status";
        $query  = $bd->consultar($sql);
        while ($datos = $bd->obtener_fila($query, 0)) {
            $codigo            = $datos['codigo'];
            $codigo_supervisor = $datos['codigo_supervisor'];
            $nombre_supervisor = $datos['nombre_supervisor'];
            $codigo_trabajador = $datos['codigo_trabajador'];
            $nombre_trabajador = $datos['nombre_trabajador'];
            $clasificacion     = $datos['clasificacion'];
            $tipo              = $datos['tipo'];
            $observacion       = $datos['observacion'];
            $respuesta         = $datos['respuestas'];
            $us_mod            = $datos['cod_us_mod'];
            $fec_mod           = $datos['fec_us_mod'];
        }
    }
}
$fecha_sistema = conversion($date);

?>
<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>

<div align="center" class="etiqueta_title"> <?php echo $titulo; ?></div>
<br />
<form name="form_reportes" id="form_reportes" onsubmit="agregar_registro(event,this.id)" action="<?php echo $archivo; ?>" method="post" target="_blank">
    <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo; ?>">
    <table id="datos_b" width="100%">
        <tr>
            <td width="15%">Codigo:</td>
            <td width="25%"><input type="text" name="cod" id="cod" readonly="readonly" value="<?php echo $codigo; ?>" style="width:220px;"></td>
            <td width="15%">Fecha del Sistema</td>
            <td width="25%"><input type="text" name="fec_sis" id="fec_sis" disabled value="<?php echo $fecha_sistema; ?>" style="width:220px;"></td>

        </tr>
        <tr>
            <td>Filtro Supervisor:</td>
            <td>
                <select onchange="habilitar(this.id,this.value)" id="filtro_supervisor" style="width:220px;">
                    <option value="TODOS"> TODOS</option>
                    <option value="codigo"> <?php echo $leng['ficha'] ?> </option>
                    <option value="cedula"><?php echo $leng['ci'] ?> </option>
                    <option value="trabajador"><?php echo $leng['trabajador'] ?> </option>
                    <option value="nombres"> Nombre </option>
                    <option value="apellidos"> Apellido </option>
                </select>
            </td>
            <td>Buscar Supervisor:</td>
            <td><input type="text" id="descripcion_supervisor" required style="width:220px;" value="<?php echo $nombre_supervisor; ?>" disabled></td>
            <input type="hidden" name="codigo_supervisor" required id="codigo_supervisor" value="<?php echo $codigo_supervisor; ?>">
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
            <td><input type="text" id="descripcion_trabajador" style="width:220px;" required disabled value="<?php echo $nombre_trabajador; ?>"></td>
            <input type="hidden" name="codigo_trabajador" id="codigo_trabajador" required value="<?php echo $codigo_trabajador; ?>">
        </tr>

        <tr>
            <td class="etiqueta">Observacion:</td>
            <td id="textarea01"><textarea name="observacion" cols="42" rows="2" value="<?php echo $descripcion; ?>"></textarea>
                <span id="Counterror_mess1" class="texto">&nbsp;</span><br />
                <span class="textareaRequiredMsg">El Campo es Requerido.</span>
                <span class="textareaMinCharsMsg">Debe Escribir mas de 10 caracteres.</span>
                <span class="textareaMaxCharsMsg">El maximo de caracteres permitidos es 500.</span></td>
            
        </tr>
        <tr>
            
            <td class="etiqueta">Usuario Mod. Sistema:</td>
            <td> <?php echo $fec_mod;?></td>
            <td class="etiqueta">Fecha Usuario Mod.: </td>
            <td><?php echo $us_mod;?></td>
        </tr>
        <tr>
            <td class="etiqueta" colspan="2">&nbsp;</td>
            
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
                        <option value="">TODOS</option>
                        <?php
                        $sql = "SELECT codigo, descripcion from nov_clasif where campo04 ='P'";
                        $query01 = $bd->consultar($sql);
                        while ($row01 = $bd->obtener_fila($query01, 0)) {
                            $seleted = ($clasificacion == $row01[0]) ? 'selected' : '';
                            echo '<option value="' . $row01[0] . '" ' . $seleted . ' >' . $row01[1] . '</option>';
                        } ?>
                    </select> </td>
                <td class="etiqueta">TIPO:</td>
                <td id="select05">
                    <select name="tipo" required="required" id="tipo" style="width:150px;" onchange="valores('',this.value);">
                        <option value="">TODOS</option>
                        <?php
                        $sql = "SELECT codigo, descripcion from nov_tipo";
                        $query01 = $bd->consultar($sql);
                        while ($row01 = $bd->obtener_fila($query01, 0)) {
                            $seleted = ($tipo == $row01[0]) ? 'selected' : '';
                            echo '<option value="' . $row01[0] . '" ' . $seleted . ' >' . $row01[1] . '</option>';
                        } ?>
                    </select></td>
            </tr>
        </table>
    </fieldset>
    <div id="contenedor" style="max-height:200px;overflow:scroll;
overflow-y:auto;
overflow-x:auto;padding:3px;
border:1px solid;"></div>

    <span class="art-button-wrapper">

        <span class="art-button-l"> </span>
        <span class="art-button-r"> </span>
        <input type="button" value="Volver" class="readon art-button" onclick="Volver()">

    </span>&nbsp;
    <span class="art-button-wrapper">
        <span class="art-button-l"> </span>
        <span class="art-button-r"> </span>
        <input type="submit" name="salvar" id="salvar" value="Guardar" class="readon art-button" />
    </span>&nbsp;
    <input name="usuario" type="hidden" value="<?php echo $usuario; ?>" />

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

<script src="packages/nov_check_trab/controllers/check_trab.js"></script>
<script>
    var tipo = $("#tipo").val();
    var codigo = $("#cod").val();
    valores(codigo, tipo);
</script>