<?php /*



<!-- <script type="text/javascript" src="latest/scripts/autocomplete.js"></script> -->
<script language="JavaScript" type="text/javascript">

function Cons_ubic(cod, metodo){
	ModalOpen();
		$("#modal_title").text(" Agregar <?php echo $leng['ubicacion'];?>");

		var usuario      = $("#usuario").val();
		var cliente      = $("#codigo").val();

		var error        = 0;
		var errorMessage = ' ';
		  if(error == 0){
		    var parametros = { "codigo" : cod,      "cliente": cliente,
				                   "metodo": metodo,    "usuario": usuario   };
		      $.ajax({
		          data:  parametros,
		          url:   'pestanas/add_clientes_ubic.php',
		          type:  'post',
		          success:  function (response) {

              $("#contenido_modal").html(response);
							iniciar_tab(0);

		          },
		          error: function (xhr, ajaxOptions, thrownError) {
		              alert(xhr.status);
		              alert(thrownError);}
		            });
		  }else{
		    alert(errorMessage);
		  }

}
</script>
<?php
	$cliente = $codigo;
	$tabla   = "clientes_ubic";
	$bd      = new DataBase();
	$archivo = "clientes_ubic";
	$titulo  = " ".$leng['cliente']." ".$leng['ubicacion']."";
//	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&cliente=$cliente&archivo=$archivo";

	$sql     = " SELECT clientes.nombre FROM clientes  WHERE clientes.codigo = '$cliente'";
  $query   = $bd->consultar($sql);
  $datos   = $bd->obtener_fila($query,0);
?>

<div id="Contenedor01"></div>
<div class="tabla_sistema"><table width="100%">
		<tr>
			<th width="20%">Sucursal</th>
  		<th width="20%"><?php echo $leng['estado']?></th>
      <th width="20%"><?php echo $leng['ciudad']?></th>
   		<th width="20%">Calendario</th>
      <th width="10%" >Status</th>
		  <th width="10%"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_ubic('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php

	$valor = 0;
	$sql = " SELECT clientes_ubicacion.codigo,
	                clientes_ubicacion.cod_estado, estados.descripcion AS estado,
					clientes_ubicacion.cod_ciudad, ciudades.descripcion AS ciudad,
                    clientes_ubicacion.cod_region, regiones.descripcion AS region,
                    clientes_ubicacion.cod_calendario, nom_calendario.descripcion AS calendario,
                    clientes_ubicacion.descripcion, clientes_ubicacion.direccion,
                    clientes_ubicacion.contacto, clientes_ubicacion.telefono,
                    clientes_ubicacion.email,
					clientes_ubicacion.campo01, clientes_ubicacion.campo02,
					clientes_ubicacion.campo03, clientes_ubicacion.campo04,
					clientes_ubicacion.`status`
               FROM clientes_ubicacion, estados,  ciudades , regiones, nom_calendario
              WHERE clientes_ubicacion.cod_estado = estados.codigo
			    AND clientes_ubicacion.cod_ciudad = ciudades.codigo
			    AND clientes_ubicacion.cod_region = regiones.codigo
                AND clientes_ubicacion.cod_calendario = nom_calendario.codigo
				AND clientes_ubicacion.cod_cliente = '$cliente'
			  ORDER BY 5, 3 DESC ";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr>
                <td>'.longitudMax($datos["descripcion"]).'</td>
				  			<td>'.longitudMax($datos["estado"]).'</td>
				  			<td>'.longitudMax($datos["ciudad"]).'</td>
                <td>'.longitudMax($datos["calendario"]).'</td>
				  			<td>'.statuscal($datos["status"]).'</td>
				  			<td><img onclick="Cons_ubic(\''.$datos[0].'\', \'modificar\')" src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
<div align="center"><br/>
	<span class="art-button-wrapper">
				 <span class="art-button-l"> </span>
				 <span class="art-button-r"> </span>
		 <input type="button" id="volver" value="Volver" onClick="Cons_cliente_inicio()" class="readon art-button" />
		 </span>
		</div>

*/ ?>
