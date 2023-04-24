<?php
$metodo = $_GET['metodo'];
$titulo = $_GET['titulo'];
$tabla   = $_GET['tb'];
$archivo = $_GET['archivo'];
$proced      = "p_controlrifd";
$archivo2 = "../inicio.php?area=maestros/Cons_$archivo&Nmenu=".$_GET['Nmenu']."&mod=".$_GET['mod']."";

if($metodo == 'modificar'){
	$codigo = $_GET['codigo'];
	$bd = new DataBase();
	$sql = " SELECT DISTINCT T2.codigo as codigo1, T2.descripcion vienen,t3.codigo as codigo2, T3.descripcion planificacion,T1.codigo as codigo3,T1.feriado feriado, t4.codigo as codigo4,t4.descripcion registro FROM control_rfid T1 INNER JOIN conceptos T2 ON T1.cod_concepto_viene = T2.codigo INNER JOIN conceptos t3 on T1.cod_concepto_planif=T3.codigo INNER JOIN conceptos T4 ON T1.cod_concepto_registro = T4.codigo where T1.codigo='$codigo' GROUP by T1.codigo";
	$query = $bd->consultar($sql);
	$result=$bd->obtener_fila($query,0);

	$titulo       = "Modificar  $titulo";
	$cod_vienen   = $result["codigo1"];
  $vienen       =  $result["vienen"];
	$cod_planificacion      = $result["codigo2"];
  $planificacion          =  $result["planificacion"];
	$cod_feriado            = $result["codigo3"];
  $feriado                 = $result["feriado"];
	$cod_registro           = $result["codigo4"];
  $registro               =$result["registro"];

	}else{

	$titulo      = "Agregar  $titulo";
	$codigo      = "";
	$cod_vienen    = "";
  $vienen ="";
	$cod_planificacion        = " Seleccione... ";
  $planificacion = "";
	$cod_feriado = "";
  $feriado = "";
	$cod_registro     = "";
  $registro = "";

	}
?>
<form action="sc_maestros/sc_<?php echo $archivo;?>.php" method="post" name="add" id="add">
  <fieldset class="fieldset">
  <legend> <?php echo $titulo;?> </legend>
     <table width="80%" align="center">
    
    <tr>
      <td class="etiqueta">Vienen:</td>
      	<td id="select01"><select name="cod_vienen" style="width:250px">
							<option value="<?php echo $cod_vienen;?>"><?php echo $vienen;?></option>
          <?php  	$sql = "SELECT conceptos.codigo, conceptos.abrev, conceptos.descripcion FROM conceptos, horarios WHERE horarios.cod_concepto = conceptos.codigo GROUP BY conceptos.codigo AND conceptos.`status` = 'T';";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
      <td class="etiqueta">Planificacion:</td>
      	<td id="select02"><select name="cod_planificacion"  style="width:250px">
							<option value="<?php echo $cod_planificacion;?>"><?php echo $planificacion;?></option>
          <?php  	$sql = "SELECT conceptos.codigo, conceptos.abrev, conceptos.descripcion FROM conceptos, horarios WHERE horarios.cod_concepto = conceptos.codigo GROUP BY conceptos.codigo AND conceptos.`status` = 'T';";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    <tr>
   
      <td class="etiqueta">Feriado:</td>
      <td id="select03"><select name="cod_feriado"  style="width:150px;" >
												<option value="">Seleccione... </option>
												<option value="T">Si</option>
 												 <option value="F" selected>No</option>
  												
			</select></td>
    </tr>
    <tr>
      <td class="etiqueta">Registro:</td>
      	<td id="select04"><select name="cod_registro" style="width:250px">
							<option value="<?php echo $cod_registro;?>"><?php echo $registro;?></option>
          <?php  	$sql = "SELECT conceptos.codigo, conceptos.abrev, conceptos.descripcion FROM conceptos WHERE conceptos.`status` = 'T' AND asist_diaria = 'T'; ";
		            $query = $bd->consultar($sql);
            		while($datos=$bd->obtener_fila($query,0)){
		  ?>
          <option value="<?php echo $datos[0];?>"><?php echo $datos[1];?></option>
          <?php }?>
        </select>
        <img src="imagenes/ok.gif" alt="Valida" class="validMsg" border="0"/><br />
        	<span class="selectRequiredMsg">Debe Seleccionar Un Campo.</span></td>
    </tr>
    
	 <tr>
         <td height="8" colspan="2" align="center"><hr></td>
     </tr>
  </table>
<div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="submit" name="salvar"  id="salvar" value="Guardar" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="reset" id="limpiar" value="Restablecer" class="readon art-button" />
                </span>&nbsp;
             <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                <input type="button" id="volver" value="Volver" onClick="history.back(-1);" class="readon art-button" />
                </span>
  		    <input name="metodo" id="metodo" type="hidden"  value="<?php echo $metodo;?>" />
  		    <input name="proced" id="proced" type="hidden"  value="<?php echo $proced;?>" />
            <input name="tabla" id="tabla" type="hidden"  value="<?php echo $tabla;?>" />
            <input name="usuario" id="usuario" type="hidden"  value="<?php echo $usuario;?>" />
	        <input name="href" type="hidden" value="<?php echo $archivo2;?>"/>
</div>
  </fieldset>
  </form>
  <script type="text/javascript">
var input01  = new Spry.Widget.ValidationTextField("input01", "none", {validateOn:["blur", "change"]});
var input02  = new Spry.Widget.ValidationTextField("input02", "none", {validateOn:["blur", "change"]});

</script>
