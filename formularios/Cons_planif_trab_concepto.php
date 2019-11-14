<script language="javascript">
function Borrar_Registro(idX, fec_inicio, fec_fin){  // CARGAR EL MODULO DE AGREGAR //

	if (confirm("¿Esta Seguro De Borrar Este Registro")) {

		var valor      = "scripts/sc_planif_trab_concepto.php";

		var cliente     = "";
		var ubicacion   = "";
		var trabajador  = "";
		var turno       = "";
		var observacion = "";
		var href       = "";
		var usuario    = "";
		var proced     = "p_pl_trab_concepto";
		var metodo     = "borrar";
		ajax=nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange=function(){
				if (ajax.readyState==4){
		        document.getElementById("Contenedor01").innerHTML = ajax.responseText;
				setTimeout(alert(""+document.getElementById("mensaje_aj").value+""), Reload(), 1000);
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo="+idX+"&fec_inicio="+fec_inicio+"&fec_fin="+fec_fin+"&cliente=&ubicacion=&trabajador=&turno=&observacion=&href=&usuario=&metodo=borrar&proced="+proced+"");
	}
}
</script>
<?php
	$Nmenu = '445';
	require_once('autentificacion/aut_verifica_menu.php');
	$tabla = "turnos";
	$bd = new DataBase();
	$archivo = "planif_trab_concepto";
	$titulo = " Planificacion De Excepciones De ".$leng['trabajador']." ";
	$vinculo = "inicio.php?area=formularios/Add_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."&archivo=$archivo";
?>
<div align="center" class="etiqueta_title"> Consulta <?php echo $titulo;?> </div> <hr />
<div id="Contenedor01"></div>
<div id="listar"><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="12%" class="etiqueta">Fecha Inicio</th>
			<th width="12%" class="etiqueta">Fecha Fin</th>
            <th width="11%" class="etiqueta"><?php echo $leng['ficha']?></th>
            <th width="35%" class="etiqueta"><?php echo $leng['trabajador']?></th>
            <th width="20%" class="etiqueta"><?php echo $leng['concepto']?></th>
   		    <th width="10%" align="center"><a href="<?php echo $vinculo."&codigo=''&metodo=agregar";?>"><img src="imagenes/nuevo.bmp" alt="Detalle" title="Detalle Registro" width="20px" height="20px" border="null"/></a></th>
		</tr>
    <?php
	$usuario = $_SESSION['usuario_cod'];
	$valor = 0;
	$sql = " SELECT pl_trab_concepto.codigo, pl_trab_concepto.fec_desde,
                    pl_trab_concepto.fec_hasta,  pl_trab_concepto.cod_horario,
			         horarios.nombre AS horario,
                    pl_trab_concepto.cod_ficha, v_ficha.cedula, v_ficha.nombres AS trabajador,
			        pl_trab_concepto.observacion,
                    pl_trab_concepto.cod_us_ing, pl_trab_concepto.fec_us_ing,
                    pl_trab_concepto.cod_us_mod, pl_trab_concepto.fec_us_mod
			   FROM pl_trab_concepto , horarios , v_ficha
              WHERE pl_trab_concepto.cod_horario= horarios.codigo
                AND pl_trab_concepto.cod_ficha = v_ficha.cod_ficha
           ORDER BY 2 DESC";

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
	   $Borrar = "Borrar_Registro('".$datos[0]."','".conversion($datos[1])."','".conversion($datos[2])."')";
        echo '<tr class="'.$fondo.'">
                  <td class="texto">'.conversion($datos["fec_desde"]).'</td>
                  <td class="texto">'.conversion($datos["fec_hasta"]).'</td>
				  <td class="texto">'.$datos["cod_ficha"].'</td>
				  <td class="texto">'.$datos["trabajador"].'</td>
				  <td class="texto">'.$datos["horario"].'</td>
				  <td align="center"><a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/></td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	?>
    </table>
</div>
