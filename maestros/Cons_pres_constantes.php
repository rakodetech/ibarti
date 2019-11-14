<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$Nmenu = 331; 
$archivo = "pres_constantes&Nmenu=".$Nmenu."";
$tabla   = "pres_variables";
require_once('autentificacion/aut_verifica_menu.php');

$ascx      = $_GET['ascx'];
$orden = $_GET['orden'];
		if($ascx == 'S'){
			$asc = "ASC";
			$ascx = "N"; 
		}else{
			$asc  = "DESC";
			$ascx = "S";	
		}	 

	 if(isset($orden) && $orden !=''){	

	   $sql01 =	"SELECT a.co_cli, a.tipo, a.cli_des, a.direc1, a.direc2, a.telefonos, a.fax, a.inactivo,
						a.juridico, a.respons, a.mont_cre, a.plaz_pag, a.co_zon, a.co_seg, a.co_ven, a.status
				    FROM clientes AS a  ORDER BY ".$orden." ".$asc."";
		 
	 }else{
	 
	   $sql01 =	" SELECT pres_constantes.codigo, pres_constantes.cod_variables_tipo,
                         pres_constantes.valor, pres_constantes.caracteres,
                         pres_constantes.fecha, pres_constantes.descripcion,
                         pres_constantes.`status`
                    FROM pres_constantes
                   ORDER BY 2 DESC ";
	 }
?>
<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL DE CONSTANTES </div> 
<hr />
<br/>
	<table width="90%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta"><span class="etiqueta">C&oacute;digo</span></th>
			<th width="40%" class="etiqueta"><span class="etiqueta">Descripcion</span></th>
            <th width="20%" class="etiqueta"><span class="etiqueta">Valor</span></th>
			<th width="20%" class="etiqueta"><span class="etiqueta">Status</span></th>
		    <th width="10%"><a href="inicio.php?area=maestros/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a>
            </th> 
		</tr>
    <?php       
        // Instanciamos el objeto
        $paging = new PHPPaging;
        $paging->porPagina(16);
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta($sql01);
        
        // Ejecutamos la paginación
        $paging->ejecutar();         
        // Imprimimos los resultados, para esto creamos un ciclo while
        // Similar a while($datos = mysql_fetch_array($sql))
        while($datos = $paging->fetchResultado()) { 
			if ($valor == 0){
		$fondo = 'fondo01';
		$valor = 1;
	}else{
		 $fondo = 'fondo02';
		 $valor = 0;
	}
        echo '<tr class="'.$fondo.'"> 
                  <td class="texto">'.$datos[0].'</td> 
                  <td class="texto">'.$datos['descripcion'].'</td>
				  <td class="texto">'.$datos[2].'</td>
           	      <td class="texto">'.statuscal($datos["status"]).'</td> 
			      <td width="15%" align="center">
				  <a href="inicio.php?area=maestros/Mod_'.$archivo.'&codigo='.$datos[0].'"><img src="imagenes/actualizar.bmp" alt="Detalle" title="Detalle Registro" width="30" height="30" border="null"/></a> 


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