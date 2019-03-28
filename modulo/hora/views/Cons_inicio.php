<?php
include_once "../../../funciones/funciones.php";
require"../../../autentificacion/aut_config.inc.php";
require "../../../".class_bd;
require "../../../".Leng;

 $bd = new DataBase();

$titulo = $leng['hora'];

$sql = " SELECT horarios.codigo, horarios.nombre,
                  horarios.hora_entrada, horarios.hora_salida,
                  horarios.inicio_marc_entrada, horarios.fin_marc_entrada,
                  horarios.inicio_marc_salida, horarios.fin_marc_salida,
                  horarios.dia_trabajo, horarios.minutos_trabajo,
                  horarios.`status`
             FROM horarios
      ORDER BY 2 ASC ";



//      require "../../../modulo/hora/modelo/hora_modelo.php";
//      $horario = new Horario_modelo;
//      $matriz  = $horario ->get_horario();
?>

<div align="center" class="etiqueta_title"> Consulta De <?php echo $titulo;?> </div> <hr />
<div class="tabla_sistema"><table width="100%" border="0" align="center">
		<tr>
			<th width="10%">Codigo</th>
			<th width="25%">Nombre</th>
            <th width="12%">Hora Entrada</th>
            <th width="12%">Hora Salida</th>
            <th width="12%">Inicio Marcaje<br />Entrada</th>
            <th width="12%">Fin Marcaje<br />Entrada</th>
            <th width="12%" class="etiqueta">Status</th>
  		    <th width="5%" align="center"><img src="imagenes/nuevo.bmp" alt="Agregar" onclick="Cons_hora('', 'agregar')" title="Agregar Registro" width="30px" height="30px" border="null"/></th>
		</tr>
    <?php

   $query = $bd->consultar($sql);
		while ($datos=$bd->obtener_fila($query,0)){

        echo '<tr>
           <td>'.$datos["codigo"].'</td>
				   <td>'.longitud($datos["nombre"]).'</td>
				   <td>'.$datos["hora_entrada"].'</td>
				   <td>'.$datos["hora_salida"].'</td>
				   <td>'.$datos["inicio_marc_entrada"].'</td>
				   <td>'.$datos["fin_marc_entrada"].'</td>
				  <td>'.statuscal($datos["status"]).'</td>
				  <td><img src="imagenes/actualizar.bmp" onclick="Cons_hora(\''.$datos[0].'\', \'modificar\')" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/></a>&nbsp;<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="Borrar_hora(\''.$datos[0].'\')"/></td></tr>';
        }
  	?>
    </table>
</div>
