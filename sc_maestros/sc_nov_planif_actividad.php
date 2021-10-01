<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require_once("../" . class_bd);
$bd = new DataBase();

$tabla    = 'nov_perfiles';

$href          = $_POST['href'];
$proyecto       =  $_POST['proyecto'];
$actividad     =  $_POST['actividad'];
$nov_clasif    =  $_POST['nov_clasif'];
$nov_tipo      =  $_POST['nov_tipo'];
$novedad       =  $_POST['novedad'];

$usuario  = $_POST['usuario'];

$where = " WHERE novedades.cod_nov_clasif = '$nov_clasif' AND novedades.cod_nov_tipo = '$nov_tipo'";

$sql   = "SELECT novedades.codigo FROM novedades $where ";
$query = $bd->consultar($sql);

$metodo   = $_POST['metodo'];

if (isset($_POST['metodo'])) {
	$i = $_POST['metodo'];
	switch ($i) {

		case 'actualizar':

			while ($row03 = $bd->obtener_fila($query, 0)) {
				$codigo = $row03[0];

				$sql02 = " DELETE FROM nov_planif_actividad WHERE nov_planif_actividad.cod_actividad = $actividad
                                              AND nov_planif_actividad.cod_novedad = '$codigo' ";
				$query02 = $bd->consultar($sql02);
			}

			foreach ($novedad as $valorX) {

				$sqlX = "INSERT INTO nov_planif_actividad (cod_actividad, cod_novedad, fecha, usuario )			
	                          	      	   VALUES ($actividad, '$valorX', '$date_time', '$usuario')";

				$queryX = $bd->consultar($sqlX);
			}
			break;
	}
}
require_once('../funciones/sc_direccionar.php');
