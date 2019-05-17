<?php
require('../'.PlantillaDOM.'/header_ibarti_2.php');
include('../'.pagDomPdf.'/paginacion_ibarti.php');
?>
<div style="border: 1.5px solid #1B5E20;">
<div>
	<table style="padding-top: 10px;">
		<tbody>
        <tr>
            <td style="padding-bottom: 6px" class="titulos" colspan="4">
                INFORMACIÓN DOTACIÓN
            </td>
        </tr>
             <tr>
            <td width="40%">
                <span class="etiqueta">Código: </span><span class="texto"><?php echo $row['codigo'];?></span>
			</td>
            <td width="40%">
                <span class="etiqueta">Fecha: </span><span class="texto"><?php echo $row['fec_dotacion'];?></span>
			</td>
            <td width="20%" rowspan="5" style="text-align: center; vertical-align: top;">
                <img src="../imagenes/logo.png" width="90" height="70">
            </td>
            </tr>
             <tr>
             <td><span class="etiqueta">N. <?php echo $leng['ficha'];?>: </span>
             <span class="texto"><?php echo $row['cod_ficha'];?></span>
             </td>
            <td><span class="etiqueta"><?php echo $leng['ci'];?>: </span><span class="texto"><?php echo $row['cedula'];?></span></td>
            </tr>
            <tr>
            <td><span class="etiqueta"><?php echo $leng['rol'];?>: </span>
            <span class="texto"><?php echo $row['rol'];?></span></td>
            <td>
                <span class="etiqueta"><?php echo $leng['trabajador'];?>: </span>
                <span class="texto"><?php echo $row['trabajador'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="2"><span class="etiqueta">Descripción: </span>
            <span class="texto"><?php echo $row['descripcion'];?></span></td>
            </tr>
            </tbody>
            </table>
            <table>
            <tbody>
            <?php 
            echo "<tr style='background-color: #4CAF50;'>
            <td><span class='etiqueta'>Linea</span></td>
            <td><span class='etiqueta'>Sub Linea</span></td>
            <td><span class='etiqueta'>Producto</span></td>
            <td><span class='etiqueta'>Cantidad</span></td>
            </tr>";  
            $i=0;
             while ($producto = $bd->obtener_name($queryp))
            { 
                if ($i%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='odd_row'>";
            }?>
            <td>
                <span class="texto"><?php echo $producto['linea'];?></span>
            </td>
            <td>
            <span class="texto"><?php echo $producto['sub_linea'];?></span>
            </td>
            <td>
            <span class="texto"><?php echo $producto['producto'];?></span>
            </td>
             <td>
             <span class="texto"><?php echo $producto['cantidad'];?></span>
            </td>
             </tr>
            <?php ++$i;} ?>
		</tbody>
		</table>
</div>
<br>
     <table>
        <tbody>
            <tr >
            <td style="text-align: center;font-size: 11px;">
                _________________________<br>
                <span class="firma">Revisado Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
            <td style="text-align: center;font-size: 11px;">
                _________________________<br>
                <span class="firma">Recibido Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
            <td style="text-align: center;font-size: 11px;">
                _________________________<br>
                <span class="firma">Verificado Por</span><br><br>
                _____________________<br>
                <span class="firma"><?php echo $leng['ci'];?></span><br><br>
                _____________________<br>
                <span class="firma">Firma</span>
            </td>
             </tr>
             <tr>
             <td colspan="3" style="text-align: center;">
                <span class="nota"><?php echo $row['nota_unif'];?></span>
             </td>
             </tr>  
        </tbody>
        </table>
    </div>
<?php
if($bd->isConnected()){
    $bd->liberar();
}?>
</body>
</html> 