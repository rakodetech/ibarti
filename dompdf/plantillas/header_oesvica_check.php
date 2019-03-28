<!DOCTYPE html>
<html>
<head>
	<title>IBARTI</title>
	
</head>
<body>
    <!-- Cabecera -->
    <div id="header" style="border-bottom: none !important;">
    <link rel="stylesheet" type="text/css" href="../<?php echo cssDomPdf?>">
  <table >
    <tbody>
    <tr>
        <!-- Logo de la empresa que esta en la cabecera-->
        <td width="25%">
            <img style="width: 300px;" src="../<?php echo LogoCliente?>" >
        </td>
        <td></td>
        <!-- Fecha y Hora alineada a la derecha en la cabecera -->
        <td width="25%" class="cab"  style="text-align: right; font-size: 12px; vertical-align: top;">
            <table width="100%" border="1px" align="right">
            <tr><td align="center"><?php echo $codigo?></td></tr>
            <tr><td align="center"><?php echo $tomo?></td></tr>
            </table>
        </td>
        </tr>
        

  </tbody>
</table>
       </div>