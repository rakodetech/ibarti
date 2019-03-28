<?php
// Motor autentificación usuarios.
// Cargar datos conexion y otras variables.
require("autentificacion/aut_config.inc.php");
//require ("../autentificacion/aut_config.inc.php");
// chequear página que lo llama para devolver errores a dicha página.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script.
/*
	//   	NO APLICA INTERNET EXPLORER  //
if ($_SERVER['HTTP_REFERER'] == ""){
echo $_SERVER['HTTP_REFERER'];
echo 'vacio';		
die ("<script language='javascript'>				
					alert('Error: Acceso Incorrecto HTTP...');
					history.back(-1);
	</script>");
exit;
}
*/

if (isset($_POST['login']) && isset($_POST['pass'])) {
// Conexión base de datos.

$login=strtoupper($_POST['login']);
$login=stripslashes($login);

$db_conexion= pg_connect("$sql_host", "$sql_usuario", "$sql_pass") or die(header ("Location:  $redir?error_login=0"));
mysql_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.
$usuario_consulta = mysql_query("SELECT nombre, apellido, cedula, login, pass, id_perfil, status FROM $sql_tabla WHERE login = '$login'") or die(header ("Location:  $redir?error_login=1"));

$perfil_id = $usuario_datos['id_perfil'];

	$query_perfil = mysql_query("SELECT * FROM perfil_menu WHERE id_perfil = 1", $cnn) or die
	                            (header ("Location:  $redir?error_login=8"));
// miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)

 if (mysql_num_rows($usuario_consulta) != 0) {
	$password = md5($_POST['pass']);
	//$password = $_POST['pass'];
    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$usuario_datos = mysql_fetch_array($usuario_consulta);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
   mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.
   mysql_close($db_conexion);
     
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // página de error.
    if ($login != $usuario_datos['login']) {
       	Header ("Location: $redir?error_login=4");
	exit;}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la página de error
    if ($password != $usuario_datos['pass']) {
        Header ("Location: $redir?error_login=3");
	    exit;}

	if ($usuario_datos['status']!= 1){
	Header ("Location: $redir?error_login=7");
	exit;}	

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset ($password);

    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.
    
     // le damos un mobre a la sesion.

    //session_name($usuarios_sesion);
     // incia sessiones
    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta página.
    session_cache_limiter('nocache,private');
    
    // Asignamos variables de sesión con datos del Usuario para el uso en el
    // resto de páginas autentificadas.

    $_SESSION['usuario_id'] = $usuario_datos['cedula'];
   
    $_SESSION['usuario_login'] = $usuario_datos['login'];

    //definimos usuario_password con el password del usuario de la sesión actual (formato md5 encriptado)
    $_SESSION['usuario_password'] = $usuario_datos['pass'];
	
	$_SESSION['usuarioN'] = $usuario_datos['apellido'].'&nbsp;'.$usuario_datos['nombre'];
	
	$_SESSION['id_perfil'] = $usuario_datos['id_perfil'];
	
	while($row_perfil = mysql_fetch_array($query_perfil)){
		$perfil = $row_perfil[1];
		$_SESSION['M'.$perfil.''] = $perfil;	
	}
  
	//definimos las variable de seccion para le sistema de caja chica//
//   $_SESSION['unidad_ejecutora'] =$usuario_datos['undeje']; 

    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    
   /* $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;*/
 // Header ("Location: aut_sistemas_user.php");
  Header ("Location: ../pl_inicio.php?area=formularios/index");
//Header ("Location: ../pl_inicio.php?nivel=5&area=formularios/index");
	
   } else {
       // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
     exit;}
} else {

// -------- Chequear sesión existe -------

// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
// El caso mas comun es el de una vez "muerta" la sesion se intenta volver hacia atras
// con el navegador.


	if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
	// Borramos la sesion creada por el inicio de session anterior
		session_destroy();
		die ("<script language='javascript'>
					alert('Error: Acceso Incorrecto SECCION...');
					location. href='../';
	</script>!");
		exit;
	}
}
	
?>