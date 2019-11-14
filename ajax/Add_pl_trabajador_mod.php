<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$codigo   = $_POST['codigo'];
$usuario  = $_POST['usuario'];
$metodo   = $_POST['metodo'];




  $sql = "SELECT a.codigo FROM pl_cliente_apertura a WHERE a.`status` = 'T'";
  $query = $bd->consultar($sql);
  $datos=$bd->obtener_fila($query,0);
  $periodoCL = $datos[0];

if($metodo == 'agregar'){

  $sql = "SELECT * FROM pl_trab_apertura WHERE pl_trab_apertura.`status` = 'T' ";
  $query = $bd->consultar($sql);
  $datos=$bd->obtener_fila($query,0);

$titulo   = "Agregar Planificacion De Trabajador";
$evento   = "Ingresar";
$hidden   = "hidden";

$fecha_inicio = $datos['fecha_inicio'];
$fecha_fin    = $datos['fecha_fin'];
$cod_cliente   = '';
$cliente       = 'Seleccione...';
$cod_ubicacion = '';
$ubicacion     = 'Seleccione..';
$cod_rotacion  = '';
$rotacion      = 'Seleccione..';
$rotacion_n    = 'Seleccione...';
$excepcion     = '';
$us_ing        = '';
$fec_us_ing    = '';
$us_mod        = '';
$fec_us_mod    = '';

}elseif($metodo=='modificar') {

$titulo   = "Modificar Planificacion De Trabajador";
$evento   = "Actualizar";
$hidden   = "";

$sql = "SELECT pl_trabajador.*, clientes.abrev, clientes.nombre,
               clientes_ubicacion.descripcion ubicacion, rotacion.descripcion rotacion,
                CONCAT(a.apellido, ' ',a.nombre) us_ing, CONCAT(b.apellido, ' ',b.nombre) us_mod
          FROM pl_trabajador LEFT JOIN men_usuarios a ON pl_trabajador.cod_us_ing = a.codigo LEFT JOIN men_usuarios b ON pl_trabajador.cod_us_mod = b.codigo,
               clientes, clientes_ubicacion, rotacion
			   WHERE pl_trabajador.codigo = '$codigo'
           AND pl_trabajador.cod_cliente = clientes.codigo
           AND pl_trabajador.cod_ubicacion = clientes_ubicacion.codigo
           AND pl_trabajador.cod_rotacion = rotacion.codigo
			   ORDER BY 1 ASC   ";
  $query = $bd->consultar($sql);
	$datos=$bd->obtener_fila($query,0);


  $fecha_inicio = $datos['fecha_inicio'];
  $fecha_fin    = $datos['fecha_fin'];

  $cod_cliente  = $datos['cod_cliente'];
  $cliente      = $datos['nombre'];
  $cod_ubicacion = $datos['cod_ubicacion'];
  $ubicacion     = $datos['ubicacion'];
  $cod_rotacion = $datos['cod_rotacion'];
  $rotacion     = $datos['rotacion'];
  $rotacion_n   = $datos['rotacion_inicio'] +1;
  $excepcion    = $datos['excepcion'];
  $fec_us_ing   = $datos['fec_us_ing'];
  $us_ing       = $datos['us_ing'];
  $fec_us_mod   = $datos['fec_us_mod'];
  $us_mod       = $datos['us_mod'];
}

  $sql_cliente = "SELECT clientes.codigo, clientes.nombre AS cliente
				            FROM pl_cliente, clientes
			             WHERE pl_cliente.cod_cliente = clientes.codigo
				     	       AND pl_cliente.cod_apertura = '$periodoCL'
                     AND clientes.codigo != '$cod_cliente'
				             AND clientes.`status` = 'T'
                   GROUP BY clientes.codigo
			          ORDER BY 2 ASC";

	$sql_ubicacion = "SELECT pl_cliente_det.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
											FROM pl_cliente_det , clientes_ubicacion
										 WHERE pl_cliente_det.cod_cliente = '$cod_cliente'
											 AND pl_cliente_det.cod_ubicacion != '$cod_ubicacion'
                  GROUP BY 1
									ORDER BY 2 ASC ";

  $sql_rotacion = "SELECT rotacion.codigo, rotacion.descripcion,
                          rotacion.abrev, rotacion.`status`
                     FROM rotacion
			           ORDER BY 2 ASC";

   $sql_n_rotacion = "SELECT COUNT(rotacion_det.codigo)
            FROM rotacion_det
          	WHERE rotacion_det.cod_rotacion = '$cod_rotacion'
         ORDER BY 1 ASC";

  ?><form id="form_mod" name="form_mod" action="" method="post"><table width="100%" align="center">
           <tr >
  		     <td height="23" colspan="4" class="etiqueta_title"><div align="center"><?php echo $titulo;?></div></td>
           </tr>
           <tr>
      	       <td height="8" colspan="4"><hr></td>
       	    </tr>
            <tr>
             	<td class="etiqueta" width="15%">Fecha Incio:</td>
             	<td width="35%"><input type="date" name="fecha_desde" id="fecha_desde" style="width:120px" placeholder="Fecha Inicio" value="<?php echo $fecha_inicio;?>" require /></td>
               <td class="etiqueta"width="15%">fecha Fin:</td>
               <td width="35%"><input type="date" name="fecha_hasta" id="fecha_hasta" style="width:120px" placeholder="Fecha Fin" value="<?php echo $fecha_fin;?>" require /></td>
              </tr>

        <tr>
           <td class="etiqueta">Cliente:</td>
           <td><select name="cliente" id="cliente" style="width:220px;"
             onchange="Filtrar_ubicacion(this.value,'ubicacion', 'ubicacionX', '220px', '')" >
              <option value="<?php echo $cod_cliente;?>"><?php echo $cliente;?></option>
           	 <?php
               $query03 = $bd->consultar($sql_cliente);
           	  while($row03=$bd->obtener_fila($query03,0)){
           		  echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           	} ;?></select></td>
           <td class="etiqueta">Ubicacion:</td>
           <td id="ubicacionX"><select name="ubicacion" id="ubicacion" style="width:220px;">
               <option value="<?php echo $cod_ubicacion;?>"><?php echo $ubicacion;?></option>
           <?php
           $query03 = $bd->consultar($sql_ubicacion);
           while($row03=$bd->obtener_fila($query03,0)){
           echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           } ;?></select></td>
          </tr>
        <tr>
          <td class="etiqueta">Rotacion:</td>
          <td><select name="rotacion" id="rotacion" style="width:220px;"
                      onchange="Filtrar_rotacion(this.value, 'rotacion_n', 'posicionX', '220px')" >
             <option value="<?php echo $cod_rotacion;?>"><?php echo $rotacion;?></option>
            <?php
              $query03 = $bd->consultar($sql_rotacion);
             while($row03=$bd->obtener_fila($query03,0)){
               echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           } ;?></select></td>
           <td class="etiqueta">Posicion:</td>
           <td id="posicionX"><select name="rotacion_n" id="rotacion_n" style="width:220px;" >
              <option value="<?php echo $rotacion_n;?>"><?php echo $rotacion_n;?></option>
           	 <?php
               $query03 = $bd->consultar($sql_n_rotacion);
               $row03   = $bd->obtener_fila($query03,0);
               $cantidad =$row03[0];

               for($i = 0; $i < $cantidad; $i++) {
                 $x = $i+1;
             echo '<option value="'.$i.'">'.$x.'</option>';}
              ?></select></td>
        </tr>
        <tr>
          <td class="etiqueta">Excepcion:</td>
          <td>SI <input type = "radio" name="excepcion" id ="excepcion_t"  value = "T" style="width:auto" <?php echo CheckX($excepcion, 'T');?> /> NO <input
          type = "radio" id ="excepcion_f" name="excepcion" value = "F" <?php echo CheckX($excepcion, 'F');?> style="width:auto" /></td>
           <td class="etiqueta"></td>
           <td></td>
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
                  <input type="button" name="actualizar"  id="actualizar" value="<?php echo $evento;?>" onClick="Actualizar()" class="readon art-button" />
                </span>&nbsp;  <span class="art-button-wrapper">
                      <span class="art-button-l"> </span>
                      <span class="art-button-r"> </span>
                  <input type="button" value="Cancelar" onClick="Filtrar()" class="readon art-button" />
                </span>&nbsp;<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>"/><input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo;?>"/>
  </div></form>
