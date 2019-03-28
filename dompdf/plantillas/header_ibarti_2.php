<!DOCTYPE html>
<html>
<head>
	<title>IBARTI</title>
	<link rel="stylesheet" type="text/css" href="../<?php echo cssDomPdf?>">
</head>
<body>
    <!-- Cabecera -->
    <div id="header">
  <table  style="padding:0;border-bottom: 1.5px solid #1B5E20;">
    <tbody>
    <tr>
        <!-- Logo de la empresa que esta en la cabecera-->
        <td width="25%">
            <img style="width: 140px;" src="../<?php echo LogoIbarti?>" >
        </td>
        <td width="50%" id="titulo_header" colspan="2"><span><?php echo $titulo;?></span>
        </td>
        <!-- Fecha y Hora alineada a la derecha en la cabecera -->
        <td width="25%" class="cab"  style="text-align: right; font-size: 12px; vertical-align: top; text-transform: lowercase;">
            <?php 
            date_default_timezone_set('America/Caracas');
            echo date("d/m/Y, h:i:s a");?>
        </td>
    </tr>
  </tbody>
</table>
       </div>