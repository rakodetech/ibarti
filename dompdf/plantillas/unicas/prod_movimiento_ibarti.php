<?php
require('../'.PlantillaDOM.'/header_ibarti_2.php');
include('../'.pagDomPdf.'/paginacion_ibarti.php');

if ($row = $bd->obtener_name($query))
         {
?>
<div style="border: 1.5px solid #1B5E20;">
<div>   
   <table  style="padding-top: 10px;">
		<tbody>
          <tr>
            <td style="padding-bottom: 6px;" class="titulos" colspan="3">
                INFORMACIÓN MOVIMIENTO
            </td>
        </tr>
             <tr  class='odd_row'>
            <td>
                <span class="etiqueta">Código: </span><span class="texto"><?php echo $codigo;?></span>
			</td>
            <td>
                <span class="etiqueta">Fecha: </span><span class="texto"><?php echo conversion($row['fecha'])." ".$row['hora'];?></span>
			</td>
            <td><span class="etiqueta">Tipo Movimiento: </span><span class="texto"><?php echo $row['mov_tipo'];?> </span></td>
            </tr>
             <tr>
             <td><span class="etiqueta">N. <?php echo $leng['ficha'];?>: </span><span class="texto"><?php echo $row['cod_ficha']?> </span>
             </td>
            <td><span class="etiqueta"><?php echo $leng['ci'];?>: </span><span class="texto"><?php echo $row['cedula']?> </span></td>
            <td>
                <span class="etiqueta"><?php echo $leng['trabajador'];?>: </span><span class="texto"><?php echo $row['trabajador']?>
                </span>
            </td>
            </tr>
            <tr class='odd_row'>
            <td>
                <span class="etiqueta">Linea: </span><span class="texto"><?php echo $row['linea'];?></span>
            </td>
            <td>
                <span class="etiqueta">Sub Linea: </span><span class="texto"><?php echo $row['sub_linea'];?></span>
            </td>
            <td>
                <span class="etiqueta">Producto: </span><span class="texto"><?php echo $row['producto'];?></span>
            </td>
             </tr>
            <tr>
                <td colspan='3'><span class="etiqueta">Observación: </span><span class="texto"><?php echo $row['observacion'];?></span></td>
            </tr>
		</tbody>
		</table>
    <table>
        <tbody>
        <tr>
            <td style="padding-bottom: 6px" class="titulos" colspan="2">
                INFORMACIÓN CLIENTE
            </td>
        </tr>
            <tr class='odd_row'>
            <td><span class="etiqueta"><?php echo $leng['cliente'];?>: </span><span class="texto"><?php echo $row['cliente'];?></span></td>
            <td><span class="etiqueta"><?php echo $leng['rif'];?>: </span><span class="texto"><?php echo $row['rif'];?></span></td>
            </tr>
            <tr>
            <td colspan="2"><span class="etiqueta"><?php echo $leng['ubicacion'];?>: </span><span class="texto"><?php echo $row['ubicacion'];?></span></td>
            </tr>
        </tbody>
        </table>
</div>
<br>
     <table>
        <tbody>
            <tr >
            <td style="text-align: center;">
                _________________________<br>
                <span class="firma">Revisado Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
            <td style="text-align: center;">
                _________________________<br>
                <span class="firma">Recibido Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
            <td style="text-align: center;">
                _________________________<br>
                <span class="firma">Verificado Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
             </tr>  
        </tbody>
        </table>
    </div>
<!-- Aqui se cierra la conexion a la base de datos y libera el resultado de la conslta-->
<?php
}
if($bd->isConnected()){
    $bd->liberar();
}?>
</body>
</html> 