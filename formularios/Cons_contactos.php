<?php 
	$Nmenu = '432'; 
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "contactos";
	$bd = new DataBase();
	$archivo = "contactos";
	$titulo = " CONTACTOS CLIENTES ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&titulo=$titulo&tb=$tabla&archivo=$archivo";
	
	if (isset($_GET['cod_status'])){
	    	$cod_status = $_GET['cod_status'];
	$sql01 = "SELECT preing_status.codigo AS cod_status, preing_status.descripcion AS status
               FROM preing_status
              WHERE preing_status.codigo = '$cod_status'";

	}else{
	$sql01 = "SELECT preing_status.codigo AS cod_status, preing_status.descripcion AS status
               FROM control , preing_status
              WHERE control.preingreso_nuevo = preing_status.codigo";
		
	}	

	$query01 = $bd->consultar($sql01);		
    $row02   = $bd->obtener_fila($query01,0);
	$cod_status = $row02[0]; 
    $status     = $row02[1];
?>
<script language="JavaScript" type="text/javascript">
function FiltarStatus(ValorN){
	var mod = document.getElementById("mod").value;	
	var Nmenu = document.getElementById("Nmenu").value;
	var href = "inicio.php?area=formularios/Cons_ingreso&Nmenu="+Nmenu+"&mod="+mod+"&cod_status="+ValorN+"";
	window.location.href=""+href+"";		
	//alert(href);
}
</script>	
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<?php /*
<fieldset>
<legend>Filtros:</legend>
	<table width="98%">
		<tr><td width="10%">Status: </td>
			<td width="40%"><select  name="status" id="status" style="width:200px;" onchange="FiltarStatus(this.value)">
					<option value="<?php echo $cod_status?>"><?php echo $status; ?></option> 
					<?php 
				$sql01 = "SELECT preing_status.codigo, preing_status.descripcion
                            FROM preing_status 
						   WHERE preing_status.`status` = 'T' AND preing_status.codigo <> '$ing_nuevo'
					    ORDER BY 2 ASC";
	   			$query01 = $bd->consultar($sql01);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td width="50%">&nbsp; 
            <input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
             </td>
</tr>
</table>
</fieldset>  */ ?>
<div id="listar"><table width="98%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">Fecha</th>
			<th width="30%" class="etiqueta">Cliente</th>
  			<th width="20%" class="etiqueta">Representante</th>
            	<th width="20%" class="etiqueta">Status Contacto</th>
            <th width="20%" class="etiqueta">Status Negocio</th>
		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT v_contacto.fecha, v_contacto.cod_cliente,
					v_contacto.cliente, v_contacto.periodo,
					v_contacto.representante, v_contacto.cargo,
					v_contacto.telefono, v_contacto.descripcion,
					v_contacto.status_negocio, v_contacto.cod_status,
					v_contacto.`status`, v_contacto.cod_status_negocio
               FROM v_contacto ORDER BY 1 ASC";

   $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                  <td class="texo">'.$datos["fecha"].'</td> 
                  <td class="texo">'.$datos["cliente"].'</td>
				  <td class="texo">'.$datos["representante"].'</td>
				  <td class="texo">'.$datos["status_negocio"].'</td>
				  <td class="texo">'.$datos["status"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&cliente='.$datos['cod_cliente'].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';?>
    </table>   
</div>

