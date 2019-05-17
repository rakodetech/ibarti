<?php 
//	require_once('autentificacion/aut_verifica_menu.php');
	$proced      = "p_fichas_03";
    $metodo       = "agregar";	
	$archivo = "pestanas/add_ficha&Nmenu=".$Nmenu."&codigo=".$codigo."&mod=$mod&pagina=2&metodo=modificar";

	   $sql01 =	"SELECT ficha_familia.codigo, ficha_familia.nombres,
	                    ficha_familia.fec_nac, ficha_familia.cod_parentesco,
						parentescos.descripcion AS parentesco, ficha_familia.sexo
                   FROM ficha_familia, parentescos 
				  WHERE ficha_familia.cod_parentesco = parentescos.codigo
                    AND ficha_familia.cod_ficha = '$codigo'";				  
                ?>
<script language="javascript"> 
function ValidarSubmit(auto){

	var codigo     = document.getElementById("codigo").value; 
	var codigo_fam = document.getElementById("codigo_fam"+auto+"").value;
	var usuario    = document.getElementById("usuario").value;	
	var codigo_old = document.getElementById("codigo_old"+auto+"").value;
	var nombre     = document.getElementById("nombre"+auto+"").value;		
	var fec_nac    = document.getElementById("fec_nac"+auto+"").value;	
	var sexo_f     = document.getElementById("sexo_f"+auto+"");
	var sexo_m     = document.getElementById("sexo_m"+auto+"");	
	var parentesco = document.getElementById("parentesco_fam"+auto+"").value;	
    var proced = "p_fichas_03";
	 var errorMessage = 'Debe Ingresar Todo Los Campos';
	 var campo01 = 0;
 
    if(sexo_f.checked == true){	 
	var sexo = sexo_f.value;
    }else if(sexo_m.checked == true){
	var sexo = sexo_m.value;
	}

	 if(codigo_fam.length < 4) {
	 campo01++; 
     }else if(nombre.length < 4){	 
	 campo01++; 	 
     }else if(fec_nac.length < 10){	 
	 campo01++;      
	 } 

	if(campo01 == 0){
		  //var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
	var valor = "scripts/sc_ficha_03.php"; 
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function()  
			{ 
				if (ajax.readyState==4){
				document.getElementById("Contenedor03").innerHTML = ajax.responseText;
				//window.location.href=""+href+"";							 	
				}
			} 

			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+codigo+"&codigo_fam="+codigo_fam+"&codigo_old="+codigo_old+"&nombre_fam="+nombre+
			"&fec_nacimiento_fam="+fec_nac+"&sexo_fam="+sexo+"&parentesco_fam="+parentesco+"&usuario="+usuario+"&href=''&metodo=modificar&proced="+proced+"");
	 }else{
	 	alert(errorMessage);
	 }	 
}

function Borrar3(auto){
	if (confirm("¿ Esta Seguro Eliminar Este Registro")) {	

		var codigo    = document.getElementById("codigo").value;
        var proced = "p_fichas_03";
		var valor = "scripts/sc_ficha_03.php"; 
			ajax=nuevoAjax();
				ajax.open("POST", valor, true);
				ajax.onreadystatechange=function()  
				{ 
					if (ajax.readyState==4){
					document.getElementById("Contenedor03").innerHTML = ajax.responseText;
					Reload();							 	
					}
				} 
				ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				ajax.send("codigo="+codigo+"&codigo_fam="+auto+"&codigo_old=&nombre_fam= &fec_nacimiento_fam=&sexo_fam=&parentesco_fam=&usuario="+usuario+"&href=''&metodo=eliminar&proced="+proced+"");
	}
}
</script>
<div align="center" class="etiqueta_title"> CARGA FAMILIAR</div> 
<hr />
<div id="Contenedor03"  class="mensaje"></div> 
<form id="add_03" name="add_03" action="scripts/sc_ficha_03.php" method="post">
	<table width="99%" border="0" align="center"><tr class="fondo01">
			<th width="12%" class="etiqueta">Codigo</th>
			<th width="30%" class="etiqueta">Nombre</th>
			<th width="10%" class="etiqueta">Fecha Nacimiento </th>
			<th width="18%" class="etiqueta">Sexo </th>
			<th width="20%" class="etiqueta">Parentesco </th>
		    <th width="10%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" 
			                     title="Agregar Registro" border="null" onclick="Ficha()"  class="imgLink"/></th></tr>
		<tr  class="fondo02">
			<td id="input01_3"><input type="text" id="codigo_fam" name="codigo_fam" style="width:90px" maxlength="13" /></td>
			<td id="input02_3"><input type="text" id="nombre_fam" name="nombre_fam" style="width:250px" maxlength="60"/></td>
			<td id="fecha01_3"><input type="text" id="fec_nacimiento_fam" name="fec_nacimiento_fam" style="width:85px"/></td>
			<td id="radio01_3"><img src="imagenes/femenino.gif" width="25" height="15" />
            <input type = "radio" id="sexo_fam" name="sexo_fam"  value = "F" style="width:auto"/>
            <img src="imagenes/masculino.gif" width="25" height="15" />
            <input type = "radio" id="sexo_fam" name="sexo_fam"  value = "M" style="width:auto"/>
            <span class="radioRequiredMsg"></span></td>
			<td id="select01_3"><select name="parentesco_fam" style="width:150px">
							<option value="">Seleccione...</option>
          <?php  	$sql = " SELECT codigo, descripcion FROM parentescos WHERE status = 'T' ORDER BY 2 ASC ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){	
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>		  	  
        </select></td>
			<td><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
               <input type="submit" name="submit" id="submit" value="Actualizar"  class="readon art-button"  />	
                </span></td>
 		</tr>		
    <?php       
        $query = $bd->consultar($sql01); 		   
        $i =0;
        $valor = 0;
  		while($datos=$bd->obtener_fila($query,0)){	
		$i++;
			if ($valor == 0){
				$fondo = 'fondo01';
				$valor = 1;
			}else{
				 $fondo = 'fonddo02';
				 $valor = 0;
			}

			$sex = $datos['sexo'];					 
			$borrar = 	 "'".$datos[0]."'";
        echo '<tr class="'.$fondo.'"> 
                  <td><input type="text" id="codigo_fam'.$i.'" style="width:90px" maxlength="13" value="'.$datos[0].'"/>
				      <input type="hidden"  id="codigo_old'.$i.'" value="'.$datos[0].'"/>
				  </td> 
                  <td><input type="text" id="nombre'.$i.'" style="width:250px" maxlength="60" 
				             value="'.$datos['nombres'].'"/></td>
				  <td><input type="text" id="fec_nac'.$i.'" style="width:85px" 
				             value="'.conversion($datos['fec_nac']).'"/></td> 
           	      <td id="sexo_3'.$i.'"><img src="imagenes/femenino.gif" width="25" height="15" />
						<input type = "radio" name="sexo2'.$i.'" id="sexo_f'.$i.'" value = "F" style="width:auto"
						       '.CheckX($sex, 'F').'/>
						<img src="imagenes/masculino.gif" width="25" height="15" />
						<input type = "radio" name="sexo2'.$i.'" id="sexo_m'.$i.'" value = "M" style="width:auto" 
						'.CheckX($sex, 'M').'/><span class="radioRequiredMsg"></span></td>			      
                  <td> 
				   <select name="parentesco_fam'.$i.'" id="parentesco_fam'.$i.'" style="width:150px">
						   <option value="'.$datos["cod_parentesco"].'">'.$datos["parentesco"].'</option> ';
           	$sql = " SELECT codigo, descripcion FROM parentescos WHERE status = 'T' ORDER BY 2 ASC ";
		            $query2 = $bd->consultar($sql);
            		while($datos2=$bd->obtener_fila($query2,0)){	
		 echo '
          <option value="'.$datos2[0].'">'.$datos2[1].'</option>';
          }	
		  echo '</select>
		  </td><td align="center">
		  <img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="25" height="25" border="null" 
			   onclick="ValidarSubmit('.$i.')" class="imgLink"/>
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null" 
			   onclick="Borrar3('.$borrar.')" class="imgLink" /> 
		  </td> 								
	</tr>'; 
        }     
	?>
	</table>
	 <input name="href" type="hidden" value="../inicio.php?area=<?php echo $archivo ?>"/>
    <input name="metodo" type="hidden"  value="<?php echo $metodo;?>" />
    <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" /> 
    <input name="pestana" type="hidden"  value="familia" />
	<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>"/>	
	<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>"/>
	<input type="hidden"  id="i" value="<?php echo $i;?>"/>	
</form>
<br/>
<br />
<script language="javascript" type="text/javascript">
var input01_3 = new Spry.Widget.ValidationTextField("input01_3", "none", {minChars:4, validateOn:["blur", "change"]});
var input02_3 = new Spry.Widget.ValidationTextField("input02_3", "none", {minChars:4, validateOn:["blur", "change"]});

var select01_3 = new Spry.Widget.ValidationSelect("select01_3", {validateOn:["blur", "change"]});

var fecha01_3 = new Spry.Widget.ValidationTextField("fecha01_3", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});

var radio01_3 = new Spry.Widget.ValidationRadio("radio01_3", { validateOn:["change", "blur"]});

	// VALIDAR CAMPOS
	var incX = document.getElementById("i").value;	
	var 	inc =	++incX;
	for (i = 1; i < inc; i++){		
	var input01_3N = new Spry.Widget.ValidationTextField("codigo"+i+"", "none", {minChars:4, validateOn:["blur", "change"]});
	var input02_3N = new Spry.Widget.ValidationTextField("nombre"+i+"", "none", {minChars:4, validateOn:["blur", "change"]});
	var input03_3N = new Spry.Widget.ValidationTextField("parentesco"+i+"", "none", {minChars:4, validateOn:["blur", "change"]});

	var fecha01_3 = new Spry.Widget.ValidationTextField("fec_nac"+i+"", "date", {format:"dd-mm-yyyy", hint:"DD-MM-AAAA", 
    validateOn:["blur", "change"], useCharacterMasking:true});		
	var radio01_3 = new Spry.Widget.ValidationRadio("sexo_3"+i+"", { validateOn:["change", "blur"]});
	}
</script>