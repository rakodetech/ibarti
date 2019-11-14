<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$Nmenu    = 421; 
$tabla    = "ind_recibo_pago";
$codigo   = $_GET['codigo'];
$region   = $_GET['region'];
$titulo   = " INDICADOR DE RECIBO DE PAGO FECHA: ".Rconversion($codigo)."";
$archivo2 = " ";
$archivo  = "ind_recibo_pago&Nmenu=".$Nmenu."";
require_once('autentificacion/aut_verifica_menu.php');

	if(($region  != "") &&($region  != "TODAS" )){
	$sql01 = "                    SELECT ind_recibo_pago.codigo_region,  regiones.descripcion AS region,
										 ind_recibo_pago.codigo_trabajador, trabajadores.nombres AS trabajador,
										 trabajadores.telefonos,
										 ind_recibo_pago.recibo, f_repuesta(ind_recibo_pago.recibo)
									FROM ind_recibo_pago , regiones , trabajadores
								   WHERE ind_recibo_pago.codigo_region =  regiones.id 
								 	 AND ind_recibo_pago.codigo_trabajador =  trabajadores.cod_emp 
									 AND ind_recibo_pago.codigo =  '$codigo'
									 AND regiones.id = '$region'
								   ORDER BY 2, 4";
								   
	}else{
	$sql01 = "                    SELECT ind_recibo_pago.codigo_region,  regiones.descripcion AS region,
										 ind_recibo_pago.codigo_trabajador, trabajadores.nombres AS trabajador,
										 trabajadores.telefonos,
										 ind_recibo_pago.recibo, f_repuesta(ind_recibo_pago.recibo)
									FROM ind_recibo_pago , regiones , trabajadores
								   WHERE ind_recibo_pago.codigo_region =  regiones.id 
								 	 AND ind_recibo_pago.codigo_trabajador =  trabajadores.cod_emp 
									 AND ind_recibo_pago.codigo =  '$codigo'
								   ORDER BY 2, 4 ";
	}		
?>
<br>
<div align="center" class="etiqueta_title"> <?php echo $titulo ?></div> 

<hr />
<fieldset>
<legend>Filtro Por Region:</legend>
<select  id="nomina" style="width:235px;" onchange="FiltroRegion(this.value)"> 
<option value="">Seleccione...</option>
<option value="TODAS">TODAS</option>
<?php  
						   
			   $query03 = mysql_query("SELECT DISTINCT ind_recibo_pago.codigo_region, regiones.descripcion AS region
                                         FROM ind_recibo_pago , regiones 
									    WHERE ind_recibo_pago.codigo_region =  regiones.id 
										  AND ind_recibo_pago.codigo =  '$codigo' ORDER BY 2 ASC", $cnn);
			   while($row03=(mysql_fetch_array($query03))){							
					 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';						   		
			   }?>
			</select>&nbsp;&nbsp;<?php echo $fechN; ?> 
</fieldset>
<div id="Contenedor01"></div>
<br/>
	<table width="98%" border="0" align="center">
		<tr bgcolor="#CCCCCC">
			<th width="25%" class="etiqueta">Region</th>
			<th width="10%" class="etiqueta">Codigo Trabajador. </th>
			<th width="30%" class="etiqueta">Trabajador</th>
			<th width="17%" class="etiqueta">Telefonos</th>
			<th width="11%" class="etiqueta">Recibo</th>
		    <th width="9%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" 
			                     title="Agregar Registro" border="null" />
			 <!--<a href="inicio.php?area=formularios/Add_<?php echo $archivo?>"><img src="imagenes/loading2.gif" 
			alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a> --></th> 
		</tr>
    <?php   
         // Instanciamos el objeto
        $paging = new PHPPaging;        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta($sql01);        
        // Ejecutamos la paginación
        $paging->ejecutar();          
        // Imprimimos los resultados, para esto creamos un ciclo while
        $i = 0;
         while($datos = $paging->fetchResultado()) { 
		$i++;
		
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
		 		$fondo = 'fondo02';
		 		$valor = 0;		
			}
		
	   $conf = "Actualizar('".$i."', '".$codigo."', '".$datos[0]."', '".$datos[2]."','".$usuario."')";
        echo '<tr class="'.$fondo.'"> 
                  <td>'.utf8_decode($datos[0]).' - '.utf8_decode($datos[1]).'</td>
				  <td>'.utf8_decode($datos[2]).'</td>
				  <td>'.utf8_decode($datos[3]).'</td>
				  <td>'.utf8_decode($datos[4]).'</td>
			      <td>
				  
				  <select id="recibo'.$i.'" name ="recibo" style="width:90px;">	 
							   <option value="'.$datos[5].'">'.utf8_decode($datos[6]).'</option>
							   <option value="N">NO</option>
							   <option value="S">SI</option>
							   <option value="I">INDEFINIDO</option>
				</select>
				  </td>
			      <td width="15%" align="center"><img src="imagenes/actualizar.bmp" alt="Modificar"title="Modificar Registro" width="25" height="25" border="null" class="imgLink" onclick="'.$conf.'"/></td> 								
            </tr>'; 
        }  /*
			<a href="inicio.php?area=formularios/Mod_'.$archivo.'&codigo='.$datos[0].'"><img src="imagenes/detalle.bmp" 
			   alt="Modificar"  title="Modificar Registro" width="25" height="25" border="null"/></a>
              <img src="imagenes/borrar.bmp" onClick="'.$conf.'" class="imgLink" alt="Eliminar" title="Eliminar Registro" width="25" height="25" border="null"/>	
	*/	
	?>
	
	<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>"  />
	<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>" />
	
	</table>	
<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();
?>
</div>

<script language="javascript" type="text/javascript">


function FiltroRegion(ValorN){
var href = "inicio.php?area=formularios/Mod_<?php echo $archivo;?>&codigo=<?php echo $codigo;?>&page=<?php echo $_GET['page'];?>&region="+ValorN+"";
window.location.href=""+href+"";		
//alert(href);	
}	

function Actualizar(auto,  codigo, region, trab, usuario){
	var recibo   = document.getElementById("recibo"+auto+"").value;
			//var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
		var valor = "scripts/sc_ind_recibo_pago.php"; 
				ajax=nuevoAjax();
					ajax.open("POST", valor, true);
					ajax.onreadystatechange=function()  
					{ 
						if (ajax.readyState==4)
						{
						document.getElementById("Contenedor01").innerHTML = ajax.responseText;
						//window.location.href=""+href+"";							 	
						}
					}
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("codigo="+codigo+"&region="+region+"&usuario="+usuario+"&trabajador="+trab+"&recibo="+recibo+"&metodo=Modificar");
}   		
</script>