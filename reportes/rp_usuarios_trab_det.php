<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
//mysql_select_db($bd_cnn, $cnn);
$id           = $_POST['id'];

$region       = $_POST['regiones'];
$reporte      = $_POST['reporte'];
$trabajador   = $_POST['trabajador'];


$usuario_id  = $_POST['usuario_id'];
$perfil      = $_POST['perfil'];
$titulo      = ' REPORTES DE ASIGNACION DE TRABAJADORES POR USUARIOS ';
if(isset($reporte)){

/*
SELECT usuario_cliente.id_usuario, usuarios.nombre, usuarios.apellido, trabajadores.cod_emp,
trabajadores.ci, trabajadores.nombres, trabajadores.id_region,
regiones.descripcion
FROM usuario_cliente , usuarios , trabajadores , regiones
WHERE usuario_cliente.id_usuario =  usuarios.cedula
 AND usuario_cliente.codigo =  trabajadores.cod_emp
 AND trabajadores.id_region =  regiones.id
 AND usuario_cliente.tipo =  'T'
 ORDER BY usuarios.nombre, regiones.descripcion , trabajadores.nombres ASC
*/

	$where =" WHERE usuario_cliente.id_usuario =  usuarios.cedula
	            AND usuario_cliente.codigo =  trabajadores.cod_emp
                AND trabajadores.id_region =  regiones.id
				AND usuario_cliente.tipo =  'T'
				AND trabajadores.co_cont = nomina.co_cont ";

	if($usuario_id != "TODOS"){
		$where  .= " AND usuario_cliente.id_usuario = '$usuario_id' ";
		}

	if($trabajador != NULL){
		$where  .= " AND trabajadores.cod_emp = '$trabajador' ";
	}
	if($region != "TODOS"){
		$where  .= " AND trabajadores.id_region = '$region' ";
	}

	  $orden = " ORDER BY usuarios.nombre, regiones.descripcion , trabajadores.nombres ASC ";

	  $sql01 = "SELECT CONCAT(usuarios.nombre,' ', usuarios.apellido) AS Usuario, trabajadores.cod_emp,
						trabajadores.ci AS Cedula, trabajadores.nombres AS Nombres, regiones.descripcion AS Region,
						nomina.des_cont AS Nomina
				   FROM oesvica_oesvica.usuario_cliente , oesvica_sistema.usuarios , oesvica_oesvica.trabajadores ,
				        oesvica_oesvica.regiones, oesvica_oesvica.nomina ".$where;

	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"usuario_asig_trabajador.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";
		 echo "<tr><th> USUARIO </th><th> COD. EMPLEADO </th><th> CEDULA </th><th> NOMBRES</th><th> REGION</th><th> NOMINA </th></tr>";
		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td><td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".utf8_decode($row01[3])."</td><td".$fondo01.">".$row01[4]."</td></tr>";
		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>$titulo);
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
}
?>
