<script language="javascript" type="text/javascript">
	function Actualizar01(){
		var codigo     = document.getElementById("cliente").value;  // CLIENTE
		var Nmenu     = document.getElementById("Nmenu").value;

		var Contenedor = "Contenedor01";
		var valor      = "ajax/pres_cotizacion.php"; 			
				
		if ((codigo != "")){
		Vinculo("inicio.php?area=formularios/Cons_pres_cotizacion&Nmenu="+Nmenu+"&codigo="+codigo+"");
		}
	}	
</script>
<?php 
$Nmenu     = 431; 
$codigo    = $_GET['codigo'];
//$archivo = "concepto_profit&Nmenu=".$Nmenu."&id=".$codigo."";
$archivo = "pres_clientes_variables&Nmenu=".$Nmenu."&id=".$codigo."";
require_once('autentificacion/aut_verifica_menu.php');
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

	$SQL_PAG = " SELECT pres_cotizacion.cod_cargo, pres_cargo_salario.descripcion AS cargo,
                        pres_cotizacion.cod_rol, pres_rol.descripcion AS rol,
                        pres_cotizacion.valor
                   FROM pres_cotizacion, pres_cargo_salario,  pres_rol
                  WHERE pres_cotizacion.cod_cargo = pres_cargo_salario.codigo 
                    AND pres_cotizacion.cod_rol = pres_rol.codigo 
                    AND pres_cotizacion.cod_cliente = '$codigo' ORDER BY 2 ASC ";
/*
$result01 = mysql_query("SELECT snvaria.abrev, snvaria.des_var FROM snvaria WHERE snvaria.co_var = '$codigo'", $cnn);  
$row01    = mysql_fetch_array($result01);
*/
?>
<form id="form01" name="form01" action="scripts/sc_pres_cotizacion.php" method="post">
  <fieldset class="fieldset">
  <legend>FILTROS POR CLIENTES:  COTIZACION </legend>
     <table width="98%" align="center">
     <tr>
      <td class="etiqueta">CLIENTES:</td>
      	<td  id="select01"><select name="cliente" id="cliente" style="width:240px" onchange="Actualizar01()">
							
          <?php 
				if($codigo != ""){
                 $query05 = mysql_query("SELECT pres_clientes.codigo, pres_clientes.descripcion
                                           FROM pres_clientes
                                          WHERE pres_clientes.codigo = '$codigo'
										  ORDER BY 2 ASC",$cnn);	
				  $row05=mysql_fetch_array($query05);			

				echo '<option value="'.$row05[0].'">'.$row05[1].'</option>';									
				}else{
				echo '<option value="">SELECCIONE...</option>';					
				}						  	
		  
		  		 $query05 = mysql_query("SELECT pres_clientes.codigo, pres_clientes.descripcion
                                           FROM pres_clientes
                                          WHERE pres_clientes.`status` = '1'
										  ORDER BY 2 ASC",$cnn);
						  while($row05=mysql_fetch_array($query05)){					   					
		  ?>
          <option value="<?php echo $row05[0];?>"><?php echo utf8_decode($row05[1]);?></option>
          <?php }?>		  	  
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span>
      </td>
      <td class="etiqueta">&nbsp;</td>
        <td class="etiqueta">&nbsp;</td>
    </tr>
	 <tr> 
		<td height="8" colspan="4" align="center"><hr></td>
	 </tr>
   	 <tr> 
		<td colspan="4" id="Contenedor01"></td>
        </tr>
  </table>
	<table width="75%" border="0" align="center">	
		<tr bgcolor="#CCCCCC">
			<th width="40%" class="etiqueta">Cargo</th>		
			<th width="30%" class="etiqueta">Rol</th>			
   			<th width="18%" class="etiqueta">Cantidad</th>
			<th width="12%"><img src="imagenes/loading2.gif"/></th> 
		</tr> 
     <?php	
	        echo '<tr bgcolor="#CCCCCC">			              
			      <td id="select02"> 
				  <select name="cargo" id="cargo" style="width:250px;"> 
					      <option value="">seleccione...</option>';	//  CARGO						   
						   $query03 = mysql_query("SELECT codigo, descripcion
													 FROM pres_cargo_salario WHERE `status` = 1 ORDER BY 2 ASC", $cnn);
						   while($row03=(mysql_fetch_array($query03))){							  		
								 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
				echo'</select>								
				</td> 				
				<td id="select03">
					<select name="rol" id="rol" style="width:180px;">	 
						   <option value="">Seleccione...</option>';	//  ROL						     						   
						   $query03 = mysql_query("SELECT codigo, descripcion
                                                     FROM pres_rol WHERE `status` = 1 ORDER BY 2 ASC",$cnn);
						   while($row03=(mysql_fetch_array($query03))){
						   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
						   }
			echo'</select>			   
			  </td>
              <td id="input01"><input type="text" name="cantidad" id="cantidad" maxlength="3"  style="width:80px"/>
			  </td>'; ?>				  
			  <td align="center"><input name="submit" type="submit" id="submit" value="Ingresar"  class="button2"
							   onMouseOver="Fondos(this.id ,'A',  'button2Act', 'button2')" 
							   onMouseOut="Fondos(this.id ,'D', 'button2Act', 'button2')"/>			  
			 </td> 					
		</tr> 
		<?php 	 
        // Instanciamos el objeto		 
        $paging = new PHPPaging;
        $paging->porPagina(15);
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta($SQL_PAG);        
        // Ejecutamos la paginación
        $paging->ejecutar();          
        // Imprimimos los resultados, para esto creamos un ciclo while
        // Similar a while($datos = mysql_fetch_array($sql))
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
		       $fechaX  = conversion($fecha);
		       $campo_id = $datos[0];
 		  
        echo '<tr class="'.$fondo.'">             
			      <td>
				  <select id="cargo'.$i.'" style="width:250px;"  onchange="spryValidarSelect(this.id)">	 
							   <option value="'.$datos["cod_cargo"].'">'.$datos["cargo"].'</option>';							   
							   $query03 = mysql_query("SELECT codigo, descripcion
                                                         FROM pres_cargo_salario WHERE `status` = 1 ORDER BY 2 ASC", $cnn);
							   while($row03=(mysql_fetch_array($query03))){							  		
									 echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
							   }
				echo'</select>
					<input type="hidden" id="cargo_old'.$i.'" value="'.$datos["cod_cargo"].'"/>													  
				  </td> 
				  <td> 
						<select id="rol'.$i.'" style="width:180px;" onchange="spryValidarSelect(this.id)">	 
							   <option value="'.$datos["cod_rol"].'">'.$datos["rol"].'</option>';							   
							   $query03 = mysql_query("SELECT codigo, descripcion
                                                         FROM pres_rol WHERE `status` = 1 ORDER BY 2 ASC",$cnn);
							   while($row03=(mysql_fetch_array($query03))){
							   echo '<option value="'.$row03[0].'">'.$row03[1].'</option>';
							   }
				echo'</select>		
				<input type="hidden" id="rol_old'.$i.'"  value="'.$datos["cod_rol"].'" onchange="spryValidarInt(this.id)"/>	   
			    </td>
	   		    <td> 
					<input type="text" name="cantidad'.$i.'" id="cantidad'.$i.'" maxlength="3"  style="width:80px" value="'.$datos["valor"].'"/>				
				</td>				
			      <td align="center">
				  <a id="'.$i.'" onclick="ValidarSubmit(this.id)"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="25px" height="25px" class="imgLink" /></a> &nbsp;			  
		         <a  id="'.$i.'" onclick="Borrar_Campo(this.id)"><img src="imagenes/borrar.bmp" alt="Borrar" title="Borrar Registro" border="null" class="imgLink" width="25px" height="25px"/></a>
				 </td> 					
			</tr>'; 
        }     
    ?>  
	</table>	
	<input type="hidden" name="href" 
	value="../inicio.php?area=formularios/Cons_pres_cotizacion<?php echo "&Nmenu=".$Nmenu."&codigo=".$codigo."";?>"/>
	<input type="hidden" name="metodo" value="Agregar"/>
	<input type="hidden"  name="usuario" id="usuario" value="<?php echo $usuario;?>"/>	
	<input type="hidden"   id="i" value="<?php echo $i;?>"/>
    <input type="hidden"   id="Nmenu" name="Nmenu" value="<?php echo $Nmenu;?>"/>
  </fieldset>
</form>	
<br />
<br />
<div align="center">  
<?php
    // Imprimimos la barra de navegación
    echo $paging->fetchNavegacion();   
	//echo $paging->VolverV();
?>
</div>        
<script type="text/javascript">
//	var input01 = new Spry.Widget.ValidationTextField("input01", "none", {minChars:4, validateOn:["blur", "change"]});
	var select01 = new Spry.Widget.ValidationSelect("select01", {validateOn:["blur", "change"]});		
	var select02 = new Spry.Widget.ValidationSelect("select02", {validateOn:["blur", "change"]});		
	var select03 = new Spry.Widget.ValidationSelect("select03", {validateOn:["blur", "change"]});		

	var ValorN = new Spry.Widget.ValidationTextField("input01", "integer", {validateOn:["blur"], useCharacterMasking:true, minValue:"0"});	

	function spryValidarInt(ValorN){
	var ValorN = new Spry.Widget.ValidationTextField(ValorN, "integer", {validateOn:["blur"], useCharacterMasking:true, minValue:"0"});
	}
	
	function spryValidarSelect(ValorN){
 		var ValorN = new Spry.Widget.ValidationSelect(ValorN, {validateOn:["blur", "change"]});
	}
	
function ValidarSubmit(auto){

	var cliente   = document.getElementById("cliente").value;	
	var usuario   = document.getElementById("usuario").value;
	var cargo     = document.getElementById("cargo"+auto+"").value;
	var cargo_old = document.getElementById("cargo_old"+auto+"").value;		
	var rol       = document.getElementById("rol"+auto+"").value;
	var rol_old   = document.getElementById("rol_old"+auto+"").value;
	var cantidad  = document.getElementById("cantidad"+auto+"").value;		

    var campo01 = 0;
	 var errorMessage = 'Debe Seleccionar Todo Los Campos';

     if(cliente!='') {
	 var campo01 = 1; 
     }  

	if(campo01 == 1){
			//var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
			var valor = "scripts/sc_pres_cotizacion.php"; 
					ajax=nuevoAjax();
						ajax.open("POST", valor, true);
						ajax.onreadystatechange=function(){ 
							if (ajax.readyState==4){
							document.getElementById("Contenedor01").innerHTML = ajax.responseText;
							//window.location.href=""+href+"";	
							Reload();						 	
							}
						} 
						ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						ajax.send("usuario="+usuario+"&cliente="+cliente+"&cargo="+cargo+"&cargo_old="+cargo_old+"&rol="+rol+"&rol_old="+rol_old+"&cantidad="+cantidad+"&metodo=Modificar");

	 	 }else{
	 	alert(errorMessage);
	 }
}

function Borrar_Campo(auto){
	var cliente   = document.getElementById("cliente").value;	
	var usuario   = document.getElementById("usuario").value;	

	var cargo = document.getElementById("cargo_old"+auto+"").value;		
	var rol   = document.getElementById("rol_old"+auto+"").value;

    var campo01 = 0;
	 var errorMessage = 'Debe Seleccionar Todo Los Campos';

     if(cliente!='') {
	 var campo01 = 1; 
     }  
	if(campo01 == 1){
			//var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
			var valor = "scripts/sc_pres_cotizacion.php"; 
					ajax=nuevoAjax();
						ajax.open("POST", valor, true);
						ajax.onreadystatechange=function()  
						{ 
							if (ajax.readyState==4){
							document.getElementById("Contendor01").innerHTML = ajax.responseText;							
							Reload();							
							//window.location.href=""+href+"";							 	
							}
						} 
						ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						ajax.send("usuario="+usuario+"&cliente="+cliente+"&cargo="+cargo+"&rol="+rol+"&metodo=Eliminar");
	 	 }else{
	 	alert(errorMessage);
	 }
}
</script>