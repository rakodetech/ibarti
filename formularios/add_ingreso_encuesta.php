<?php


require_once('autentificacion/aut_verifica_menu.php');
require_once('sql/sql_report.php');
$bd = new DataBase();
$archivo  = "novedades_check_list";
$vinculo  = "inicio.php?area=formularios/Add_$archivo&Nmenu=$Nmenu&mod=$mod";

?>
<div class="listar">
    <table width="100%">

        <tr class="fondo00">
            <th width="20%" class="etiqueta">Codigo</th>
            <th width="50%" class="etiqueta">Descripcion</th>
            <th width="15%" class="etiqueta">Status</th>
            <th width="15%" align="center"><a href="<?php echo $vinculo . "&codigo=''&metodo=agregar"; ?>"><img src="imagenes/nuevo.bmp" alt="Agregar" title="Agregar Registro" width="30px" height="30px" border="null" /></a></th>
        </tr>
    </table>
</div>