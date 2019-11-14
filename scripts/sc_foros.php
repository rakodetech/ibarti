<?php
require_once('../autentificacion/aut_config.inc.php'); 
include_once('../funciones/funciones.php');
include_once('../funciones/mensaje_error.php');
mysql_select_db($bd_cnn, $cnn);

$tabla          = 'foros';
$tabla2         = 'foros_renglon';
$tabla_id       = 'codigo';

$codigo         = $_POST['codigo']; 
$campo_id       = $_POST['campo_id'];
$expediente     = $_POST['expediente'];
$fecha_notif    = Rconversion($_POST['fecha_notif']);
$fecha          = Rconversion($_POST['fecha']);
$titulo         = htmlentities(strtoupper($_POST['titulo']));
$asunto         = htmlentities($_POST['asunto']);
$mensajes       = htmlentities($_POST['mensaje']); 
$categoria      = $_POST['categoria'];
$region         = $_POST['region'];
$trabajador     = $_POST['trabajador'];
$cita           = $_POST['cita'];
$cita_fecha     = Rconversion($_POST['cita_fecha']);
$cita_hora      = $_POST['cita_hora']; 
$usuario        = $_POST['usuario'];
$status         = $_POST['status'];			  
$href           = $_POST['href'];

	$cabeceras = 'To: $para' . "\r\n";
	$cabeceras .= 'From: Sistema de Oesvica <info@oesvica.com.ve>' . "\r\n";
    //mando el correo...	

	if($cita ==  ''){
		$cita = "N";	
	}

if (isset($_POST['metodo'])) {
	$i=$_POST['metodo'];
	switch ($i) {

    case 'agregar':   
	 	 begin();	
	 	$codigo = date("Y-m-d H:m:s"); 
		$result01 = mysql_query("SELECT control.foros_codigo FROM control", $cnn)or die
								 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');  
		$row01    = mysql_fetch_array($result01);
		$codigo   = $row01[0];
		$codigo2  = $codigo + 1; 

     mysql_query("UPDATE control SET 			 
						  control.foros_codigo    = '$codigo2'", $cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');								 

	 mysql_query("INSERT INTO $tabla SET
						 codigo        = '$codigo',      cod_autor          = '$usuario',
						 cod_emp       = '$trabajador',
						 expedientes   = '$expediente',  fecha_notificacion = '$fecha_notif',
						 cod_region    = '$region',      cod_categoria      = '$categoria',
						 asunto        = '$titulo',      mensaje            = '$mensajes',
						 `status`      =  '1', 
						 cod_us_ing    = '$usuario',     fec_us_ing    = '$date',
						 cod_us_mod    = '$usuario',     fec_us_mod    = '$date'",$cnn)or die
							 ('<br><h3>Error Consulta # 3:</h3> '.mysql_error().'<br>');

		$result01 = mysql_query("SELECT oesvica_oesvica.foros_categoria.descripcion AS categoria,
								        oesvica_oesvica.regiones.descripcion AS region,
								        oesvica_oesvica.trabajadores.cod_emp,
								        oesvica_oesvica.trabajadores.nombres AS trabajador,
								        CONCAT(oesvica_sistema.usuarios.apellido, ' ', oesvica_sistema.usuarios.nombre) AS autor
							       FROM oesvica_oesvica.regiones , oesvica_oesvica.trabajadores ,
								        oesvica_oesvica.foros_categoria , oesvica_sistema.usuarios
							      WHERE oesvica_oesvica.regiones.id = '$region' 
							        AND oesvica_oesvica.trabajadores.cod_emp = '$trabajador' 
							        AND oesvica_oesvica.foros_categoria.id = '$categoria' 
							        AND oesvica_sistema.usuarios.cedula = oesvica_oesvica.foros_categoria.cod_us_ing", $cnn)or die
															 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');  
															 

		$row01    = mysql_fetch_array($result01);		 
	
	$mensaje = "Titulo: ".$_POST['titulo']."\r\n  
	            N Expediente O Referencia: $expediente \r\n 
	            Fecha Recepcion: ".conversion($fecha_notif)."  \r\n 
	            Categoria:       ".$row01['categoria']." \r\n
	            Region:          ".$row01['region']." \r\n 
	            Trabajador: ".$row01['cod_emp']." - ".$row01['trabajador']." \r\n
			    Autor : ".$row01['autor']." \r\n \r\n
			    Mensaje: ".$_POST['mensaje']."";	
	$para      = " "; 	
	$query01 = mysql_query("SELECT oesvica_sistema.usuarios.email 
	                          FROM oesvica_oesvica.foros_correos , oesvica_sistema.usuarios
                             WHERE oesvica_oesvica.foros_correos.cod_categoria = '$categoria'
                               AND oesvica_oesvica.foros_correos.cod_usuarios = oesvica_sistema.usuarios.cedula",$cnn)or die
								 ('<br><h3>Error Consulta # 4:</h3> '.mysql_error().'<br>');
						  while($row01 = mysql_fetch_array($query01)){
							$para .= "".$row01[0]." , ";				
						  }


		if(mail($para, $_POST['titulo'], $mensaje, $cabeceras)){
			 echo '<script language="javascript">
				   alert("Mensaje Enviado Correctamente");
				   </script>';	
	
	   }else{	   
			 echo '<script language="javascript">
				   alert("Mensaje No Se Pudo Enviar");
				   </script>';
	   }

	break; 		
	case 'modificar':    
		 begin();	 		
      mysql_query("UPDATE $tabla SET   							 
                             expedientes   = '$expediente',   fecha_notificacion = '$fecha_notif',
							 cod_region    = '$region',      cod_categoria      = '$categoria',
							 asunto        = '$titulo',      mensaje            = '$mensajes',
							 `status`      =  '$status',     cod_emp            = '$trabajador',
							 cod_us_mod    = '$usuario',     fec_us_mod    = '$date'
	  		       WHERE  codigo = '$codigo'", $cnn);
				   				  
				   
	break;
    case 'agregar_renglon':   
	 	 begin();	

  /* SELECT control.foros_codigo FROM control  */
	 mysql_query("INSERT INTO $tabla2 SET
							 codigo        = NULL,        codigo_foro   = '$codigo',
							 asunto        = '$asunto',   mensaje       = '$mensajes',
							 cita          = '$cita',     cita_fecha    = '$cita_fecha',
							 cita_hora     = '$cita_hora',`status`      =  '1', 
							 cod_us_ing    = '$usuario',  fec_us_ing    = '$date',
							 cod_us_mod    = '$usuario',  fec_us_mod    = '$date'",$cnn)or die
								 ('<br><h3>Error Consulta # 2:</h3> '.mysql_error().'<br>');

		$result01 = mysql_query("SELECT oesvica_oesvica.foros_categoria.descripcion AS categoria,                                        oesvica_oesvica.regiones.descripcion AS region,
										oesvica_oesvica.trabajadores.cod_emp,
										oesvica_oesvica.trabajadores.nombres AS trabajador,
										oesvica_oesvica.foros.expedientes,
										oesvica_oesvica.foros.cod_categoria,
										oesvica_oesvica.foros.fecha_notificacion,
										oesvica_oesvica.foros.asunto,
										oesvica_oesvica.foros.mensaje,
										CONCAT(oesvica_sistema.usuarios.apellido, ' ', oesvica_sistema.usuarios.nombre) AS autor									                                   FROM oesvica_oesvica.foros, oesvica_oesvica.regiones , 
										oesvica_oesvica.foros_categoria, oesvica_oesvica.trabajadores,
										oesvica_sistema.usuarios
								  WHERE oesvica_oesvica.foros.codigo = '$codigo' 
									AND oesvica_oesvica.foros.cod_region = oesvica_oesvica.regiones.id 
									AND oesvica_oesvica.foros.cod_categoria = oesvica_oesvica.foros_categoria.id 
									AND oesvica_oesvica.foros.cod_emp = oesvica_oesvica.trabajadores.cod_emp 
									AND oesvica_sistema.usuarios.cedula = oesvica_sistema.usuarios.cedula", $cnn)or die
				 ('<br><h3>Error Consulta # 1:</h3> '.mysql_error().'<br>');  
	 $row01    = mysql_fetch_array($result01);	
 
 	$mensaje = " Titulo: ".$row01['asunto']."\r\n 
	             N Expediente O Referencia: ".$row01['expedientes']." \r\n 
	             Fecha Recepcion: ".Rconversion($row01['fecha_notificacion'])."  \r\n 
	             Categoria: ".$row01['categoria']." \r\n
	             Region: ".$row01['region']." \r\n 
	             Trabajador: ".$row01['cod_emp']." - ".$row01['trabajador']." \r\n				 				 
				 Autor : ".utf8_decode($row01['autor'])." \r\n\n				
				 Asunto: ".$_POST['asunto']."  \r\n 
				 Mensaje: ".$_POST['mensaje']." \r\n ";		 

	$para      = " "; 	
	$query01 = mysql_query("SELECT oesvica_sistema.usuarios.email 
	                          FROM oesvica_oesvica.foros_correos , oesvica_sistema.usuarios
                             WHERE oesvica_oesvica.foros_correos.cod_categoria = '$categoria'
                               AND oesvica_oesvica.foros_correos.cod_usuarios = oesvica_sistema.usuarios.cedula",$cnn)or die
								 ('<br><h3>Error Consulta # 4:</h3> '.mysql_error().'<br>');
						  while($row01 = mysql_fetch_array($query01)){
							$para .= "".$row01[0]." , ";				
						  }
				   
	  if($cita == "S"){
		$mensaje .= " Cita Fecha: ".$_POST['cita_fecha']."\r\n
		              Cita Hora: ".$cita_hora." \r\n ";
		}

		if(mail($para, $_POST['titulo'], $mensaje, $cabeceras)){
			 echo '<script language="javascript">
				   alert("Mensaje Enviado Correctamente");
				   </script>';	
	
	   }else{	   
			 echo '<script language="javascript">
				   alert("Mensaje No Se Pudo Enviar");
				   </script>';
	   }
	break; 		
	case 'modificar_renglon':    
		 begin();	 		
      mysql_query("UPDATE $tabla SET   							 
						  cod_region    = '$region',   cod_categoria = '$categoria',
						  descripcion   = '$titulo',   mensaje       = '$mensajes',
						  `status`      =  '$status', 
						  cod_us_mod    = '$usuario',  fec_us_mod    = '$date'
	  		       WHERE  codigo = '$codigo'", $cnn);
	break;	

	case 'borrar':    
	     begin();

		mysql_query ("DELETE FROM $tabla WHERE  $tabla_id = '$id'", $cnn);  
		$mensaje = "Registro Borrado";												 
	}        
}
require_once('../funciones/sc_direccionar.php');  
?>