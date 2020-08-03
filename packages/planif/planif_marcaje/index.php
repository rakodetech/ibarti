<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<script type="text/javascript" src="latest/scripts/autocomplete.js"></script>
<script type="text/javascript" src="packages/planif/planif_marcaje/controllers/marcajeCtrl.js"></script>
<style>
    .marcar {
    text-decoration: line-through;
}
</style>
<?php
	$Nmenu = '4406';
	if(isset($_SESSION['usuario_cod'])){
        require_once('autentificacion/aut_verifica_menu.php');
        require_once('sql/sql_report.php');
		$us = $_SESSION['usuario_cod'];
	}else{
		$us = $_POST['usuario'];
	}
?>
<div id="Cont_marcaje">

    <span class="etiqueta_title" id="title_horario">Marcaje de Supervisor</span>
    <table width="90%" align="center">  
      <tr>
      <td height="8" colspan="4" align="center"><hr></td>
    </tr>
      <tr>
      <td class="etiqueta">Filtro Trab.:</td>	
		<td>
			<select id="paciFiltro" onchange="EstadoFiltro(this.value)" style="width:250px">
				<option value="TODOS"> TODOS</option>
				<option value="codigo"> Ficha </option>
				<option value="cedula"> C&eacute;dula </option>
				<option value="trabajador"> Trabajador </option>
                <option value="nombres"> Nombre </option>
                <option value="apellidos"> Apellido </option>                
        </select></td>
        <td class="etiqueta">Trabajador:</td> 
      <td><input  id="stdName" type="text" style="width:380px" disabled="disabled" />
	      <input type="hidden" name="trabajador" id="stdID" value="" onchange="Add_filtroX()"/> </td>
      </tr>
      <tr>
      <tr> 

<td class="etiqueta">Cliente:</td>
<td><select name="cliente" id="cliente" style="width:250px;" onchange="changeCliente(this.value)" required>
        <?php 
        echo $select_cl;
       $query01 = $bd->consultar($sql_cliente);		
     while($row01=$bd->obtener_fila($query01,0)){							   							
         echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';						   		
   }?></select></td>
<td class="etiqueta">Ubicacion: </td>
<td id="contenido_ubic"><select name="ubicacion" id="ubicacion" style="width:250px;">
                                <option value="TODOS">TODOS</option> 
                        </select></td>
      </tr>
      <tr>
      <td height="8" colspan="4" align="center"><hr></td>
    </tr>
  </table>
  <table width="90%" class="tabla_sistema">
      <thead><tr>
          <th>Código</th>
          <th>Ubicación</th>
          <th>Proyecto</th>
          <th>Actividad</th>
          <th>Hora Inicio</th>
          <th>Hora Fin</th>
          <th>Realizado</th>
          <th>Marcar</th>
      </tr></thead>
      <tbody id="actividades">

</tbody>
  </table>
</div>

<input name="usuario" id="usuario" type="hidden" value="<?php echo $us;?>" />
<script type="text/javascript">
	filtroValue = $("#paciFiltro").val();

    new Autocomplete("stdName", function() { 
        this.setValue = function(id) {
            document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
            Add_filtroX();
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
          return "autocompletar/tb/trabajador.php?q="+this.text.value +"&filtro="+filtroValue+""});
</script>