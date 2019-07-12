<?php
$reporte      = $_POST['reporte'];
$archivo = $_POST['archivo_r'];


if(isset($reporte)){
    
    echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: filename=\"$archivo.xls\";");

    echo "<table border=1>";
    echo $reporte;
    echo "</table>";

  
}

?>
