<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
	mysql_select_db($bd_cnn,$cnn);
$titulo = "oesvica";

$id           = $_POST['id'];
$fecha_D      = conversion($_POST['fecha_desde']);
//$fecha_H      = conversion($_POST['fecha_hasta']);

$contracto    = $_POST['contracto'];

$t_pantalon   = $_POST['t_pantalon'];
$c_pantalon   = $_POST['c_pantalon'];
$t_camisa     = $_POST['t_camisa'];
$c_camisa     = $_POST['c_camisa'];
$n_zapato     = $_POST['n_zapato'];
$c_zapato     = $_POST['c_zapato'];

$trabajador   = $_POST['trabajador'];
$reporte      = $_POST['reporte'];
$usuario      = $_POST['usuario'];

$titulo       = " REPORTES DOTACION DE UNIFORMES ";
//   Leer un directorio con php   //


if(isset($reporte)){

		mysql_query("UPDATE ficha_uniforme SET t_pantalon    = '$t_pantalon', c_pantalon  = '$c_pantalon',
		                                       t_camisa      = '$t_camisa' ,  c_camisa    = '$c_camisa',
                                               n_zapato      = '$n_zapato',   c_zapato    = '$c_zapato',
                                               fec_dotacion  = '$fecha_D'
 		              WHERE ficha_uniforme.id_ci = '$trabajador'", $cnn)or die
								 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');

	      $where = " WHERE ficha.departamento = regiones.id
					   AND bot.codigo = '$n_zapato'
					   AND ca.codigo  = '$t_camisa'
					   AND pa.codigo  = '$t_pantalon'
					   AND ficha.ci = '$trabajador' ";

     	  $sql01 = "SELECT ficha.cod_emp, ficha.nombres,
                           regiones.descripcion AS Region, bot.codigo AS cod_botas,
                           bot.descripcion AS botas , bot.factor AS bot_cantidad,
                           ca.codigo AS cod_camisa, ca.descripcion AS camisa,
						   ca.factor AS ca_cantidad, pa.codigo AS cod_pantalon,
                           pa.descripcion AS pantalon, pa.factor AS pa_cantidad
                      FROM ficha,  regiones , productos AS bot , productos AS ca ,
                           productos AS pa
                     " .$where. " ORDER BY 1 ASC ";

	if($reporte  == 'excel'){

 /*		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition:  filename=\"dotacion_uniformes.xls\";");
	*/
		$fondo01 = " ";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);
		  $row01 = mysql_fetch_array($query01);
		//  $row01 = mysql_fetch_row($query01);


		 echo "<table border=1 width='720px'>";
		 echo "<TR><TH><img src='../imagenes/oesvica.png' width='160PX' height='100PX'></TH><TH colspan='3'>".Empresa." </TH></TR>
		       <TR><TH>RIF.:</TH><TH>".RIF."</TH><TH>FECHA DE EMISION</TH><TH>".conversion($date)."</TH></TR>
			   <TR><TH colspan='4'>DOTACION DE UNIFORMES </TH></TR>
			   <tr><td> N. Ficha.:</td><td>".$row01['cod_emp']."</td><td colspan='2'>&nbsp;</td></tr>
			   <tr><td> Trabajador.:</td><td>".$row01['nombres']."</td><td colspan='2'>&nbsp;</td></tr>
			   <tr><td> Departamento.:</td><td>".$row01['Region']."</td><td >Fecha Dotacion</td><td>".$_POST['fecha_desde']."</td></tr>
			   <TR><TH>Nro</TH><TH>Codigo</TH><TH>Descripcion</TH><TH>Cantidad</TH></TR>
			   <tr><td>1</td><td>".$row01['cod_botas']."</td><td>".$row01['botas']."</td><td>".$c_zapato."</td></tr>
			   <tr><td>2</td><td>".$row01['cod_camisa']."</td><td>".$row01['camisa']."</td><td>".$c_camisa."</td></tr>
			   <tr><td>3</td><td>".$row01['cod_pantalon']."</td><td>".$row01['pantalon']."</td><td>".$c_pantalon."</td></tr>
			    <tr><td colspan='4' height='200px' >&nbsp;</td></tr>";

		 echo "</table>";

		  echo '<table border=1 width="720px" align="left">
		        <TR><TH><br>Revisado Por:<br />Firma:<br /> CI:<br /></TH><TH><br>Recibido Por:<br />Firma:<br /> CI:<br /></TH>
				    <TH><br />Verificador Por:<br />Firma:<br /> CI:<br /></TH></TR>
		       </table>';
       /*
		while($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".utf8_decode($row01[0])." </td><td".$fondo01.">".utf8_decode($row01[1])."</td>
		           <td".$fondo01.">".utf8_decode($row01[2])."</td><td".$fondo01.">".utf8_decode($row01[3])."</td>
				   <td".$fondo01.">".utf8_decode($row01[4])."</td><td".$fondo01.">".utf8_decode($row01[5])."</td>

			  </tr>";
			}
			*/
		 echo "</table>";
		}
		/*
	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	// $attr = array('titleFontSize'=>12, 'titleText'=>$titulo);
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}	*/
}
?>
<script language="javascript" type="text/javascript">
window.print();
</script>
