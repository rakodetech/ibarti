<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$codigo   = $_POST['codigo'];
$usuario  = $_POST['usuario'];
$metodo   = $_POST['metodo'];


if($metodo == 'agregar'){
$titulo   = "Agregar Planificacion De Clientes";
$evento   = "Ingresar";
$hidden   = "hidden";

  $sql = "SELECT * FROM pl_cliente_apertura WHERE pl_cliente_apertura.`status` = 'T' ";
  $query = $bd->consultar($sql);
  $datos=$bd->obtener_fila($query,0);


$fecha_inicio = $datos['fecha_inicio'];
$fecha_fin    = $datos['fecha_fin'];

$cod_turno = "";
$turno     = 'Seleccione...';
$cod_cargo = "";
$cargo     = 'Seleccione...';
$excepcion    = "";

$fec_us_ing   = "";
$us_ing       = "";
$fec_us_mod   = "";
$us_mod       = "";

}elseif($metodo=='modificar'){
$titulo   = "Modificar Planificacion De Clientes";
$evento   = "Actualizar";
$hidden   = "";

$sql = "SELECT pl_cliente.*, cargos.descripcion cargo, turno.descripcion turno,
               CONCAT(a.apellido, ' ', a.nombre) us_ing, CONCAT(a.apellido, ' ', a.nombre) us_mod
          FROM pl_cliente LEFT JOIN men_usuarios a ON pl_cliente.cod_us_ing = a.codigo
                          LEFT JOIN men_usuarios b ON pl_cliente.cod_us_mod = b.codigo ,
               cargos, turno
			   WHERE pl_cliente.codigo  = '$codigo'
	         AND pl_cliente.cod_cargo = cargos.codigo
           AND pl_cliente.cod_turno = turno.codigo
     		 ORDER BY 1 ASC  ";
  $query = $bd->consultar($sql);
	$datos=$bd->obtener_fila($query,0);


  $fecha_inicio = $datos['fecha_inicio'];
  $fecha_fin    = $datos['fecha_fin'];

  $cod_turno = $datos['cod_turno'];
  $turno     = $datos['turno'];
  $cod_cargo = $datos['cod_cargo'];
  $cargo     = $datos['cargo'];
  $excepcion    = $datos['excepcion'];
  $fec_us_ing   = $datos['fec_us_ing'];
  $us_ing       = $datos['us_ing'];
  $fec_us_mod   = $datos['fec_us_mod'];
  $us_mod       = $datos['us_mod'];

}


  $sql_cargo = "SELECT cargos.codigo, cargos.descripcion FROM cargos
                 WHERE cargos.`status` = 'T'
                  AND  cargos.codigo <> '$cod_cargo'
              ORDER BY 2 ASC";

  $sql_turno = "SELECT turno.codigo, turno.descripcion FROM turno
                 WHERE turno.`status` = 'T'
                   AND turno.codigo <> '$cod_turno'
              ORDER BY 2 ASC";

  ?><form id="form_mod" name="form_mod" action="" method="post"><table width="100%" align="center">
           <tr >
  		     <td height="23" colspan="4" class="etiqueta_title"><div align="center"><?php echo $titulo;?></div></td>
           </tr>
           <tr>
      	       <td height="8" colspan="4"><hr></td>
       	    </tr>
        <tr>
           <td class="etiqueta" width="15%">Cargo:</td>
           <td width="35%"><select name="cargo" id="cargo" style="width:220px;" >
              <option value="<?php echo $cod_cargo;?>"><?php echo $cargo;?></option>
           	 <?php
               $query03 = $bd->consultar($sql_cargo);
           	  while($row03=$bd->obtener_fila($query03,0)){
           		  echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           	} ;?></select></td>
           <td class="etiqueta" width="15%">Turno:</td>
           <td width="35%"><select name="turno" id="turno" style="width:220px;">
               <option value="<?php echo $cod_turno;?>"><?php echo $turno;?></option>
           <?php
           $query03 = $bd->consultar($sql_turno);
           while($row03=$bd->obtener_fila($query03,0)){
           echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           } ;?></select></td>
          </tr>
     <tr>
      	<td class="etiqueta">Fecha Incio:</td>
      	<td><input type="date" name="fecha_desde" id="fecha_desde" style="width:120px" placeholder="Fecha Inicio" value="<?php echo $fecha_inicio;?>" require /></td>
        <td class="etiqueta">fecha Fin:</td>
        <td><input type="date" name="fecha_hasta" id="fecha_hasta" style="width:120px" placeholder="Fecha Fin" value="<?php echo $fecha_fin;?>" require /></td>
       </tr>
      <tr>
        <tr>
         	<td class="etiqueta">Excepcion:</td>
         	<td>SI <input type = "radio" name="excepcion" id ="excepcion_t"  value = "T" style="width:auto" <?php echo CheckX($excepcion, 'T');?> /> NO <input
          type = "radio" id ="excepcion_f" name="excepcion" value = "F" <?php echo CheckX($excepcion, 'F');?> style="width:auto" /></td>
           <td class="etiqueta">Servicios:</td>
           <td><input type="number" name="cantidad" id="cantidad" placeholder="Servicios"  min="1" max="999" style="width:100px" value="<?php echo $datos['cantidad'];?>" require/></td>
        </tr>
        <tr <?php echo $hidden;?>>
          <td class="etiqueta">Fecha Us. Ingreso:</td>
          <td><?php echo $fec_us_ing;?></td>
           <td class="etiqueta">Usuario Ingreso:</td>
           <td><?php echo $us_ing;?></td>
        </tr>
        <tr <?php echo $hidden;?>>
          <td class="etiqueta">Fecha Ultima Mod.:</td>
          <td><?php echo $fec_us_mod;?></td>
           <td class="etiqueta">Usuario Modifico:</td>
           <td><?php echo $us_mod;?></td>
        </tr>
       <tr>
          <td height="8" colspan="4" align="center"><hr></td>
       </tr>
    </table><div align="center">
  <span class="art-button-wrapper">
                      <span class="art-button-l"> </span>
                      <span class="art-button-r"> </span>
                  <input type="button" name="actualizar"  id="actualizar" value="<?php echo $evento;?>" onClick="ActualizarCl()" class="readon art-button" />
                </span>&nbsp;  <span class="art-button-wrapper">
                      <span class="art-button-l"> </span>
                      <span class="art-button-r"> </span>
                  <input type="button" value="Cancelar" onClick="FiltrarCl()" class="readon art-button" />
                </span>&nbsp;<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>"/><input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>"/>
  </div></form>
