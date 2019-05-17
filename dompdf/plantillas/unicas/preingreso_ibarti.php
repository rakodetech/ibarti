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
	<table style="padding-top: 10px;">
		<tbody>
			<tr>
                <!-- Foto del trabajador -->
			<td rowspan="2" colspan="1" style="width: 20%; vertical-align:middle; text-align: center;">
			     <img id="td_foto" src="<?php echo $foto;?>">
			</td>
                <!-- Nombres y Apellidos del Trabajador -->
            <td colspan="1" id="nombre_cabecera" style="text-align: center; width: 80%;">
                <span><?php echo ucwords(strtolower($trabajador['nombres'].' '.$trabajador['apellidos']));?></span>
			</td>
            </tr>
            <tr>
                <!-- Nivel Academico del Trabajador concatenado a su Cargo-->
            <td colspan="1" class="cab" style="text-align: center;">
                 <span><?php echo ucwords(strtolower($trabajador['cargo']));?></span>
			</td>
            </tr>
		</tbody>
		</table>
</div>


<!-- Todos los demas datos -->
    <!-- Tabla datos Básicos -->
<div>
        <table>
		<tbody>
            <tr>
            <td class="titulos"  colspan="2">
                <h4>DATOS PREINGRESO TRABAJADOR</h4>
			</td>
            </tr>
             <tr  class="odd_row">
            <td>
                <span class="etiqueta"><?php echo $leng['ci'];?>: </span><span class="texto"><?php echo $trabajador['cedula'];?></span>
			</td>
            <td>
                <span class="etiqueta"><?php echo $leng['correo'];?>: </span><span class="texto"> <?php echo $trabajador['correo'];?></span>
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
             <tr  class="odd_row">
            <td>
                <span class="etiqueta">Fecha de Nacimiento: </span><span class="texto"><?php echo conversion($trabajador['fec_nacimiento']);?></span>
			</td>
            <td>
                <span class="etiqueta">Lugar de Nacimiento: </span><span class="texto"><?php echo $trabajador['lugar_nac'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta">Teléfono: </span><span class="texto"><?php echo $trabajador['telefono'];?></span>
			</td>
            <td>
                <span class="etiqueta">Teléfono Celular: </span><span class="texto"><?php echo $trabajador['celular'];?></span>
			</td>
            </tr>
             <tr  class="odd_row">
             <td>
                <span class="etiqueta">Ocupación: </span><span class="texto"> <?php echo $trabajador['ocupacion'];?></span>
			</td>
            <td>
                <span class="etiqueta">Sexo: </span><span class="texto"> <?php echo $trabajador['sexo'];?></span>
			</td>
            </tr>
            <tr>
             <td>
                <span class="etiqueta"><?php echo $leng['estado'];?>: </span><span class="texto"> <?php echo $trabajador['estado'];?></span>
			</td>
            <td>
                <span class="etiqueta"><?php echo $leng['ciudad'];?>: </span><span class="texto"><?php echo $trabajador['ciudad'];?></span>
			</td>
            </tr>
            <tr class="odd_row">
            <td colspan="2" style="vertical-align: top;">
            <span class="etiqueta">Dirección: </span><span class="texto"><?php echo $trabajador['direccion'];?></span>
			</td>
            </tr>
            <tr>
             <td>
                 <span class="etiqueta">Años de Experiencia Laboral: </span><span class="texto"><?php echo $trabajador['experiencia'];?></span>
			</td>
            <td>
                <span class="etiqueta">Nivel Académico: </span><span class="texto"><?php echo $trabajador['nivel_academico'];?></span>
			</td>
            </tr>
             <tr class="odd_row">
            <td style="vertical-align: top;" colspan="2">
            <span class="etiqueta">Observacion: </span><span class="texto"><?php echo $trabajador['observacion'];?></span>
			</td>
            </tr>
             <tr>
            <td>
                <span class="etiqueta">Fecha de preingreso: </span><span class="texto"><?php echo conversion($trabajador['fec_preingreso']);?></span>
            </td>
            <td>
                <span class="etiqueta">Status: </span><span class="texto"><?php echo $trabajador['status'];?></span>
            </td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Fecha Ingreso Sistema: </span><span class="texto"><?php echo conversion($trabajador['fec_us_ing']);?></span>
			</td>
            <td>
                <span class="etiqueta">Usuario Ingreso Sistema: </span><span class="texto"><?php echo $trabajador['nom_usu_ing'];?></span>
			</td>
            </tr>
        </tbody>
        </table>
        </div>
<div>
        <table>
        <tbody>
            <tr>
            <td class="titulos"  colspan="2">
                <h4>CHEQUEO TRABAJADOR</h4>
            </td>
            </tr>
             <tr  class="odd_row">
            <td>
                <span class="etiqueta"><?php echo $leng['psic_fec'];?>: </span><span class="texto"><?php echo conversion($trabajador['fec_psic']);?></span>
            </td>
            <td>
                <span class="etiqueta"><?php echo $leng['psic_desc'];?>: </span><span class="texto"><?php echo $trabajador['psic_apto'];?></span>
            </td>
            </tr>
            <tr>
             <td colspan="2">
                <span class="etiqueta"><?php echo $leng['psic_observ'];?>: </span><span class="texto"><?php echo $trabajador['psic_observacion'];?></span>
            </td>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta"><?php echo $leng['pol_fec'];?>: </span><span class="texto"><?php echo conversion($trabajador['fec_pol']);?></span>
            </td>
            <td>
                <span class="etiqueta"><?php echo $leng['pol_desc'];?>: </span><span class="texto"><?php echo Chequepolc($trabajador['pol_apto']);?></span>
            </td>
            </tr>
            <tr>
             <td colspan="2">
                <span class="etiqueta"><?php echo $leng['pol_observ'];?>: </span><span class="texto"><?php echo $trabajador['pol_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
    </div>

<!-- Salto de Página -->
<hr>

<!-- REFERNCIA PERSONAL 1 -->
    <div>
        <table>
        <tbody>
            <tr>
            <td class="titulos"  colspan="3">
                <h4>REFERENCIAS PERSONALES</h4>
            </td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: center;padding-bottom: 5px;">Referencia Personal 1</th>
            </tr>
             <tr  class="odd_row">
            <td>
                <span class="etiqueta">Nombre: </span><span class="texto"><?php echo $trabajador['refp01_nombre'];?></span>
            </td>
            <td colspan="2">
                <span class="etiqueta">Ocupación: </span><span class="texto"><?php echo $trabajador['refp01_ocupacion'];?></span>
            </td> 
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Número de Telefono: </span><span class="texto"><?php echo $trabajador['refp01_telf'];?></span>
            </td>
            <td>
                <span class="etiqueta">Parentesco: </span><span class="texto"><?php echo $trabajador['refp01_parentezco'];?></span>
            </td>
            <td>
            <span class="etiqueta"> Status: </span> <span class="texto" style="text-transform: uppercase;"><?php echo $trabajador['refp01_apto'];?></span>
            </td>
            </tr>
            <tr  class="odd_row">
            <td style="vertical-align: top;" colspan="3">
                <span class="etiqueta">Dirección: </span><span class="texto"><?php echo $trabajador['refp01_direccion'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Observación: </span><span class="texto"><?php echo $trabajador['refp01_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
            </div>

            <!-- REFERNCIA PERSONAL 2 -->
        <div>
        <table>
        <tbody>
            <tr>
            <td colspan="3">
            </td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: center;padding-bottom: 5px; padding-top: 5px;">Referencia Personal 2</th>
            </tr>
            <tr class="odd_row">
            <td>
                <span class="etiqueta">Nombre: </span><span class="texto"><?php echo $trabajador['refp02_nombre'];?></span>
            </td>
            <td colspan="2">
                <span class="etiqueta">Ocupación: </span><span class="texto"><?php echo $trabajador['refp02_ocupacion'];?></span>
            </td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Número de Telefono: </span><span class="texto"><?php echo $trabajador['refp02_telf'];?></span>
            </td>
            <td>
                <span class="etiqueta">Parentesco: </span><span class="texto"><?php echo $trabajador['refp02_parentezco'];?></span>
            </td>
            <td>
                <span class="etiqueta">Status: </span><span class="texto"><span style="text-transform: uppercase;"><?php echo $trabajador['refp02_apto'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Dirección: </span><span class="texto"><?php echo $trabajador['refp02_direccion'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Observación: </span><span class="texto"><?php echo $trabajador['refp02_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
            </div>

           <!-- REFERNCIA PERSONAL 3 -->
        <div>
        <table>
        <tbody>
        <tr>
            <td colspan="3">
            </td>
        </tr>
        <tr>
                <th colspan="3" style="text-align: center;padding-bottom: 5px; padding-top: 5px;">Referencia Personal 3</th>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Nombre: </span><span class="texto"><?php echo $trabajador['refp03_nombre'];?></span>
            </td>
            <td colspan="2">
                <span class="etiqueta">Ocupación: </span><span class="texto"><?php echo $trabajador['refp03_ocupacion'];?></span>
            </td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Número de Telefono: </span><span class="texto"><?php echo $trabajador['refp03_telef'];?></span>
            </td>
            <td>
                <span class="etiqueta">Parentesco: </span><span class="texto"><?php echo $trabajador['refp03_parentezco'];?></span>
            </td>
            <td>
                <span class="etiqueta">Status: </span><span class="texto" style="text-transform: uppercase;"><?php echo $trabajador['refp03_apto'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Dirección: </span><span class="texto"><?php echo $trabajador['refp03_direccion'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Observación: </span><span class="texto"><?php echo $trabajador['refp03_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
            </div>

<!-- REFERENCIAS LABORALES DEL TRABAJADOR -->
<!-- REFERNCIA LABORAL 1 -->
    <div>
        <table>
        <tbody>
            <tr>
            <td class="titulos"  colspan="3">
                <h4>REFERENCIAS LABORALES</h4>
            </td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: center;padding-bottom: 5px;">Referencia Laboral 1</th>
            </tr>
             <tr class="odd_row">
            <td>
                <span class="etiqueta">Empresa: </span><span class="texto"><?php echo $trabajador['refl01_empresa'];?></span>
            </td>
            <td>
                <span class="etiqueta">N° de Teléfono: </span><span class="texto"><?php echo $trabajador['refl01_telf'];?></span>
            </td>
            <td>
                <span class="etiqueta">Contacto: </span><span class="texto"><?php echo $trabajador['refl01_contacto'];?></span>
            </td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Cargo: </span><span class="texto"><?php echo $trabajador['refl01_cargo'];?></span>
            </td>
            <td>
                <span class="etiqueta">Sueldo Inicial: </span><span class="texto"><?php echo $trabajador['refl01_sueldo_inic'];?></span>
            </td>
            <td>
                <span class="etiqueta">Sueldo Final: </span><span class="texto"><?php echo $trabajador['refl01_sueldo_fin'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td>
                <span class="etiqueta">Fecha de Ingreso: </span><span class="texto"><?php echo conversion($trabajador['refl01_fec_ingreso']);?></span>
            </td>
            <td>
                <span class="etiqueta">Fecha de Egreso: </span><span class="texto"><?php echo conversion($trabajador['refl01_fec_egreso']);?></span>
            </td>
            <td>
            <span class="etiqueta">Status: </span><span class="texto" style="text-transform: uppercase;"><?php echo $trabajador['refl01_apto'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3">
                <span class="etiqueta">Motivo de Retiro: </span><span class="texto"><?php echo $trabajador['refl01_retiro'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Direccion: </span><span class="texto"><?php echo $trabajador['refl01_direccion'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Observacion: </span><span class="texto"><?php echo $trabajador['refl01_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
            </div>

            <!-- REFERNCIA LABORAL 2 -->
    <div>
        <table>
        <tbody>
            <tr>
                <th colspan="3" style="text-align: center;padding-bottom: 5px; padding-top: 5px;">Referencia Laboral 2</th>
            </tr>
             <tr  class="odd_row">
            <td>
                <span class="etiqueta">Empresa: </span><span class="texto"><?php echo $trabajador['refl02_empresa'];?></span>
            </td>
            <td>
                <span class="etiqueta">N° de Teléfono: </span><span class="texto"><?php echo $trabajador['refl02_telf'];?></span>
            </td>
            <td>
                <span class="etiqueta">Contacto: </span><span class="texto"><?php echo $trabajador['refl02_contacto'];?></span>
            </td>
            </tr>
            <tr>
            <td>
                <span class="etiqueta">Cargo: </span><span class="texto"><?php echo $trabajador['refl02_cargo'];?></span>
            </td>
            <td>
                <span class="etiqueta">Sueldo Inicial: </span><span class="texto"><?php echo $trabajador['refl02_sueldo_inic'];?></span>
            </td>
            <td>
                <span class="etiqueta">Sueldo Final: </span><span class="texto"><?php echo $trabajador['refl02_sueldo_fin'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td>
                <span class="etiqueta">Fecha de Ingreso: </span><span class="texto"><?php echo conversion($trabajador['refl02_fec_ingreso']);?></span>
            </td>
            <td>
                <span class="etiqueta">Fecha de Egreso: </span><span class="texto"><?php echo conversion($trabajador['refl02_fec_egreso']);?></span>
            </td>
            <td>
                <span class="etiqueta">Status: </span><span class="texto" style="text-transform: uppercase;"><?php echo $trabajador['refl02_apto'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3">
                <span class="etiqueta">Motivo de Retiro: </span><span class="texto"><?php echo $trabajador['refl02_retiro'];?></span>
            </td>
            </tr>
            <tr class="odd_row">
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Direccion: </span><span class="texto"><?php echo $trabajador['refl02_direccion'];?></span>
            </td>
            </tr>
            <tr>
            <td colspan="3" style="vertical-align: top;">
                <span class="etiqueta">Observacion: </span><span class="texto"><?php echo $trabajador['refl02_observacion'];?></span>
            </td>
            </tr>
            </tbody>
            </table>
            </div>
            
<?php
if($bd->isConnected()){
    $bd->liberar();
}
?>
</body>
</html>