<?php
require('../'.PlantillaDOM.'/header_ibarti.php');
include('../'.pagDomPdf.'/paginacion_ibarti.php');

if (file_exists('../'.Foto.'/'.$cedula.'.jpg')){
            $foto = '../'.Foto.'/'.$cedula.'.jpg';
         }else{
            $foto = "../imagenes/foto.jpg";
        }
?>
<!-- FOTO y Datos Principales -->
<div>
	<table>
		<tbody>
			<tr>
                <!-- Foto del trabajador -->
			<td rowspan="2" colspan="1" style="width: 20%; vertical-align:middle; text-align: center;">
                <img id="td_foto" src="<?php echo $foto;?>">
			</td>
                <!-- Nombres y Apellidos del Trabajador -->
            <td colspan="1" id="nombre_cabecera" style="text-align: center; width: 80%">
                <span><?php echo ucwords(strtolower($trabajador['nombres']));?></span>
			</td>
            </tr>
            <tr>
            <td colspan="1" class="cab" style="text-align: center;">
                 <span><?php echo ucwords(strtolower($trabajador['cargo']));?></span>
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
                <h4>DATOS BASICOS</h4>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"><?php echo $leng['ci'];?>: </span><span class="texto"><?php echo $trabajador['cedula'];?></span>
			</td>
            <td>
                <span class="etiqueta"><?php echo $leng['correo'];?>: </span><span class="texto"><?php echo $trabajador['correo'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta"><?php echo $leng['nacionalidad'];?>: </span><span class="texto"><?php echo $trabajador['nacionalidad'];?></span>
			</td>
            <td>
                <span class="etiqueta"><?php echo $leng['estado_civil'];?>: </span><span class="texto"><?php echo $trabajador['estado_civil'];?>
                </span>
                 </td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Fecha de Nacimiento: </span><span class="texto"><?php echo  conversion($trabajador['fec_nacimiento']);?></span>
			</td>
            <td>
                <span class="etiqueta">Lugar de Nacimiento: </span><span class="texto"><?php echo $trabajador['lugar_nac'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta">Carnet: </span><span class="texto"><?php echo valorF($trabajador['carnet']);?></span>
			</td>
            <td>
                <span class="etiqueta">Fecha Carnet: </span><span class="texto"><?php echo conversion($trabajador['fec_carnet']);?></span>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Teléfono: </span><span class="texto"><?php echo $trabajador['telefono'];?></span>
			</td>
            <td>
                <span class="etiqueta">Celular: </span><span class="texto"><?php echo $trabajador['celular'];?></span>
			</td>
            </tr>
             <tr>
             <td>
                <span class="etiqueta">Ocupacion: </span><span class="texto"><?php echo $trabajador['ocupacion'];?></span>
			</td>
            <td>
                <span class="etiqueta">Sexo: </span><span class="texto"><?php echo $trabajador['sexo'];?></span>
			</td>
            </tr>
            <tr class="odd_row">
             <td>
                <span class="etiqueta"><?php echo $leng['estado'];?>: </span><span class="texto"><?php echo $trabajador['estado'];?></span>
			</td>
            <td>
                <span class="etiqueta"><?php echo $leng['ciudad'];?>: </span><span class="texto"><?php echo $trabajador['ciudad'];?></span>
			</td>
            </tr>
            <tr>
            <td colspan="2" style="vertical-align: top;">
            <span class="etiqueta">Dirección: </span><span class="texto"><?php echo $trabajador['direccion'];?></span>
			</td>
            </tr>
            
		</tbody>
		</table>
</div>

    <!-- Tabla datos laborales -->
<div>
        <table>
        <tbody>
            <tr>
            <td class="titulos" colspan="2">
                <h4>DATOS LABORALES</h4>
			</td>
            </tr>
            <tr class="odd_row">
             <td>
                 <span class="etiqueta">Años de Experiencia Laboral: </span><span class="texto"><?php echo $trabajador['experiencia'];?></span>
			</td>
            <td>
                <span class="etiqueta">Nivel Academico: </span><span class="texto"><?php echo $trabajador['nivel_academico'];?></span>
			</td>
            </tr>
            <tr>
            <td>
                 <span class="etiqueta">Contrato: </span><span class="texto"><?php echo $trabajador['contrato'];?></span>
			</td>
            <td>
                <span class="etiqueta">Números Contratos: </span><span class="texto"><?php echo $trabajador['numero_de_contratos'];?></span>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Región: </span><span class="texto"><?php echo $trabajador['region'];?></span>
			</td>
            <td>
                <span class="etiqueta">Turno: </span><span class="texto"><?php echo $trabajador['turno'];?></span>
			</td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Empresa: </span><span class="texto"><?php echo $trabajador['empresa'];?></span>
			</td>
            <td>                
                <span class="etiqueta">Ubicación: </span><span class="texto"><?php echo $trabajador['ubicacion'];?></span>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Banco: </span><span class="texto"><?php echo $trabajador['banco'];?></span>
			</td>
            <td>
                <span class="etiqueta">Cuenta Banco: </span><span class="texto"><?php echo $trabajador['cta_banco'];?></span>
			</td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Agrupación: </span><span class="texto"><?php echo $trabajador['agrupacion'];?></span>
            </td>
            <td>
                <span class="etiqueta">Status: </span><span class="texto"><?php echo $trabajador['status'];?></span>
            </td>
            </tr>
             <tr class="odd_row">
            <td colspan="2" style="vertical-align: top;"><span class="etiqueta">Observacion: </span><span class="texto"><?php echo $trabajador['observacion'];?>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta">Fecha Sistema Integración: </span><span class="texto"><?php echo conversion($trabajador['fec_profit']);?></span>
			</td>
            <td>
                <span class="etiqueta">Fecha de ingreso: </span><span class="texto"><?php echo conversion($trabajador['fec_ingreso']);?></span>
			</td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Fecha Creación Ficha: </span><span class="texto"><?php echo conversion($trabajador['fec_us_ing']);?></span>
			</td>
            <td>
                <span class="etiqueta">Usuario Creación Ficha: </span><span class="texto"><?php echo $trabajador['nom_usu_ing'];?></span>
			</td>
            </tr>
        </tbody>
        </table>
        </div>
<?php if (!$queryf->num_rows === 0) { ?>
            <!-- Tabla carga Familiar -->
<div>
    <table>
        <tbody>  
            <tr>
            <td class="titulos" colspan="5">
                <h4>CARGA FAMILIAR</h4>
            </td>
            </tr>
            <tr style='background-color: #4CAF50;'>
            <th width="10%"><span>Código</span></th>
            <th width="35%"><span>Nombre</span></th>
            <th width="25%"><span>Fecha de Nacimiento</span></th>
            <th width="15%"><span>Sexo</span></th>
            <th width="15%"><span>Parentesco</span></th>
            </tr>
            <?php 
            $i=0;
             while ($familia = $bd->obtener_name($queryf))
            {      
            if ($i%2==0){
                echo "<tr>";
            }else{
                echo "<tr class='odd_row'>";
            }?>
                <td width="10%"><?php echo $familia['codigo'];?></td>
                <td width="35%"><?php echo $familia['nombres'];?></td>
                <td width="25%"><?php echo conversion($familia['fec_nac']);?></td>
                <td width="15%"><?php echo valorSEXO($familia['sexo']);?></td>
                <td width="15%"><?php echo $familia['parentesco'];?></td>
            </tr>
        <?php
            ++$i;}
        ?>
        </tbody>
        </table>
        </div>
<?php } ?>
<hr>
<!--DOTACION-->
        <div>
        <table>
        <tbody>
            <tr>
            <td class="titulos"  colspan="6" style="padding-left: 0;">
                <h4>ULTIMA DOTACION DE UNIFORMES</h4>
            </td>
            </tr>
            <tr style='background-color: #4CAF50;'>
            <th width="10%">Cod. Dot.</th>
            <th width="15%">Fecha Dotación</th>
            <th width="15%">Linea</th>
            <th width="15%">Sub Linea</th>
            <th width="35%"> Producto</th>
            <th width="10%">Cantidad</th>
            </tr>
            
            <?php
            if($bd->obtener_name($queryd)){
            $i=0;
                while ($dotacion = $bd->obtener_name($queryd)) {
                    $i++;
           
            if ($i%2==0){
                echo "<tr class='odd_row'>";
            }else{
                echo "<tr>";
            }
            ?>
            <td width="10%" style="text-align: center;">
                <span><?php echo $dotacion['cod_dotacion'];?></span>
            </td>
            <td width="15%" style="text-align: center;">
                <span><?php $date = date_create($dotacion['fec_dotacion']);
                             echo  date_format($date, 'd-m-Y');?></span>
            </td>
            <td width="15%">
                <span><?php echo $dotacion['linea'];?></span>
            </td>
            <td width="15%">
                <span><?php echo $dotacion['sub_linea'];?></span>
            </td>
            <td width="35%">
                <span><?php echo $dotacion['descripcion'];?></span>
            </td>
            <td width="10%" style="text-align: center;">
                <span><?php echo $dotacion['cantidad'];?></span>
            </td>
            </tr>
            <?php
                }
            }else{
              echo " <tr>
            <td style='text-align: center;' colspan='6'>
                Sin Dotaciones...
            </td></tr>";
            }
            ?>
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