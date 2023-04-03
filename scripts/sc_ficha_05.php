<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();
$tabla    = 'ficha';

$codigo          = $_POST['codigo'];
$fec_egreso      = conversion($_POST['fec_egreso']);
$motivo          = $_POST['motivo'];
$color          = $_POST['color'];
$preaviso        = $_POST['preaviso'];
$p_fec_inicio    = conversion($_POST['p_fec_inicio']);
$p_fec_culminacion = conversion($_POST['p_fec_culminacion']);
$d_p_laboral     = $_POST['d_p_laboral'];
$d_p_cumplido    = $_POST['d_p_cumplido'];
$calculo         = $_POST['calculo'];
$calculo_status  = $_POST['calculo_status'];

$fec_calculo     = conversion($_POST['fec_calculo']);
$fec_posible_pago = conversion($_POST['fec_posible_pago']);
$fec_pago        = conversion($_POST['fec_pago']);
$cheque          = $_POST['cheque'];
$banco           = $_POST['banco'];
$importe         = $_POST['importe'];
$entrega_uniforme = $_POST['entrega_uniforme'];
$observacion     = htmlspecialchars($_POST['observacion']);
$observacion2    = htmlspecialchars($_POST['observacion2']);
$status          = $_POST['status'];
$cod_motivo_egreso          = $_POST['cod_motivo_egreso'];

if ($p_fec_inicio == '') {
	$p_fec_inicio = '0000-00-00';
}
if ($p_fec_culminacion == '') {
	$p_fec_culminacion = '0000-00-00';
}
if ($d_p_laboral == '') {
	$d_p_laboral = '0';
}
if ($d_p_cumplido == '') {
	$d_p_cumplido = '0';
}
if ($importe == '') {
	$importe = '0';
}
if ($fec_calculo == 'AAAA-MM-DD') {
	$fec_calculo = '0000-00-00';
}
if ($fec_posible_pago == 'AAAA-MM-DD') {
	$fec_posible_pago = '0000-00-00';
}
if ($fec_pago == 'AAAA-MM-DD') {
	$fec_pago = '0000-00-00';
}


$href     = $_POST['href'];
$usuario  = $_POST['usuario'];
$proced   = $_POST['proced'];
$metodo   = $_POST['metodo'];

if (isset($_POST['proced'])) {

$sql = "SELECT cod_ficha,fec_egreso from ficha_egreso WHERE ficha_egreso.cod_ficha = '$codigo'
AND ficha_egreso.fec_egreso='$fec_egreso'";
$query = $bd->consultar($sql);
$row = $bd->num_fila($query);
if ($row > 0 )  {
	$sqlegreso = "SELECT cod_ficha,cod_ficha_status from ficha ,control             
        WHERE ficha.cod_ficha = '$codigo'
        AND ficha.cod_ficha_status = control.ficha_activo";
	$query1 = $bd->consultar($sqlegreso);
	$row1 = $bd->num_fila($query1);
	
    if ($row1 > 0)  {
		$sql    = "$SELECT $proced('$metodo', '$codigo', '$fec_egreso', '$motivo',
                            '$color', '$preaviso','$p_fec_inicio','$p_fec_culminacion',
							'$d_p_laboral', '$d_p_cumplido','$calculo', '$calculo_status',
							'$fec_calculo', '$fec_posible_pago', '$fec_pago', '$cheque',
							'$banco','$importe','$entrega_uniforme', '$observacion',
							'$observacion2', '$usuario', '$status', '$cod_motivo_egreso')";
			$query = $bd->consultar($sql);
	} else {
				//obtener el codigo del status de la ficha
				$campo_id="blanco";
				$sql1 = "SELECT ficha.cod_ficha_status
				FROM ficha
	   			WHERE  ficha.cod_ficha='$codigo'";						  
				$query1 = $bd->consultar($sql1);	 
				$n = 0;
                $fila= $bd->obtener_fila($query1,0);
                
				$sql = "SELECT ficha_status.codigo
				FROM ficha_status
	   			WHERE  ficha_status.codigo <> '' ORDER BY codigo asc";						  
				$query = $bd->consultar($sql);	 
				$n = 1;
				$bloquear=-1;
                $filax= $bd->num_fila($query);
				
				$posicion=-1;
				while(($datos=$bd->obtener_fila($query,0)) && $posicion == -1) {
					$campo_id = $datos["codigo"];	
						if ( $campo_id == $fila[0]){
                            $posicion =$n;
						} else {
							$n++;
						}
						
				}
				switch ($posicion) {
					case 1:
						$bloquear=0;
						break;
					case 2:
						$bloquear=0;
						break;
					case 3:
						$bloquear=1;
						break;
					case 4:
						$bloquear=0;
						break;	
				}
		    		
		  // calcular la posicion del estatu  que tiene la ficha para ver si desactiva ficha
          // 1 activo no desactiva 
		  // 2 Inactivo no desactiva ficha sino nomina
		  // 3 Por liquidar desactiva ficha y nomina pero puede pasar a liquidado
		  // 4 liquidado desactiva ficha y nomina , no pasa a los inferiores
		    if ($bloquear == 1) {
					$mensaje = "Error , el trabajador ya esta egresado... verificar con administraccion";
					echo '<script language="javascript">
					alert("'.$mensaje.'");
						</script>';
			} else {
				$mensaje = "Esta seguro de actualizar , el egreso del trabajador ..";
					echo '<script language="javascript">
					alert("'.$mensaje.'");
						</script>';
				$sql  = "$SELECT $proced('$metodo', '$codigo', '$fec_egreso', '$motivo',
				'$color', '$preaviso','$p_fec_inicio','$p_fec_culminacion',
				'$d_p_laboral', '$d_p_cumplido','$calculo', '$calculo_status',
				'$fec_calculo', '$fec_posible_pago', '$fec_pago', '$cheque',
				'$banco','$importe','$entrega_uniforme', '$observacion',
				'$observacion2', '$usuario', '$status', '$cod_motivo_egreso')";
				$query = $bd->consultar($sql);
			
				

			}			
	}

} else {
			
	
	      $mensaje = "Esta seguro de registrar el egreso del trabajador";
			echo '<script language="javascript">
			 var valor = confirm("'.$mensaje.'");
			</script>';
			$opcion= '<script>document.write(valor) </script>';
			if ($opcion) {
				
				$sql  = "$SELECT $proced('$metodo', '$codigo', '$fec_egreso', '$motivo',
				'$color', '$preaviso','$p_fec_inicio','$p_fec_culminacion',
				'$d_p_laboral', '$d_p_cumplido','$calculo', '$calculo_status',
				'$fec_calculo', '$fec_posible_pago', '$fec_pago', '$cheque',
				'$banco','$importe','$entrega_uniforme', '$observacion',
				'$observacion2', '$usuario', '$status', '$cod_motivo_egreso')";
				$query = $bd->consultar($sql);
			} else {
				echo '<script language="javascript">
					alert("'.$opcion.'");
						</script>';
			}
				
			
		
		
}

}
require_once('../funciones/sc_direccionar.php');
