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


$cliente=$_POST['codigo'];

ini_set("memory_limit", "128M");

$sql = " SELECT clientes.codigo,
clientes.cod_cl_tipo, clientes_tipos.descripcion cl_tipo,
clientes.cod_vendedor, vendedores.nombre  vendedor,
              clientes.cod_region, regiones.descripcion region,
            clientes.abrev, clientes.rif,
clientes.nit, clientes.nombre, clientes.telefono,
clientes.fax, clientes.direccion, clientes.dir_entrega,
clientes.email, clientes.website, clientes.contacto,
clientes.observacion,
clientes.juridico, clientes.contribuyente, clientes.lunes,
clientes.martes, clientes.miercoles,  clientes.jueves,
clientes.viernes, clientes.sabado, clientes.domingo,
clientes.limite_cred, clientes.plazo_pago, clientes.desc_global,
clientes.desc_p_pago,
clientes.campo01, clientes.campo02, clientes.campo03,
clientes.campo04,  clientes.cod_us_ing, clientes.fec_us_ing,
clientes.cod_us_mod, clientes.fec_us_mod, clientes.status
FROM clientes, clientes_tipos, vendedores, regiones
WHERE clientes.cod_cl_tipo = clientes_tipos.codigo
AND clientes.cod_vendedor = vendedores.codigo
AND clientes.cod_region = regiones.codigo
AND clientes.codigo = '$cliente'  ";

    $query = $bd->consultar($sql);

    if(!$cliente = $bd->obtener_name($query)){
        echo "<h1>".strlen($cliente)."</h1>";
    echo "<h1>Lo sentimos. No se pudo encontrar una coincidencia para este cliente. Inténtelo de nuevo.</h1>";
    exit;
    };

//Ahora consulto los datos de las cargar familiares
$sqlf="SELECT 

documento as doc,

nombres as nombres,

cargo as cargo,

telefono as tel,

correo as correo,

observacion as observacion

 FROM clientes_contactos WHERE clientes_contactos.cod_cliente = '".$cliente['codigo']."'";
$queryf = $bd->consultar($sqlf);


$dompdf= new DOMPDF();

ob_start();
$titulo= 'REPORTE CLIENTE';
require_once('../'.PlantillaDOM.'/unicas/clientes_ibarti.php');
    $dompdf->load_html(ob_get_clean(),'UTF-8');
    $dompdf->render();
    $pdf=$dompdf->output();
    $dompdf->stream('ficha_ibarti.pdf', array('Attachment' => 0));
    ?>
