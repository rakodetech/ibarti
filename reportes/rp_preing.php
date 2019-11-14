<?php
    define("SPECIALCONSTANT", true);
    require "../autentificacion/aut_config.inc.php" ;
    require "../".class_bdI;
    require "../".Leng;
    require "../".Funcion;
    //incluye la configuracion por defecto de la libreria dompdf
    require "../".ConfigDomPdf;
    $bd = new DataBase();

$cedula=$_POST['codigo'];
//$cedula='17032878';

ini_set("memory_limit", "128M");

 $sql = "SELECT v_preingreso.cedula, v_preingreso.nacionalidad,
                v_preingreso.estado_civil, v_preingreso.apellidos,
                v_preingreso.nombres, v_preingreso.fec_nacimiento,
                v_preingreso.lugar_nac, v_preingreso.telefono,
                v_preingreso.celular, Sexo(v_preingreso.sexo) sexo,
                v_preingreso.experiencia, v_preingreso.ocupacion,
                v_preingreso.correo, v_preingreso.direccion,
                v_preingreso.ciudad, v_preingreso.estado,
                v_preingreso.nivel_academico, v_preingreso.cargo,
                v_preingreso.observacion, v_preingreso.fec_preingreso,
                v_preingreso.`status`, v_preingreso.fec_us_ing,
                v_preingreso.fec_us_mod, CONCAT(men_usuarios.apellido,' ',men_usuarios.nombre) nom_usu_ing,
(SELECT CONCAT(men_usuarios.apellido,' ',men_usuarios.nombre) FROM men_usuarios
WHERE  men_usuarios.codigo = v_preingreso.cod_us_mod) nom_usu_mod,
v_preingreso.fec_psic, v_preingreso.psic_observacion,
Valores(v_preingreso.psic_apto) psic_apto, v_preingreso.fec_pol,
Valores(v_preingreso.pol_apto) pol_apto, v_preingreso.pol_observacion,
v_preingreso.refp01_nombre, v_preingreso.refp01_telf,
v_preingreso.refp01_parentezco, v_preingreso.refp01_observacion,
Valores(v_preingreso.refp01_apto) refp01_apto , v_preingreso.refp02_nombre,
v_preingreso.refp02_telf, v_preingreso.refp02_parentezco,
v_preingreso.refp02_observacion, Valores(v_preingreso.refp02_apto) refp02_apto,
v_preingreso.refp03_nombre, v_preingreso.refp03_telef,
v_preingreso.refp03_parentezco, v_preingreso.refp03_observacion,
Valores(v_preingreso.refp03_apto) refp03_apto , v_preingreso.refl01_empresa,
v_preingreso.refl01_telf, v_preingreso.refl01_contacto,
v_preingreso.refl01_observacion, Valores(v_preingreso.refl01_apto) refl01_apto,
v_preingreso.refl02_empresa, v_preingreso.refl02_telf,
v_preingreso.refl02_contacto, v_preingreso.refl02_observacion,
Valores(v_preingreso.refl02_apto) refl02_apto, preingreso.refp01_ocupacion,
preingreso.refp01_direccion, preingreso.refp02_ocupacion,
preingreso.refp02_direccion, preingreso.refp03_ocupacion,
preingreso.refp03_direccion, preingreso.refl01_direccion,
preingreso.refl02_direccion, preingreso.refl01_cargo,
preingreso.refl01_sueldo_inic, preingreso.refl01_sueldo_fin,
preingreso.refl01_fec_egreso, preingreso.refl01_retiro,
preingreso.refl02_cargo, preingreso.refl02_sueldo_inic,
preingreso.refl02_sueldo_fin, preingreso.refl02_fec_ingreso,
preingreso.refl02_fec_egreso, preingreso.refl02_retiro,
preingreso.refl01_fec_ingreso
FROM v_preingreso
INNER JOIN men_usuarios ON men_usuarios.cod_us_ing = men_usuarios.codigo
INNER JOIN preingreso ON v_preingreso.cedula = preingreso.cedula
WHERE v_preingreso.cedula = '$cedula'";

    $query = $bd->consultar($sql);

    if(!$trabajador = $bd->obtener_name($query)){
    echo "<h1>Lo sentimos. No se pudo encontrar una coincidencia para esta ficha. Inténtelo de nuevo.</h1>";
    exit;
    };

    $dompdf= new DOMPDF();

    ob_start();

    $titulo= 'REPORTE PREINGRESO TRABAJADOR';

    require('../'.PlantillaDOM.'/unicas/preingreso_ibarti.php');

	$dompdf->load_html(ob_get_clean(),'UTF-8');
	$dompdf->render();
	$pdf=$dompdf->output();
	$dompdf->stream('preingreso.pdf', array('Attachment' => 0));
  ?>
