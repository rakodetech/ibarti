<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php
//session_start(); 
$Nmenu   = 560;
$metodo         = $_GET['metodo'];
require("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');

//require_once("autentificacion/aut_config.inc.php");
//include_once('funciones/funciones.php');
// require_once('autentificacion/aut_verifica_menu_02.php');

//require_once("".class_bd);
require_once("../".class_bd);
$bd = new DataBase(); 

$codigo         = $_GET['codigo'];
$archivo         = "rp_nov_check_list_printer.php"; 
$titulo          = " PLANILLA DE CHECK LIST "; 	

$logo = "../imagenes/logo.jpg";
if(isset($metodo)){	

  if (file_exists($logo)) {
	 $logo_img =  '<img src="'.$logo.'" />';
	} else {
	 $logo_img  =  '<img src="../imagenes/img_no_disp.jpg"/>';
	}
				 
	// QUERY A MOSTRAR //
  	$sql = "SELECT nov_check_list.fecha,  nov_check_list.fec_us_ing AS fec_sistema,
	  	                  nov_clasif.descripcion AS nov_clasif,   
		                  clientes.nombre AS cliente, clientes_ubicacion.descripcion AS ubicacion,
		                  nov_check_list.cod_ficha, preingreso.cedula,
						  nov_check_list.repuesta, nov_check_list.fec_us_mod,  
						  CONCAT(men_usuarios.apellido,' ',men_usuarios.nombre) AS us_mod,
						  CONCAT(preingreso.apellidos, ' ', preingreso.nombres) AS trabajador, nov_status.descripcion AS nov_status  ,
                          control.cl_rif,  control.cl_campo_04_desc,
						  clientes_ubicacion.contacto, clientes_ubicacion.campo04                  
                      FROM nov_check_list LEFT JOIN men_usuarios ON nov_check_list.cod_us_mod = men_usuarios.codigo ,
			              nov_clasif , clientes , clientes_ubicacion , ficha ,
					      preingreso , nov_status, control
					WHERE nov_check_list.codigo = '$codigo'
                      AND nov_check_list.cod_nov_clasif = nov_clasif.codigo 
                      AND nov_check_list.cod_cliente = clientes.codigo
                      AND nov_check_list.cod_ubicacion = clientes_ubicacion.codigo 
                      AND nov_check_list.cod_ficha = ficha.cod_ficha 
                      AND ficha.cedula = preingreso.cedula 
                      AND nov_check_list.cod_nov_status = nov_status.codigo             	
                 ORDER BY 2 DESC ";
			  
		$query01 = $bd->consultar($sql);		
		$row01   = $bd->obtener_fila($query01,0);

	if($metodo== 'printer'){ 
	
		 echo "<table border=1 width='720px'>";
		 echo "<TR><TH colspan='2'>$titulo </TH></TR>
	         	  <TR><TH width='60%'>".$logo_img."</TH>
				  <TH width='40'>RIF: ".$row01['cl_rif']."<br />".conversion($date)."</TH></TR>			
			      <tr><td>Fecha De Ingreso: ".$row01['fecha']."</td><td>Fecha De Sistema: ".$row01['fec_sistema']."</td></tr>
			   <tr><td>Supervisor: ".$row01['trabajador']."</td> <td>Fecha Ult. Modificacion: ".$row01['fec_us_mod']."</td></tr>
			  <tr><td> Cliente: ".$row01['cliente']."</td> <td>Ubicacion: ".$row01['ubicacion']." </td></tr>			
			   <tr><td> Contacto: ".$row01['contacto']."</td> <td>".$row01['cl_campo_04_desc'].": ".$row01['campo04']."</td></tr>
   			   <tr><td colspan='2'> Respuesta: ".$row01['repuesta']."</td></tr>
				<tr><td> Clasificacion: ".$row01['nov_clasif']."</td> <td>Status: ".$row01['nov_status']."</td></tr>
			   <tr><td colspan='2'>DETALLE</td></tr>
			   <tr><td colspan='2'>";
			   
			   	   $sql   = "  SELECT nov_check_list_det.cod_check_list,
                           nov_check_list_det.cod_novedades, novedades.descripcion AS novedad, 
                           nov_check_list_det.valor, nov_check_list_det.observacion
                      FROM nov_check_list_det , novedades
                     WHERE nov_check_list_det.cod_check_list = '$codigo' 
                       AND nov_check_list_det.cod_novedades = novedades.codigo ";

		$query = $bd->consultar($sql);   
		
		echo '<table border=0 width="100%">
		<tr>
     <td class="etiqueta" width="48%">Check List:</td>
     <td class="etiqueta" width="12%">Valor:</td>
     <td class="etiqueta" width="40%">Observacion:</td>
   </tr>
		';
	while($datos = $bd->obtener_fila($query,0)){	 
		$cod_nov = $datos[1];
 		echo '<tr>
      <td>'.$datos[2].'></td>
	  <td>SI <input type = "radio" name="check_list_valor_'.$cod_nov.'"  value = "T"  style="width:auto" '.CheckX($datos[3], "T").' /> NO<input type = "radio" name="check_list_valor_'.$cod_nov.'"  value = "F" style="width:auto" '.CheckX($datos[3], 'F').' /></td>
      <td>'.$datos[4].'</td>
    </tr>';	
	}    
			  echo"</table>
			   </td></tr>		
			   <tr><td colspan='2' height='80px' >&nbsp; 		 
		           <table border=0 width='720px' align='left'>
		                  <TR><TH width='15%'>&nbsp;</TH>
						  <TH width='20%'><br>Entregado Por:<br />Firma:<br /> CI:<br /></TH>
						  <TH width='20%'>&nbsp;</TH>
			              <TH width='20%'><br>Recibido Por:<br />Firma:<br /> CI:<br /></TH>
						  <TH width='25%'>&nbsp;</TH>
						  </TR>
				          </td></tr></table>						  			   		  
		       </table>";
echo '<script language="javascript" type="text/javascript">
window.print();
</script>';
	}
}	
?>
<body>
</body>
</html>