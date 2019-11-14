<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<?php 
	$Nmenu   = '429'; 
	$mod     = $_GET['mod'];
	require_once('autentificacion/aut_verifica_menu.php');
	require_once('sql/sql_report_t.php');
	$tabla   = "productos";
	$bd      = new DataBase();
	$archivo = "productos";
	$titulo  = "  PRODUCTOS ";
	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod&archivo=$archivo";
?>
<script language="JavaScript" type="text/javascript">
function Add_filtroX(){  // CARGAR  ARCHIVO DE AJAX CON UN PARAMETRO//

	var Nmenu     = $("#Nmenu").val();
	var mod       = $("#mod").val(); 						
	var tb        = $("#tabla").val();						
	var linea     = $("#linea").val(); 						
	var sub_linea = $("#sub_linea").val(); 
	var prod_tipo = $("#prod_tipo").val();
	var tipo_mov  = $("#tipo_mov").val(); 
	
	var filtro    = $("paciFiltro").val(); 
	var producto  = $("#stdID").val(); 
	var error     = 0; 
    var errorMessage = ' ';
	if(error == 0){
	var contenido = "listar";
	 $("#img_actualizar").remove();
	 $("#listar").html("<img src='imagenes/loading.gif' /> Procesando, espere por favor...");  
	ajax=nuevoAjax();
			ajax.open("POST", "ajax/Add_productos.php", true);
			ajax.onreadystatechange=function(){ 
				if (ajax.readyState==4){
		     	  document.getElementById(contenido).innerHTML = ajax.responseText;	
				$("#cont_img").html("<img class='imgLink' id='img_actualizar' src='imagenes/actualizar.png' border='0'                               onclick='Add_filtroX()'>");
				}
			} 
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("Nmenu="+Nmenu+"&mod="+mod+"$tb="+tb+"&linea="+linea+"&sub_linea="+sub_linea+"&prod_tipo="+prod_tipo+"&tipo_mov="+tipo_mov+"&filtro="+filtro+"&producto="+producto+"");		
	}else{
		 	 alert(errorMessage);
	}	
}
</script><div align="center" class="etiqueta_title">CONSULTA <?php echo $titulo;?></div> 
<div id="Contenedor01"></div>
<fieldset>
<legend>Filtros:</legend>
	<table width="100%">
		<tr><td width="12%">Linea: </td>
			<td width="18%"><select name="linea" id="linea" style="width:120px;"  
                                    onchange="Add_Sub_Linea(this.value, 'contenido_sub_linea', 'T', '120')">
					<option value="TODOS">TODOS</option> 
					<?php 

	   			$query01 = $bd->consultar($sql_linea);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>
			<td width="12%">Sub Linea: </td>
			<td width="18%" id="contenido_sub_linea"><select name="sub_linea" id="sub_linea" style="width:120px;">
					<option value="TODOS">TODOS</option></select></td>
            <td width="12%">Producto Tipo: </td>
			<td width="18%"><select  name="prod_tipo" id="prod_tipo" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
				// $sql01 = " SELECT codigo, descripcion FROM prod_tipos WHERE `status` = 'T' ORDER BY 2 ASC ";
	   			$query01 = $bd->consultar($sql_prod_tipo);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>                              
			<td width="10%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0" 
                                                onclick=" Add_filtroX()"  /></td>
            <td><input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
            <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" /></td>
</tr>
<tr>
		<td>Movimiento: </td>
		<td ><select name="tipo_mov" id="tipo_mov" style="width:120px;">
					<option value="TODOS">TODOS</option> 
					<?php 
	  			$query01 = $bd->consultar($sql_tipo_mov);		
		 		while($row01=$bd->obtener_fila($query01,0)){							   							
					 echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
			   }?></select></td>


     <td>Filtro Producto.:</td>	
<td id="select01">
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:120px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo">codigo</option>
				<option value="serial">Serial</option>
                <option value="descripcion">Descripcion</option>
		</select></td>
	 <td>Producto:</td> 
     
      <td colspan="4"><input  id="stdName" type="text" style="width:180px" disabled="disabled" />
	      <input type="hidden" name="trabajador" id="stdID" value=""/></td> 
       </tr> 
</table>
</fieldset>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="10%" class="etiqueta">Codigo</th>
   			<th width="16%" class="etiqueta">Serial</th>
			<th width="26%" class="etiqueta">Producto</th>
            <th width="16%" class="etiqueta">Linea</th>
            <th width="16%" class="etiqueta">Movimiento</th>
            <th width="10%" class="etiqueta">Activo</th>
		    <th width="6%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="25px" height="25px" border="null"/></a></th> 
		</tr>
    <?php       
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = "  SELECT productos.codigo, prod_lineas.descripcion AS linea, 
                     prod_sub_lineas.descripcion AS sub_linea,  prod_tipos.descripcion AS prod_tipo,  
					 productos.item, productos.descripcion,  IFNULL(v_prod_ultimo_mov.mov_tipo , 'SIN MOVIMIENTO') AS mov_tipo,
				 	 productos.status
                FROM productos LEFT JOIN v_prod_ultimo_mov ON productos.codigo = v_prod_ultimo_mov.cod_producto , prod_lineas , prod_sub_lineas , prod_tipos ,  control
	   		   WHERE productos.cod_linea = prod_lineas.codigo 
				 AND productos.cod_sub_linea = prod_sub_lineas.codigo 
				 AND productos.cod_prod_tipo = prod_tipos.codigo 
				 AND productos.fec_us_mod  BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND CURDATE()   
		    ORDER BY productos.codigo ASC ";

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
                  <td class="texo">'.longitudMin($datos["codigo"]).'</td> 
                  <td class="texo">'.longitudMin($datos["item"]).'</td> 
                  <td class="texo">'.longitud($datos["descripcion"]).'</td>
				  <td class="texo">'.longitudMin($datos["linea"]).'</td>
				  <td class="texo">'.longitudMin($datos["mov_tipo"]).'</td>
				  <td class="texo">'.statuscal($datos["status"]).'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td> 
            </tr>'; 
        }     
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>   
</div>
<script type="text/javascript">
	filtroId = document.getElementById("paciFiltro");
	filtroIndice = filtroId.selectedIndex;
	filtroValue  = filtroId.options[filtroIndice].value; 
	
    new Autocomplete("stdName", function() { 
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/producto.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>