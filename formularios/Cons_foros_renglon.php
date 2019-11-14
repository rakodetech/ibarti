<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging   = new PHPPaging($cnn);
$codigo   = $_GET['codigo'];
$Nmenu    = 427; 
$tabla    = "foros_renglon";
$titulo   = " FOROS ";
$archivo2 = "";
$archivo  = "foros_renglon&codigo=".$codigo."&Nmenu=".$Nmenu."";
require_once('autentificacion/aut_verifica_menu.php');

mysql_query("SET NAMES utf8");
$result01 = mysql_query("SELECT foros.codigo, foros.cod_autor,
                                regiones.descripcion AS region,
                                foros_categoria.descripcion AS categoria,
                                foros.asunto as titulo, foros.mensaje,
                                foros.`status`, foros.fec_us_ing,
								usuarios.cedula,
                                CONCAT(usuarios.apellido,' ',usuarios.nombre) As autor,
								trabajadores.nombres AS trabajador
						   FROM foros , regiones , foros_categoria, oesvica_sistema.usuarios, trabajadores 
						  WHERE foros.cod_region = regiones.id 
							AND foros.cod_categoria = foros_categoria.id
							AND foros.codigo = '$codigo'
							AND foros.cod_autor = usuarios.cedula 
							AND foros.cod_emp = trabajadores.cod_emp ", $cnn)or die
								 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');  
$row01    = mysql_fetch_array($result01);

?>
  <fieldset >
  <legend>Foro: <?php echo $row01['titulo']; ?>  </legend>
	<table width="90%">
        <tr>
            <td width="17%">Fecha:</td>
            <td width="33%" class="texto"><?php echo $row01['fec_us_ing']; ?></td>
            <td width="17%">Region:</td>
            <td width="33%" class="texto"><?php echo $row01['region']; ?></td>
        </tr>
        <tr>
            <td>Autor:</td>
            <td class="texto"><?php echo $row01['autor']; ?></td>
            <td>Categoria:</td>
            <td class="texto"><?php echo $row01['categoria']; ?></td>
        </tr>
        <tr>
            <td>Trabajador:</td>
            <td  class="texto"><?php echo $row01['trabajador']; ?></td>
            <td>Titulo:</td>
            <td  class="texto"><?php echo $row01['titulo']; ?></td>
        </tr>
        <tr>
            <td>Status:</td>            
            <td  class="texto"><?php echo statuscal($row01['status']); ?></td>
            <td>Mensaje:</td>
            <td  class="texto"><?php echo $row01['mensaje']; ?></td>
        </tr>        
    </table>
</fieldset>
<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL <?php echo $titulo ?></div> 
<hr />
<div id="Contenedor01"></div>
<br/>
	<table width="99%" border="0" align="center">
		<tr bgcolor="#CCCCCC">
			<th width="15%" class="etiqueta">Fecha / Usuario</th>
			<th width="25%" class="etiqueta">Asunto</th>
			<th width="40%" class="etiqueta">Mensaje</th>
            <th width="12%" class="etiqueta">Cita o Notificaci&oacute;n</th>
		    <th width="8%"><a href="inicio.php?area=formularios/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" 
			alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> 
		</tr>
    <?php   
         // Instanciamos el objeto
        $paging = new PHPPaging;        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta(" SELECT foros_renglon.codigo, foros_renglon.fec_us_ing,
                                          CONCAT(usuarios.apellido, ' ', usuarios.nombre) AS usuario,  
                                          foros_renglon.asunto, foros_renglon.mensaje,
										  foros_renglon.cita, foros_renglon.cita_fecha, foros_renglon.cita_hora
                                     FROM foros_renglon, oesvica_sistema.usuarios 
                                    WHERE foros_renglon.codigo_foro = '$codigo'
                                      AND foros_renglon.cod_us_ing = usuarios.cedula ");        
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
	   $conf = "Borrar01('".$datos[0]."')";
        echo '<tr class="'.$fondo.'"> 
                 <td>'.Rconversion($datos['fec_us_ing']).' <br />'.$datos['usuario'].'</td></td>
				  <td>'.$datos['asunto'].'</td>
				  <td>'.$datos['mensaje'].'</td>
			      <td>';   if($datos['cita'] == "S"){ echo "".$datos['cita_fecha']."<br/>".$datos['cita_hora'].""; }   echo '</td>
			      <td  align="center">				
			<a href="inicio.php?area=formularios/Mod_'.$archivo.'&codigo='.$datos[0].'"><img src="imagenes/actualizar.bmp" 
			   alt="Modificar"  title="Modificar Registro" width="25" height="25" border="null"/></a>
              
      	          </td> 								
            </tr>'; 
        }     
    /*  
	<img src="imagenes/borrar.bmp" onClick="'.$conf.'" class="imgLink" alt="Eliminar" title="Eliminar Registro" width="25" height="25" border="null"/>	
	 <a onClick="ConfirmacionS('.$confir.')"><img src="imagenes/borrar.bmp" alt="Eliminar" title="Eliminar Registro" width="30" height="30" border="null"/></a>*/	
	?>
	<input type="hidden" id="tabla" value="<?php echo $tabla;?>" />
	</table>	
<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();
?>
</div>