<?php
session_start();
require_once('../../../../sql/sql_report_t.php');
require "../modelo/ajuste_modelo.php";
require "../../../../".Leng;
$titulo     = "MOVIMIENTO";
$ajuste  = new Ajuste;
$listar  =  $ajuste->get();
?>
<div align="center" class="etiqueta_title">CONSULTA <?php echo $titulo;?></div>
<div id="Contenedor01"></div>
<fieldset>
  <legend>Filtros:</legend>
  <table width="100%">
    <tr><td width="10%">Linea: </td>
      <td width="14%"><select name="linea" id="linea" style="width:120px;"
        onchange="Add_Sub_Linea(this.value, 'contenido_sub_linea', 'T', '120')">
        <option value="TODOS">TODOS</option>
        <?php
        $query01 = $bd->consultar($sql_linea);
        while($row01=$bd->obtener_fila($query01,0)){
         echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
       }?></select></td>
       <td width="10%">Sub Linea: </td>
       <td width="14%" id="contenido_sub_linea"><select name="sub_linea" id="sub_linea" style="width:120px;">
        <option value="TODOS">TODOS</option>
       </select></td>
       <td width="12%">Tipo Mov.:</td>
       <td width="14%"><select  name="tipo_mov" id="tipo_mov" style="width:110px;">
        <option value="TODOS">TODOS</option>
        <?php
        $query01 = $bd->consultar($sql_tipo_mov);
        while($row01=$bd->obtener_fila($query01,0)){
         echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
       }?></select></td>
       <td width="10%"><?php echo $leng['estado'];?>: </td>
       <td width="14%"><select  name="estado" id="estado" style="width:120px;">
        <option value="TODOS">TODOS</option>
        <?php
        $query01 = $bd->consultar($sql_estado);
        while($row01=$bd->obtener_fila($query01,0)){
         echo '<option value="'.$row01[0].'">'.$row01[1].'</option>';
       }?></select></td>
       <td width="4%" id="cont_img"><img class="imgLink" id="img_actualizar" src="imagenes/actualizar.png" border="0"
        onclick="buscar_ajuste(true)"  /></td>
        <td><input type="hidden" name="Nmenu" id="Nmenu" value="<?php echo $Nmenu;?>" />
         <input type="hidden" name="mod" id="mod" value="<?php echo $mod;?>" />
         <input type="hidden" name="archivo" id="archivo" value="<?php echo $archivo;?>" />
         <input type="hidden" name="tabla" id="tabla" value="<?php echo $tabla;?>"/></td>
       </tr>
       <tr>
         <td>Filtro Prod.:</td>
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
     <div class="tabla_sistema listar">
      <table  width="100%" border="0" align="center">
        <thead>
          <tr>
            <th>N. Movimiento</th>
            <th>Referencia</th>      
            <th>Fecha</th>          
            <th>Tipo Movimiento</th>
            <th>Descripcion</th>
            <th>Monto</th>
        <th align="center"><img src="imagenes/nuevo.bmp" alt="Agregar Registro" title="Agregar Registro" width="20px" height="20px" border="null"onclick="Form_ajuste('','agregar')" title="Agregar Registro"/></th>
    </tr>
        </thead>
        <tbody id="listar_ajuste">
          <?php
          foreach ($listar as  $datos) {

            echo '
            <tr onclick="Form_ajuste(\''.$datos["codigo"].'\', \'modificar\',\''.$datos["cod_tipo"].'\',\''.$datos["anulado"].'\')">
            <td>'.$datos["codigo"].'</td>
            <td>'.$datos["referencia"].'</td>
            <td>'.$datos["fecha"].'</td>
            <td>'.$datos["tipo"].'</td>
            <td>'.$datos["motivo"].'</td>
            <td>'.$datos["total"].'</td>
            <td></td>
            </tr>';
          } ?>

        </tbody>
      </table>
    </div>
