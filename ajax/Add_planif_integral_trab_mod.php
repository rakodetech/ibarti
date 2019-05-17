<link rel="stylesheet" type="text/css" href="../latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="../latest/scripts/autocomplete.js"></script>

<?php
include_once('../funciones/funciones.php');
require "../autentificacion/aut_config.inc.php";
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

$codigo          = $_POST['codigo'];
$usuario        = $_POST['usuario'];
$metodo         = $_POST['metodo'];
$cod_cliente    = $_POST['cod_cliente'];
$cod_ubicacion  = $_POST['cod_ubicacion'];



if($metodo == 'agregar'){

  $sql    = " SELECT * FROM pl_trab_apertura WHERE pl_trab_apertura.`status` = 'T' ";
  $query  = $bd->consultar($sql);
  $datos  = $bd->obtener_fila($query,0);

$titulo   = "Agregar Planificacion De Trabajador";
$evento   = "Ingresar";
$hidden   = "hidden";

$fecha_inicio = $datos['fecha_inicio'];
$fecha_fin    = $datos['fecha_fin'];
$cod_ficha    = '';
$trabajador    = 'Seleccione Un Filtro';

$cod_rotacion  = '';
$rotacion      = 'Seleccione..';
$rotacion_n    = 'Seleccione...';
$excepcion     = '';
$us_ing        = '';
$fec_us_ing    = '';
$us_mod        = '';
$fec_us_mod    = '';

$sql = "SELECT clientes.abrev, clientes.nombre cliente, clientes_ubicacion.descripcion ubicacion
          FROM clientes , clientes_ubicacion
         WHERE clientes.codigo = '$cod_cliente'
           AND clientes_ubicacion.codigo = '$cod_ubicacion' ";
  $query = $bd->consultar($sql);
	$datos = $bd->obtener_fila($query,0);

  $cliente     = $datos['cliente'];
  $ubicacion   = $datos['ubicacion'];

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
  $cod_ficha    = $datos['cod_ficha'];
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


  $sql_trab = "SELECT a.cedula, a.cod_ficha,
                        CONCAT(a.apellidos,' ',a.nombres ) ap_nombre
FROM ficha a
WHERE a.cod_ficha = '$cod_ficha' ";

$query = $bd->consultar($sql_trab);
$datos=$bd->obtener_fila($query,0);

$trabajador   = "($cod_ficha) - ".$datos['ap_nombre']."";


}



  $sql_cliente = "SELECT clientes_ubicacion.cod_cliente, clientes.nombre AS cliente
				      FROM usuario_clientes ,  clientes_ubicacion , clientes
			         WHERE usuario_clientes.cod_usuario = '$usuario'
				       AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
				       AND clientes_ubicacion.`status` = 'T'
				       AND clientes_ubicacion.cod_cliente = clientes.codigo
							  AND clientes_ubicacion.cod_cliente != '$cod_cliente'
				       AND clientes.`status` = 'T'
			      GROUP BY clientes_ubicacion.cod_cliente
			      ORDER BY 2 ASC";

	$sql_ubicacion = "SELECT usuario_clientes.cod_ubicacion, clientes_ubicacion.descripcion AS ubicacion
											FROM usuario_clientes , clientes_ubicacion
										 WHERE usuario_clientes.cod_usuario = '$usuario'
											 AND usuario_clientes.cod_ubicacion = clientes_ubicacion.codigo
											 AND clientes_ubicacion.cod_cliente = '$cod_cliente'
											 AND clientes_ubicacion.codigo != '$cod_ubicacion'
											 AND clientes_ubicacion.`status` = 'T'
									ORDER BY 2 ASC ";

  $sql_rotacion = "SELECT rotacion.codigo, rotacion.descripcion,
                          rotacion.abrev, rotacion.`status`
                     FROM rotacion
			           ORDER BY 2 ASC";

   $sql_n_rotacion = "SELECT COUNT(rotacion_det.codigo)
            FROM rotacion_det
          	WHERE rotacion_det.cod_rotacion = '$cod_rotacion'
         ORDER BY 1 ASC";

  ?><form id="form_trab_mod" name="form_trab_mod" action="" method="post"><table width="100%" align="center">
           <tr >
  		     <td height="23" colspan="4" class="etiqueta_title"><div align="center"><?php echo $titulo;?></div></td>
           </tr>
           <tr>
      	       <td height="8" colspan="4"><hr></td>
       	    </tr>
            <tr>
              <td class="etiqueta" width="15%">Filtro Trab.:</td>
              <td width="35%"><div class="rowBuscar">
              	<div><input id="filtroTrab" type="text" width="120px" Title="Buscar Por: (Ficha, Cedula ó Trabajador) " placeholder=" Filtro: (Ficha, Cedula ó Trabajador) "></div>
              	<div><img src="imagenes\buscar.bmp" alt="Buscar Trabajador" Title="Minino 3 Caracteres " onclick="BuscarTrab()"  width="25px" height="25px"></div>
                </div></td>
               <td class="etiqueta"width="15%"><?php echo $leng["trabajador"];?>:</td>
               <td width="35%" id="trab_trabajadorX"><select name="trab_trabajador" id="trab_trabajador" style="width:220px;">
                  <option value="<?php echo $cod_trabajador;?>"><?php echo $trabajador;?></option>
               	 </select></td>
            </tr>
            <tr>
             	<td class="etiqueta" width="15%">Fecha Incio:</td>
             	<td width="35%"><input type="date"  id="trab_fecha_desde" style="width:120px" placeholder="Fecha Inicio" value="<?php echo $fecha_inicio;?>" require /></td>
               <td class="etiqueta"width="15%">fecha Fin:</td>
               <td width="35%"><input type="date" id="trab_fecha_hasta" style="width:120px" placeholder="Fecha Fin" value="<?php echo $fecha_fin;?>" require /></td>
            </tr>

        <tr>
           <td class="etiqueta">Cliente:</td>
           <td><select name="trab_cliente" id="trab_cliente" style="width:220px;"
             onchange="Filtrar_ubicacion(this.value,'trab_ubicacion', 'trab_ubicacionX', '220px', '')" >
              <option value="<?php echo $cod_cliente;?>"><?php echo $cliente;?></option>
           	 <?php
               $query03 = $bd->consultar($sql_cliente);
           	  while($row03=$bd->obtener_fila($query03,0)){
           		  echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           	} ;?></select></td>
           <td class="etiqueta">Ubicacion:</td>
           <td id="trab_ubicacionX"><select name="trab_ubicacion" id="trab_ubicacion" style="width:220px;">
               <option value="<?php echo $cod_ubicacion;?>"><?php echo $ubicacion;?></option>
           <?php
           $query03 = $bd->consultar($sql_ubicacion);
           while($row03=$bd->obtener_fila($query03,0)){
           echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           } ;?></select></td>
          </tr>
        <tr>
          <td class="etiqueta">Rotacion:</td>
          <td><select name="trab_rotacion" id="trab_rotacion" style="width:220px;"
                      onchange="Filtrar_rotacion(this.value, 'trab_rotacion_n', 'trab_posicionX', '220px')" >
             <option value="<?php echo $cod_rotacion;?>"><?php echo $rotacion;?></option>
            <?php
              $query03 = $bd->consultar($sql_rotacion);
             while($row03=$bd->obtener_fila($query03,0)){
               echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
           } ;?></select></td>
           <td class="etiqueta">Posicion:</td>
           <td id="trab_posicionX"><select name="trab_rotacion_n" id="trab_rotacion_n" style="width:220px;" >
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
          <td>SI <input type = "radio" name="trab_excepcion" id ="trab_excepcion_t"  value = "T" style="width:auto" <?php echo CheckX($excepcion, 'T');?> /> NO <input
          type = "radio" id ="trab_excepcion_f" name="trab_excepcion" value = "F" <?php echo CheckX($excepcion, 'F');?> style="width:auto" /></td>
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
                  <input type="button" name="actualizar"  id="actualizar" value="<?php echo $evento;?>" onClick="ActualizarTrab()" class="readon art-button" />
                </span>&nbsp;  <span class="art-button-wrapper">
                      <span class="art-button-l"> </span>
                      <span class="art-button-r"> </span>
                  <input type="button" value="Cancelar" onClick="CancelarPlanifTrab()" class="readon art-button" />
                </span>&nbsp;<input type="hidden" id="trab_codigo" value="<?php echo $codigo;?>"/><input type="hidden" id="trab_metodo" value="<?php echo $metodo;?>"/>
  </div></form>


  <script type="text/javascript">

  r_cliente = "";
  r_rol     = "";
  usuario   = "";
    filtroValue = $("#paciFiltro").val();

      new Autocomplete("stdName", function() {
          this.setValue = function(id) {
            document.getElementById("stdID").value = id;
          }
          if (this.isModified) this.setValue("");
          if (this.value.length < 3) return ;
            return "autocompletar/tb/trabajador.php?q="+this.text.value +"&filtro="+filtroValue+"&r_cliente="+r_cliente+"&r_rol="+r_rol+"&usuario="+usuario+"";
          });
  </script>
