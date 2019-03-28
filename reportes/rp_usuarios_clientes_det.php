<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
require_once("../autentificacion/aut_config.inc.php");
include_once('../funciones/funciones.php');
//mysql_select_db($bd_cnn, $cnn);
$id           = $_POST['id'];


$reporte      = $_POST['reporte'];
$clientes     = $_POST['clientes'];
$region       = $_POST['regiones'];

$usuario_id  = $_POST['usuario_id'];
$perfil      = $_POST['perfil'];
if(isset($reporte)){


	$where =" WHERE usuario_cliente.tipo = 'C'
                AND usuario_cliente.codigo = clientes_ubicacion.id
                AND clientes_ubicacion.co_cli = clientes.co_cli
                AND clientes_ubicacion.id_region = regiones.id
                AND usuario_cliente.id_usuario = usuarios.cedula ";

	if($usuario_id != "TODOS"){
			$where .= " AND usuario_cliente.id_usuario = '$usuario_id' ";
		}
	if($clientes != "TODOS"){
			$where .= " AND clientes.co_cli = '$clientes' ";
		}
	if($region != "TODOS"){
			$where .=  " AND regiones.id = '$region' ";
		}


	  $sql01 = "SELECT usuario_cliente.id_usuario, CONCAT( usuarios.apellido, ' ', usuarios.nombre) AS Usuario, clientes.co_cli AS Cod_Cliente,
                       clientes.cli_des AS Cliente, clientes_ubicacion.descripcion AS Ubicacion, regiones.descripcion AS Region
                  FROM usuario_cliente , clientes_ubicacion, clientes , regiones , oesvica_sistema.usuarios " .$where." ORDER BY 1, 2";

	if($reporte== 'excel'){

		mysql_select_db($bd_cnn,$cnn);
		header("Content-type: application/vnd.ms-excel");
		 header("Content-Disposition:  filename=\"usuario_asig_cliente.xls\";");

		$fondo01 = " bgcolor='#EBEBEB'";
		$fondo02 = " bgcolor='#E0E0E0'";
		  $query01 = mysql_query($sql01, $cnn);

		 echo "<table border=1>";
		 echo "<tr><th>COD  USUARIO </th><th> USUARIO </th><th>COD CLIENTE </th><th> CLIENTE </th><th>UBICACION</th> <th>REGION</th></tr>";
		while ($row01 = mysql_fetch_row($query01)){
		 echo "<tr><td ".$fondo01."> ".$row01[0]." </td><td".$fondo01.">".$row01[1]."</td><td".$fondo01.">".$row01[2]."</td><td".$fondo01.">".utf8_decode($row01[3])."</td><td".$fondo01.">".$row01[4]."</td><td".$fondo01.">".$row01[5]."</td></tr>";
		}
		 echo "</table>";
	}

	if($reporte== 'pdf'){
	require('../fpdf/mysql_report.php');

	$pdf = new PDF('L','pt','letter');
	$pdf->SetFont('Arial','',10);
	$pdf->connect($conf_host,$conf_usuario,$conf_pass,$bd_cnn);
	$attr = array('titleFontSize'=>12, 'titleText'=>'REPORTES DE RESUMEN ASISTENCIA POR CLIENTE ');
	$pdf->mysql_report($sql01, false,$attr);
	$pdf->Output();
	}
}
?>
