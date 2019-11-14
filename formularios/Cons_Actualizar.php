<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);
$tabla   = "control";
?>
<br>
<div align="center" class="etiqueta_title"> CONSULTA GENERAL CONTROL DE SISTEMA</div> 
<hr />
<br/>
	<table width="98%" border="0" align="center">
		<tr bgcolor="#CCCCCC">
			<th class="etiqueta">Clientes</th>
			<th class="etiqueta">Trabajadores</th>
			<th class="etiqueta">Concepto</th>			
			<th class="etiqueta">Regiones</th>
			<th class="etiqueta">Cargos</th>
			<th class="etiqueta">Bancos</th>
			<?php /*	
			<th width="15%" class="etiqueta">Status</th> 		
		    <th width="15%"> 
			 <a href="inicio.php?area=maestros/Add_<?php echo $archivo?>"><img src="imagenes/nuevo.bmp" 
			alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> */?>
		</tr>
    <?php
    
        // Apertura de la conexión a la base de datos e Inclusión del script
        
        // Instanciamos el objeto
        $paging = new PHPPaging;
        $paging->porPagina(12);
        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta("SELECT * FROM $tabla");
        
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
                  <td>'.$datos["clientes"].'</td> 
                  <td>'.$datos["snemple"].'</td>	
				  <td>'.$datos["snvaria"].'</td>
				  <td>'.$datos["sndepart"].'</td>
				  <td>'.$datos["cargos"].'</td>
				  <td>'.$datos["bancos"].'</td>';/*
           	      <td>'.statuscal($datos[2]).'</td> 
			      <td width="15%" align="center"><a href="inicio.php?area=maestros/Mod_'.$archivo.'&id='.$datos[0].'"><img src="imagenes/detalle.bmp" alt="Detalle" title="Detalle Registro" width="30" height="30" border="null"/></a>
         <a onClick="ConfirmacionS('.$confir.')"><img class="imgLink" src="imagenes/borrar.bmp" alt="Eliminar" title="Eliminar Registro" width="30" height="30" border="null"/></a>	
		          </td> 								
            </tr>'; */
        }     
    ?>
	</table>	

<br/>
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
//    echo $paging->fetchNavegacion(),' <b>Navegación</b>:';
?>
</div>
<?php 
$Nmenu = 406; 
$archivo = "Ubicacion_Cliente&id=".$id."&Nmenu=".$Nmenu."";
$tabla   = "";
require_once('autentificacion/aut_verifica_menu.php');
?>
<br>
<div align="center" class="etiqueta_title"> ACTUALIZACION DE INFORMACION </div> 
<hr />
<div id="Contendor01" class="mensaje"></div>
<fieldset>
	<legend>Subir Archivos</legend>	
	<br />
	<form action="scripts/sc_Actualizar_Archivos.php" method="post" name="form1" enctype="multipart/form-data"> 
   <table width="70%" align="center">
      <tr>
        <td class="etiqueta" width="25%">Procesos:</td>
 		<td  id="select01" width="75%">
		<select name="archivo"  style="width:250px;">
          <option value=""> Seleccione...</option> 
		  <option value="clientes"> clientes.xml (Clientes)</option>
		  <option value="snemple"> snemple.xml (Trabajadores)</option>	  
		 <!--<option value="ficha_trab"> snemple.xml (Ficha Trabajador)</option>-->
		  <option value="snvaria"> snvaria.xml (Concepto)</option>
		  <option value="sncargos"> sncargos.xml (Cargos)</option>
  	      <option value="sndepart"> sndepart.xml (Regiones &oacute; Departamento)</option>
          <option value="snbanco"> snbanco.xml (Bancos)</option>
       </select>
 		  <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
       	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
      </tr>
	  <tr>
		  <td class="etiqueta" >Archivo:</td>		   
		  <td id="input01"><input type="file" name="file" size="35"><br />	  
			<img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br>
			<span class="textfieldRequiredMsg">Debe De Selecionar Un Archivo.</span>
			<span class="textfieldMinCharsMsg">Debe Escribir mínimo 2 Caracteres.</span></td>
    </tr>
	<tr>
	<td colspan="2" align="center"><br /><input name="boton" type="submit" id="boton" value="Enviar"> 								 
										 <input type="hidden" name="href" value="../inicio.php?area=formularios/Cons_Actualizar&Nmenu=406"/>
	</td>
	</tr>
</table>
</form> 
</fieldset>
<script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {minChars:2, validateOn:["blur", "change"]});
var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});
</script>