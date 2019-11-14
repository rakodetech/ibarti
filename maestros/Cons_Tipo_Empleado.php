<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$Nmenu = 308; 
$archivo = "Tipo_Empleado&Nmenu=".$Nmenu."";
$tabla   = "tipo_empleado";
require_once('autentificacion/aut_verifica_menu.php');
?>
<script language="JavaScript" type="text/javascript">

function ConfirmacionS(idX){

	if (confirm("¿ Esta Seguro De Borrar Este Archivo?")) {

//var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
var valor = "sc_maestros/sc_mantenimiento.php"; 
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function()  
			{ 
				if (ajax.readyState==4)
				{
		        //document.getElementById("Contendor01").innerHTML = ajax.responseText;
				//window.location.href=""+href+"";
				  window.location.reload();				

				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("id="+idX+"&metodo=Eliminar&archivo=<?php echo $archivo?>&tabla=<?php echo $tabla?>");
    }	
}
</script>

<br>
<div align="center" class="etiqueta_title"> CONSULTA TIPO DE EMPLEADO </div> 
<hr />
<br/>
	<table width="75%" border="0" align="center">
		<tr class="fondo00">
			<th width="15%" class="etiqueta">C&oacute;digo</th>
			<th width="50%" class="etiqueta">Descripci&oacute;n</th>
			<th width="15%" class="etiqueta">Status</th>			
		    <th width="15%"><a href="inicio.php?area=maestros/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> 
		</tr>
    <?php    
        // Apertura de la conexión a la base de datos e Inclusión del script
        
        // Instanciamos el objeto
        $paging = new PHPPaging;
        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta("SELECT * FROM $tabla ORDER BY descripcion ASC");
        
        // Ejecutamos la paginación
        $paging->ejecutar();  
        
        // Imprimimos los resultados, para esto creamos un ciclo while
         while($datos = $paging->fetchResultado()) { 
			if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}
  	   $confir = "'".$datos[0]."'";
        echo '<tr class="'.$fondo.'"> 
                  <td class="texto">'.$datos[0].'</td> 
                  <td class="texto">'.$datos[1].'</td> 
           	      <td class="texto">'.statuscal($datos[2]).'</td> 
			      <td width="15%" align="center"><a href="inicio.php?area=maestros/Mod_'.$archivo.'&id='.$datos[0].'"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="30" height="30" border="null"/></a>
         <a onClick="ConfirmacionS('.$confir.')"><img class="imgLink" src="imagenes/borrar.bmp" alt="Eliminar" title="Eliminar Registro" width="30" height="30" border="null"/></a>	
		          </td> 								
            </tr>'; 
        }     
    ?>
	</table>	

<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();
?>
</div>
