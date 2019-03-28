<script language="javascript">
  $("#add").on('submit', function(evt){
    evt.preventDefault();
    save_linea();
  });
</script>
<?php
require "../modelo/linea_modelo.php";
require "../../../../".Leng;
$codigo   = $_POST['codigo'];
$metodo   = $_POST['metodo'];

$pag = 0;
$linea = new Linea;
$proced   = "p_lineas";
if($metodo == 'modificar')
{
  $titulo    = " MODIFICAR LINEA (".$codigo.")";
  $linea        = $linea->editar($codigo);
}else{
  $linea   = $linea->inicio();
  $titulo    = "AGREGAR LINEA";
}
$activo = $linea['status'];
?>

<div id="add_linea">
  <form method="post" name="add" id="add">  
    <div align="center" class="etiqueta_title"> 
    </div>
    <div class="TabbedPanels" id="tp1">  
     <ul class="TabbedPanelsTabGroup">   
      <li class="TabbedPanelsTab"><?php echo $titulo;?></li>
      <li class="TabbedPanelsTab">ADICIONALES</li>
    </ul>        
    <div class="TabbedPanelsContentGroup"> 
     <div class="TabbedPanelsContent"><?php include('../views/Add_maestros.php');?></div>
     <div class="TabbedPanelsContent"><?php include('/views/add_adicionales_ad.php');?></div>
   </div>
 </div> 
</form>
</div>
<div id="buscar_linea" style="display: none;">
	
</div>
<script language="JavaScript" type="text/javascript">
  var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab:<?php echo $pag;?>});
  filtroId = document.getElementById("paciFiltro");
  filtroIndice = filtroId.selectedIndex;
  filtroValue  = filtroId.options[filtroIndice].value; 

  new Autocomplete("stdName", function() { 
    this.setValue = function(id) {
          document.getElementById("stdID").value = id; // document.getElementsByName("stdID")[0].value = id;
        }
        if (this.isModified) this.setValue("");
        if (this.value.length < 1) return ;
        return "autocompletar/tb/linea.php?q="+this.text.value +"&filtro="+filtroValue+""});
      </script>
