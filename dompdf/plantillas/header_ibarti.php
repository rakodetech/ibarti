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
        <td rowspan="2">
            <img style="width: 140px;" src="../<?php echo LogoIbarti?>" >
        </td>

        <td id="titulo_header" rowspan="2"><b><?php echo $titulo;?>
        </b></td>

        <!-- Fecha y Hora alineada a la derecha en la cabecera -->
        <td class="cab"  style="text-align: right; font-size: 12px; text-transform: lowercase;">
            <?php 
            date_default_timezone_set('America/Caracas');
            echo date("d/m/Y, h:i:s a");?>
        </td>
    </tr>
    <tr>
        <!-- Ficha alineada a la derecha en al cabecera -->
        <td id="ficha_header" class="cab"><span>
        <?php 
        if(isset($_POST["ficha"])) {
        echo $ficha;
        }
        elseif(isset($_POST['cedula'])){
        echo $cedula;
        }
        ?></span></td>
    </tr>
  </tbody>
</table>
       </div>