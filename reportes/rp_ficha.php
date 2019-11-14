<?php
    define("SPECIALCONSTANT", true);
    require "../autentificacion/aut_config.inc.php" ;
    require "../".class_bdI;
    require "../".Leng;
    include "../".Funcion;
    $bd = new DataBase();
    //incluye la configuracion por defecto de la libreria dompdf
    require_once('../'.ConfigDomPdf);

//Variable con que se ancla a la base de datos
//$ficha='2435';

$ficha=$_POST['codigo'];

ini_set("memory_limit", "128M");

$sql = "SELECT Fic.cod_ficha,  Fic.cedula, Fic.carnet, Fic.fec_carnet,
CONCAT(Fic.nombres,' ', Fic.apellidos) AS nombres, Fic.fec_nacimiento, Fic.lugar_nac,
Sexo(Fic.sexo) sexo, Fic.telefono, Fic.celular, Fic.direccion,
Fic.correo, Fic.experiencia, Fic.cargo, Fic.estado,
Fic.ciudad, Fic.observacion, Fic.fec_carnet, Fic.fec_ingreso,
Fic.fec_profit, Fic.cta_banco, Fic.fec_contracto, Fic.fec_us_ing,
Fic.fec_us_mod, Fic.region, Fic.status, Fic.rol AS agrupacion,
Fic.contracto AS contrato, Ubi.descripcion AS ubicacion,
Nac.descripcion AS nacionalidad, Cli.abrev AS empresa,
Ocu.descripcion AS ocupacion, Est_Civ.descripcion AS estado_civil,
Niv_Aca.descripcion AS nivel_academico, Num_Con.descripcion AS numero_de_contratos,
Ban.descripcion AS banco, CONCAT(Usu.nombre,' ',Usu.apellido) AS nom_usu_ing,
(SELECT CONCAT(men_usuarios.apellido,' ',men_usuarios.nombre) FROM men_usuarios
WHERE  men_usuarios.codigo = Fic.cod_us_mod) nom_usu_mod,
Tur.descripcion AS turno
FROM v_ficha AS Fic
INNER JOIN nacionalidad AS Nac ON Fic.cod_nacionalidad = Nac.codigo
INNER JOIN ocupacion AS Ocu ON Fic.cod_ocupacion= Ocu.codigo
INNER JOIN estado_civil AS Est_Civ ON Fic.cod_estado_civil= Est_Civ.codigo
INNER JOIN clientes_ubicacion AS Ubi ON Fic.cod_ubicacion = Ubi.codigo
INNER JOIN clientes AS Cli ON Fic.cod_cliente = Cli.codigo
INNER JOIN nivel_academico AS Niv_Aca ON Fic.cod_nivel_academico= Niv_Aca.codigo
INNER JOIN ficha_n_contracto AS Num_Con ON Fic.cod_n_contracto = Num_Con.codigo
INNER JOIN bancos AS Ban ON Fic.cod_banco = Ban.codigo
INNER JOIN men_usuarios AS Usu ON Fic.cod_us_ing =Usu.codigo
INNER JOIN turno AS Tur ON Fic.cod_turno = Tur.codigo
WHERE Fic.cod_ficha='$ficha' ";

    $query = $bd->consultar($sql);

    if(!$trabajador = $bd->obtener_name($query)){
    echo "<h1>Lo sentimos. No se pudo encontrar una coincidencia para esta ficha. Inténtelo de nuevo.</h1>";
    exit;
    };

    $cedula = $trabajador['cedula'];

//Ahora consulto los datos de las cargar familiares
$sqlf="SELECT ficha_familia.codigo, parentescos.descripcion AS parentesco,
              ficha_familia.nombres, ficha_familia.fec_nac,
              ficha_familia.sexo
         FROM ficha_familia, parentescos
        WHERE ficha_familia.cod_ficha = '$ficha'
          AND ficha_familia.cod_parentesco=parentescos.codigo";

$queryf = $bd->consultar($sqlf);

$sqld = "SELECT prod_dotacion.fec_dotacion, prod_dotacion_det.cantidad,
                prod_lineas.descripcion linea, prod_sub_lineas.descripcion sub_linea,
                prod_dotacion_det.cod_dotacion, productos.descripcion
           FROM prod_dotacion
     INNER JOIN prod_dotacion_det ON prod_dotacion.codigo = prod_dotacion_det.cod_dotacion
     INNER JOIN productos ON prod_dotacion_det.cod_producto = productos.codigo
     INNER JOIN prod_lineas ON prod_dotacion_det.cod_linea = prod_lineas.codigo
     INNER JOIN prod_sub_lineas ON prod_dotacion_det.cod_sub_linea = prod_sub_lineas.codigo
          WHERE prod_dotacion.cod_ficha = '$ficha'
      ORDER BY prod_dotacion.fec_dotacion DESC";

$queryd = $bd->consultar($sqld);
$dompdf= new DOMPDF();

ob_start();
$titulo= 'REPORTE FICHA TRABAJADOR';

require('../'.PlantillaDOM.'/unicas/ficha_ibarti.php');

    $dompdf->load_html(ob_get_clean(),'UTF-8');
    $dompdf->render();
    $pdf=$dompdf->output();
    $dompdf->stream('ficha_ibarti.pdf', array('Attachment' => 0));
    ?>
