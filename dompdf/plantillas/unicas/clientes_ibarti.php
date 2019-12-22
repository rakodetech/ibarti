<?php
require('../'.PlantillaDOM.'/header_ibarti.php');
include('../'.pagDomPdf.'/paginacion_ibarti.php');

?>
<!-- FOTO y Datos Principales -->
<div>
	<table>
		<tbody>
			<tr>
                <!-- Nombres y Apellidos del Trabajador -->
            <td colspan="1" id="nombre_cabecera" style="text-align: center; width: 100%">
                <span>
                <?php        
                    echo $cliente['nombre'];
                ?>
                </span>
			</td>
            </tr>
		</tbody>
		</table>
</div>
    <!-- Tabla datos Básicos -->
<div>
        <table>
		<tbody>
            <tr>
            <td class="titulos"  colspan="2">
                <h4>DATOS EMPRESA</h4>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"><b>Codigo:</b> </span><span class="texto"><?php echo $cliente['codigo'];?></span>
			</td>
            <td>
                <span class="etiqueta"><b>Abreviatura:</b> </span><span class="texto"><?php echo $cliente['abrev'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta"><b>Rif:</b> </span><span class="texto"><?php echo $cliente['rif'];?></span>
			</td>
            <td>
                <span class="etiqueta"><b>Nit:</b> </span><span class="texto"><?php echo $cliente['nit'];?>
                </span>
                 </td>
            </tr>
             <tr class="odd_row">
            <td>
            <span class="etiqueta"><b>Juridico:</b> </span><span class="texto"><?php echo ($cliente['juridico']=="T")?"SI":"NO";?></span>
			</td>
            <td>
            <span class="etiqueta"><b>Contribuyente:</b> </span><span class="texto"><?php echo ($cliente['juridico']=="T")?"SI":"NO";?></span>
			</td>
            </tr>
             <tr>
            <td>
            <span class="etiqueta"><b>Tipo de Empresa:</b> </span><span class="texto"><?php echo $cliente['cl_tipo'];?></span>
                
			</td>
            <td>
            <span class="etiqueta"><b>Telefono:</b> </span><span class="texto"><?php echo $cliente['telefono'];?></span>
                
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"><b>Region:</b> </span><span class="texto"><?php echo $cliente['region'];?></span>
			</td>
            <td>
                <span class="etiqueta"><b>vendedor:</b> </span><span class="texto"><?php echo $cliente['vendedor'];?></span>
			</td>
            </tr>
             <tr>
             <td>
                <span class="etiqueta"><b>Email:</b> </span><span class="texto"><?php echo $cliente['email'];?></span>
			</td>
            <td>
            <span class="etiqueta"><b>Fax:</b> </span><span class="texto"><?php echo $cliente['fax'];?></span>
			</td>
            </tr>
            <tr class="odd_row">
            <td>
            <span class="etiqueta"><b>Website:</b> </span><span class="texto"><?php echo $cliente['website'];?></span>
            </td>
            <td colspan="1">
            <span class="etiqueta"><b>Observacion:</b> </span><span class="texto"><?php echo $cliente['observacion'];?></span>
			</td>
            </tr>
            <tr >
            <td colspan="2"  style="vertical-align: top;">
            <span class="etiqueta"><b>Dirección:</b> </span><span class="texto"><?php echo $cliente['direccion'];?></span>
			</td>
            </tr>
            
		</tbody>
		</table>
</div>

<div>
        <table>
        <tbody>
            <tr>
            <td class="titulos" colspan="2">
                <h4>DATOS CONTACTOS EMPRESA</h4>
			</td>
            </tr>
            <tr>
             <td colspan="2">          
                <table width="100%">
                <tr class='odd_row'>
                    <td  style="font-weight: bold;" width="15%" >Documento</td>
                    <td  style="font-weight: bold;" width="20%">Nombres</td>
                    <td  style="font-weight: bold;" width="15%">Cargo</td>
                    <td  style="font-weight: bold;" width="15%">Telefono</td>
                    <td  style="font-weight: bold;" width="35%">Correo</td>
                </tr>
                <?php
                $i=0;
                while ($datos = $bd->obtener_fila($queryf)){
                    if($i%2==0){
                        echo "<tr >";
                    }else{
                        echo "<tr class='odd_row'>";
                    }
                    ?>
                    <td width="15%"><?php echo $datos['doc'];?></td>
                    <td width="20%"><?php echo $datos['nombres'];?></td>
                    <td width="15%"><?php echo $datos['cargo'];?></td>
                    <td width="15%"><?php echo $datos['tel'];?></td>
                    <td width="35%"><?php echo $datos['correo'];?></td>
                    <?php
                   }
                   echo "</tr>";
                ?>
                </table>
			</td>
            </tr>
        </tbody>
        </table>
                   
        </div>
    </div>
    <div>
        <table>
		<tbody>
            <tr>
            <td class="titulos"  colspan="2">
                <h4>DATOS ADICIONALES EMPRESA</h4>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"> <b>Limite Credito:</b> </span><span class="texto"><?php echo $cliente['limite_cred'];?></span>
			</td>
            <td>
                <span class="etiqueta"> <b>Dias Plazo Pago:</b> </span><span class="texto"><?php echo $cliente['plazo_pago'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta"> <b>Descuento Pronto Pago:</b> </span><span class="texto"><?php echo $cliente['desc_p_pago'];?></span>
			</td>
            <td>
                <span class="etiqueta"> <b>Descuento Global:</b> </span><span class="texto"><?php echo $cliente['desc_global'];?>
                </span>
                 </td>
            </tr>
            <tr class="odd_row">
            <td colspan="2"  style="vertical-align: top;">
            <span class="etiqueta"> <b>Dirección de Entrega:</b> </span><span class="texto"><?php echo $cliente['dir_entrega'];?></span>
			</td>
            </tr>
            <tr>
            <td colspan="2"  style="vertical-align: top;">
            <span class="etiqueta"> <b>Dias de Visitas:</b> </span>
            <span class="texto">
            <?php
            echo $cliente['lunes']=="T"?"| Lunes | ":"";
            echo $cliente['martes']=="T"?"Martes | ":"";
            echo $cliente['miercoles']=="T"?"Miercoles | ":"";
            echo $cliente['jueves']=="T"?"Jueves | ":"";
            echo $cliente['viernes']=="T"?"Viernes | ":"";
            ?>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"> <b>Campo adiccional 01:</b> </span><span class="texto"><?php echo $cliente['campo01'];?></span>
			</td>
            <td>
                <span class="etiqueta"> <b>Campo adiccional 02:</b> </span><span class="texto"><?php echo $cliente['campo02'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta"> <b>Campo adiccional 03:</b> </span><span class="texto"><?php echo $cliente['campo03'];?></span>
			</td>
            <td>
                <span class="etiqueta"> <b>Campo adiccional 04:</b> </span><span class="texto"><?php echo $cliente['campo04'];?></span>
			</td>
            </tr>
            
		</tbody>
		</table>
</div>
<!-- Aqui se cierra la conexion a la base de datos y libera el resultado de la conslta-->
<?php
if($bd->isConnected()){
    $bd->liberar();
}
?>
</body>
</html> 