<?php 
require_once('paginador/PHPPaging.lib.php');
mysql_select_db($bd_cnn, $cnn);
$paging = new PHPPaging($cnn);

$id = $_GET['id'];
$Nmenu = 310; 
$archivo = "Municipio&Nmenu=".$Nmenu."";
$tabla   = "dpt_2";

require_once('autentificacion/aut_verifica_menu.php');
?>
<script language="JavaScript" type="text/javascript">

function ConfirmacionS(idX){

	if (confirm("¿ Esta Seguro De Borrar Este Archivo?")) {

//var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
var valor = "sc_maestros/sc_estado.php"; 
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
<div align="center" class="etiqueta_title"> CONSULTA GENERAL MUNICIPIO</div> 
<hr />
<br/>
	<table width="75%" border="0" align="center">
		<tr class="fondo00">
			<th width="35%" class="etiqueta">Estado</th>
			<th width="50%" class="etiqueta">Municipio</th>
		    <th width="15%"><a href="inicio.php?area=maestros/Add_<?php echo $archivo?>&id=<?php echo $id?>"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" /></a></th> 
		</tr>
    <?php
    
        // Apertura de la conexión a la base de datos e Inclusión del script
        
        // Instanciamos el objeto
        $paging = new PHPPaging;
        
        // Indicamos la consulta al objeto 
        $paging->agregarConsulta("SELECT  b.entidescri,  a.munidescri, a.id
									FROM dpt_2 AS a, dpt_1 AS b
									WHERE a.relacion =  b.entienti 
									  AND a.relacion =  '$id' 
									ORDER BY entidescri");
        
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
			      <td width="15%" align="center">				  
				  <a href="inicio.php?area=maestros/Mod_'.$archivo.'&id='.$id.'&campo_id='.$datos[2].'"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" width="30" height="30" border="null"/></a>
      
		          </td> 								
            </tr>'; 
        }     
    /*   <a onClick="ConfirmacionS('.$confir.')"><img src="imagenes/borrar.bmp" alt="Eliminar" title="Eliminar Registro" width="30" height="30" border="null"/></a>*/
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