<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../".class_bd);
$bd = new DataBase(); 
$codigo       = $_POST['codigo'];

$sql = "SELECT productos.item AS serial,  productos.campo01 AS n_porte, productos.campo02 AS fec_venc_permiso
          FROM productos WHERE productos.codigo = '$codigo'  ";
   $query = $bd->consultar($sql);
$row01=$bd->obtener_fila($query,0);

?>

     <table width="100%" align="center">
    <tr>
      <td class="etiqueta" width="25%">Serial:</td>
      <td id="input01" width="75%"><input type="text" name="serial" maxlength="12" style="width:200px" 
	                                      value="<?php echo utf8_decode($row01["serial"]);?>" readonly="true"/></td>
     </tr>
    <tr>
      <td class="etiqueta">N Porte:</td>
      <td id="input02"><input type="text" name="n_porte" maxlength="12" style="width:200px" 
	                                      value="<?php echo utf8_decode($row01["n_porte"]);?>" readonly="true"/>	 </td>
    </tr>    
    <tr>
      <td class="etiqueta">Fecha Venc. Permiso:</td>
      <td id="input03"><input type="text" name="fecha_permiso" maxlength="12" style="width:120px" 
	                                      value="<?php echo utf8_decode($row01["fec_venc_permiso"]);?>" readonly="true"/>	 </td>
    </tr>    
  </table>
