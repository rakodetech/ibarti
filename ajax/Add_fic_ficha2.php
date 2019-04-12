<?php
include_once('../funciones/funciones.php');
require("../autentificacion/aut_config.inc.php");
require "../".class_bd;
require "../".Leng;
$bd = new DataBase();

//require_once('../autentificacion/aut_config.inc.php');
//include_once('../funciones/mensaje_error.php');
$Nmenu      = $_POST['Nmenu'];
$mod        = $_POST['mod'];
$archivo    = "ficha2";
$tabla      = "";
$r_rol      = $_POST['r_rol'];
$rol        = $_POST['rol'];
$status     = $_POST['status'];
$usuario    = $_POST['usuario'];
$filtro     = $_POST['filtro'];
$ficha      = $_POST['ficha'];
$r_cliente  = $_POST['r_cliente'];
$b_cons     = $_POST['b_cons'];
$b_add      = $_POST['b_add'];
$b_mod      = $_POST['b_mod'];
$b_eli      = $_POST['b_eli'];

$r_cons     = " ";
$r_add      = " ";
$r_mod      = " ";
$r_eli      = " ";



	$vinculo = "inicio.php?area=pestanas/add_$archivo&Nmenu=$Nmenu&mod=$mod";

	$WHERE =" WHERE ficha.cod_ficha_status = ficha_status.codigo
                AND ficha.cod_contracto <> control.contracto_eventuales
                AND ficha.cod_ficha = trab_roles.cod_ficha
                AND trab_roles.cod_rol =  roles.codigo ";

	if($rol != "TODOS"){
		$WHERE .= " AND  roles.codigo  = '$rol' ";
	}
	if($status != "TODOS"){
		$WHERE .= "  AND ficha_status.codigo = '$status' ";
	}

	if(($filtro != "TODOS") and ($ficha) != ""){
		$WHERE .= "  AND ficha.cod_ficha = '$ficha' ";
	}
	if($r_cliente  == "T"){
		$WHERE  .= "AND ficha.cod_ubicacion IN (SELECT cod_ubicacion FROM usuario_clientes WHERE
		cod_usuario = '$usuario' AND usuario_clientes.cod_ubicacion = ficha.cod_ubicacion)";
	}
	if($r_rol == "T"){
	$FROM = 	" , usuario_roles ";
	$AND  = " 	AND usuario_roles.cod_usuario = '$usuario' AND trab_roles.cod_rol = usuario_roles.cod_rol ";
	}else{
	$FROM = " ";
	$AND  = " 	 ";
	};

	$sql = "SELECT ficha.cod_ficha, ficha.cedula,
	               CONCAT(ficha.apellidos,' ', ficha.nombres) AS nombres,  roles.descripcion AS rol,
					ficha.fec_ingreso, ficha.fec_us_mod,
					ficha_status.descripcion AS status
               FROM ficha, ficha_status, control, trab_roles, roles
			        $FROM
                    $WHERE
					$AND
		      ORDER BY 6 DESC";

?><table width="100%" border="0" align="center">
		<tr class="fondo00">
			<th width="22%" class="etiqueta"><?php echo $leng["rol"];?></th>
			<th width="10%" class="etiqueta"><?php echo $leng["ficha"];?></th>
    		<th width="10%" class="etiqueta"><?php echo $leng["ci"];?></th>
			<th width="30%" class="etiqueta">Nombre</th>
  			<th width="10%" class="etiqueta">Fecha Ult. <br />Actualizacion</th>
            <th width="10%" class="etiqueta">Status</th>
		    <th width="8%" align="center"><img src="imagenes/loading2.gif" alt="Consultar Registro" title="Consultar Registro"
                                                width="20px" height="20px" border="null"/></th>
	</tr>
     <?php
	$valor = 0;
    $query = $bd->consultar($sql);

		while ($datos=$bd->obtener_fila($query,0)){
		if ($valor == 0){
			$fondo = 'fondo01';
		$valor = 1;
		}else{
			$fondo = 'fondo02';
			$valor = 0;
		}

	// $Modificar = "Add_Mod01('".$datos[0]."', 'modificar')";
	   $Borrar = "Borrar01('".$datos[0]."')";

	   if($b_cons == "true"){
		   $r_cons = '<a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=consultar"><img src="imagenes/consultar.png" alt="Consultar" title="Consultar Registro" width="20" height="20" border="null"/></a>';
		}
	   if($b_mod == "true"){
		   $r_mod = '<a href="'.$vinculo.'&codigo='.$datos[0].'&metodo=modificar"><img src="imagenes/actualizar.bmp" alt="Modificar" title="Modificar Registro" width="20" height="20" border="null"/>';
		}
	   if($b_eli == "true"){
		   $r_eli = '<img src="imagenes/borrar.bmp"  width="20px" height="20px" title="Borrar Registro" border="null" onclick="'.$Borrar.'" class="imgLink"/>';
		}

        echo '<tr class="'.$fondo.'">
                  <td>'.longitud($datos["rol"]).'</td>
				  <td>'.$datos["cod_ficha"].'</td>
				  <td>'.$datos["cedula"].'</td>
                  <td>'.longitud($datos["nombres"]).'</td>
				  <td>'.$datos["fec_us_mod"].'</td>
				  <td>'.$datos["status"].'</td>
				  <td align="center">'.$r_cons.'&nbsp;'.$r_mod.'&nbsp;'.$r_eli.'</td>
            </tr>';
        }
     echo '<input type="hidden" name="tabla" id="tabla" value="'.$tabla.'"/>';
	 mysql_free_result($query);	?>
    </table>
