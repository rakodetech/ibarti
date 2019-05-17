<?php
define("SPECIALCONSTANT",true);
require "../../../../autentificacion/aut_config.inc.php";
require "../../../general/modelo/general_modelo.php";
include_once('../../../../funciones/funciones.php');
require_once "../../../../".class_bdI;
require_once "../../../../".Leng;
$bd = new DataBase();
$ubic         = $_POST['ubicacion'];
$apertura     = $_POST['apertura'];
$usuario      = $_POST['usuario'];
$proced       = "p_planif_servicio";
$reporte      = $_POST['reporte'];
$archivo      = "rp_planif_serv_".$fecha."";
$titulo       = "Reporte Servicio ".$leng['cliente']." \n";

if(isset($reporte)){

  $sql    = "$SELECT $proced('$apertura','$ubic', '$usuario')";
  $query  = $bd->consultar($sql);
  
  $gen   = new General;
  $cliente   = $gen->get_ubic_cl($ubic);

  $sql = "SELECT planif_cliente.fecha_inicio, planif_cliente.fecha_fin,
  DATE_FORMAT(planif_cliente.fecha_inicio,'%d') dia_inic,  DATE_FORMAT(planif_cliente.fecha_fin,'%d') dia_fin,
  CONCAT(ficha.apellidos,' ',ficha.nombres) ap_nombre, ficha.cedula,
  a.*
  FROM planif_servicio AS a, ficha, planif_cliente
  WHERE planif_cliente.codigo = '$apertura'
  AND planif_cliente.codigo = a.apertura
  AND a.tipo = 'serv'
  AND a.cod_ubicacion = '$ubic'
  AND a.cod_ficha = ficha.cod_ficha
  AND a.usuario = '$usuario'
  ORDER BY 2 DESC";

if($reporte== 'excel'){
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: filename=\"$archivo.xls\";");

    $query01  = $bd->consultar($sql);

    echo "<table border=0>
    <tr><th colspan='32'>$titulo</th></tr>
    <tr><th>".$leng['cliente'].":</th><th colspan='2'>".$cliente[0]['cliente']."</th>
    <th colspan='5'> ".$leng['ubicacion'].":</th><th colspan='14'>".$cliente[0]['ubicacion']."</th>
    <th colspan='4'>Fecha:</th><th colspan='6'>$date_time</th></tr>
    </table>
    <table border=1>
   <tr><th>".$leng['ficha']."</th><th> ".$leng['ci']." </th><th> ".$leng['trabajador']." </th>
   <th>01</th><th>02</th><th>03</th><th>04</th><th>05</th><th>06</th>
   <th>07</th><th>08</th><th>09</th><th>10</th><th>11</th><th>12</th>
   <th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th>
   <th>19</th><th>20</th><th>21</th> <th>22</th><th>23</th><th>24</th>
   <th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th></tr>";
   while ($row01 = $bd->obtener_fila($query01)){
     echo "<tr><td>".$row01['cod_ficha']." </td><td>".$row01['cedula']."</td><td>".$row01['ap_nombre']."</td>
     <td>".$row01['d01']."</td><td>".$row01['d02']."</td><td>".$row01['d03']."</td><td>".$row01['d04']."</td>
     <td>".$row01['d05']."</td><td>".$row01['d06']."</td><td>".$row01['d07']."</td><td>".$row01['d08']."</td>
     <td>".$row01['d09']."</td><td>".$row01['d10']."</td><td>".$row01['d11']."</td><td>".$row01['d12']."</td>
     <td>".$row01['d13']."</td><td>".$row01['d14']."</td><td>".$row01['d15']."</td><td>".$row01['d16']."</td>
     <td>".$row01['d17']."</td><td>".$row01['d18']."</td><td>".$row01['d19']."</td><td>".$row01['d20']."</td>
     <td>".$row01['d21']."</td><td>".$row01['d22']."</td><td>".$row01['d23']."</td><td>".$row01['d24']."</td>
     <td>".$row01['d25']."</td><td>".$row01['d26']."</td><td>".$row01['d27']."</td><td>".$row01['d28']."</td>
     <td>".$row01['d29']."</td><td>".$row01['d30']."</td> <td>".$row01['d31']."</td></tr>";
   }
   echo "</table>";
 }
}

?>
