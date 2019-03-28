<!DOCTYPE html>
<html>
<head>
	<title>IBARTI</title>
	<link rel="stylesheet" type="text/css" href="dompdf/style_planif.css">
</head>
<body>
    <!-- Cabecera -->
    <div id="header">
      <table  style="padding:0;border-bottom: 1.5px solid #1B5E20;">
        <tbody>
            <tr>
                <td width="100%" id="titulo_header" colspan="2"><span><?php echo $titulo;?></span>
                </td>
                <!-- Fecha y Hora alineada a la derecha en la cabecera -->
                <td width="100%" class="cab"  style="text-align: right; font-size: 12px; vertical-align: top; text-transform: lowercase;">
                    <?php 
                    date_default_timezone_set('America/Caracas');
                    echo date("d/m/Y, h:i:s a");?>
                </td>
            </tr>
        </tbody>
    </table>
</div>