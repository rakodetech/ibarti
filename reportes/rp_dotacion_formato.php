<?php
define("SPECIALCONSTANT", true);
session_start();
require("../autentificacion/aut_config.inc.php");
include_once('../' . Funcion);
require_once("../" . class_bdI);
require_once("../" . Leng);
$bd = new DataBase();
$codigo = $_POST['cod'];
$vista  = $_POST['vista'];

$archivo = 'comprobante_paquete_dotacion.pdf';

switch ($vista) {
    case 'vista_dotacion':

        $sql = "SELECT codigo, fec_us_mod fec_dotacion ,observacion obs FROM dotacion_proceso WHERE codigo = '$codigo'";
        $queryp = $bd->consultar($sql);
        $row = $bd->obtener_fila($queryp, 0);



        $sql = "SELECT 
    a.codigo codigo_dotacion,
    c.cod_ficha ficha,
    concat(c.nombres,' ',c.apellidos) trabajador
    FROM prod_dotacion a
    INNER JOIN dotacion_proceso_det b ON a.codigo = b.cod_dotacion
    INNER JOIN dotacion_proceso d ON d.codigo = b.cod_dotacion_proceso
    INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
    WHERE d.codigo = '$codigo'";
        $query = $bd->consultar($sql);


        break;
    case 'vista_recepcion':

        $sql = "SELECT codigo, fec_us_mod fec_dotacion, observacion obs FROM dotacion_recepcion WHERE codigo = '$codigo'";
        $queryp = $bd->consultar($sql);
        $row = $bd->obtener_fila($queryp, 0);



        $sql = "SELECT 
        a.codigo codigo_dotacion,
        c.cod_ficha ficha,
        concat(c.nombres,' ',c.apellidos) trabajador
        FROM prod_dotacion a
        INNER JOIN dotacion_recepcion_det b ON a.codigo = b.cod_dotacion
        INNER JOIN dotacion_recepcion d ON d.codigo = b.cod_dotacion_recepcion
        INNER JOIN ficha c on c.cod_ficha = a.cod_ficha
        WHERE d.codigo = '$codigo'";
        $query = $bd->consultar($sql);
        # code...
        break;
}




//require_once('../' . ConfigDomPdf);

//$dompdf = new DOMPDF();

//ob_start();

$titulo = 'LISTADO DE PAQUETES DE DOTACIONES <span class="etiqueta">(#' . $row["codigo"] . ')';
require('../' . PlantillaDOM . '/header_ibarti_2.php');
include('../' . pagDomPdf . '/paginacion_ibarti.php');

$mostrar = '<div style="border: 1.5px solid #1B5E20;">
<div style="">
    <table style="padding-top: 10px;" >
        
            <tr>
                <td style="padding-bottom: 6px" class="titulos" colspan="4">
                    DETALLE DE PAQUETE DE DOTACIONES
                </td>
                
            </tr>
            <tr>
                <td width="80%">
                    <span class="etiqueta">Código: </span><span class="texto">' . $row["codigo"] . '</span>
                </td>
                <td width="20%" rowspan="5" style="float:right; vertical-align: top;">
                     <img src="../imagenes/logo.png" width="90" height="70">
                </td>
            </tr>
            <tr>
                <td width="40%">
                    <span class="etiqueta">Fecha Produccion: </span>
                    <span class="texto">' . $row["fec_dotacion"] . '</span>
                </td>
            </tr>

            <tr>
                <td colspan="1"><span class="etiqueta">Documento: </span>
                    <span class="texto">PAQUETE DE GENERACION POR ';
                    
                    
                    $mostrar.=($vista=="vista_dotacion")?'ALMACEN':'OPERACIONES';
                    $mostrar.='</span>
                </td>
            </tr>
            <tr>
                <td colspan="1"><span class="etiqueta">Observacion: </span>
                    <span class="texto">';
                    
                    
                    $mostrar.= strtoupper($row["obs"]);
                    $mostrar.='</span>
                </td>
            </tr>
        
    </table>
    <table width="80%" border="1" style="margin-left: auto;
    margin-right: auto;">
        
            <tr style="background-color: #4CAF50;">
                <td width="20%" style="text-align:center;"><span class="etiqueta" >Codigo Dotacion</span></td>
                <td width="20%" style="text-align:center;"><span class="etiqueta" >Ficha</span></td>
                <td width="60%" style="text-align:center;"><span class="etiqueta" >Trabajador</span></td>
            </tr>';
echo $mostrar;


$i = 0;
while ($producto = $bd->obtener_fila($query, 0)) {
    if ($i % 2 == 0) {
        echo "<tr>";
    } else {
        echo "
        <tr class='odd_row'>";
    }

    echo "<td width='20%' style='text-align:center;'> <span >" . $producto['codigo_dotacion'] . "</span></td>
          <td width='20%' style='text-align:center;'> <span >" . $producto['ficha'] . "</span></td>
          <td width='60%' style='text-align:center;'><span >" . $producto['trabajador'] . "</span></td>
        </tr>";
    ++$i;
}
echo '
            
        </table>
    </div>
    <br>
    <table>
        
            <tr>    
                <td style="text-align: center;font-size: 11px;">
                    ________________________________<br>
                    <span class="firma">Almacen:</span><br><br>
                    ________________________________<br>
                    <span class="firma">' . $leng["ci"] . '</span><br><br>
                    ________________________________<br>
                    <span class="firma">Firma</span>
                </td>
                <td style="text-align: center;font-size: 11px;">
                    ________________________________<br>
                    <span class="firma">Operaciones:</span><br><br>
                    ________________________________<br>
                    <span class="firma">' . $leng["ci"] . '</span><br><br>
                    ________________________________<br>
                    <span class="firma">Firma</span>
                </td>
            </tr>
        
    </table>
</div>

';
//$dompdf->load_html(ob_get_clean(), 'UTF-8');
//		$dompdf->set_paper ('letter','landscape');
//$dompdf->render();
//$dompdf->stream($archivo, array('Attachment' => 0));
