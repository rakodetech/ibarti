<?php
$nivel_acceso=5;
require ("../autentificacion/aut_config.inc.php");
 
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

$sql = "SELECT cod_admin, ubic_admin FROM ubicacion_administrativa";
$result = mysql_query($sql,$db_conexion);


if (isset($_GET['error'])){

	$error_accion_ms[1]= "Debe ingresar todos los datos del usuario.";
	$error_accion_ms[2]= "Passwords no coinciden.";
	$error_accion_ms[3]= "El Nivel de Acceso ha de ser numérico.";
	$error_accion_ms[4]= "El Usuario ya está registrado.";
	$error_cod = $_GET['error'];
	
	echo "<script language='javascript'>
				alert('Error: ".$error_accion_ms[$error_cod]."');
		  </script>";

}

if (isset($_GET['accion']) && ($_GET['accion']=="guardar")){

		$usuario=$_POST['usuarionombre'];
		$pass1=$_POST['password1'];
		$pass2=$_POST['password2'];
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$email=$_POST['email'];
		$cedula=$_POST['cedula'];
		$departamento=$_POST['ubica_admin'];
		$status = 1;
			
		
		if ($pass1==="" or $pass2==="" or $usuario==="" or $nombre==="" or $apellido==="" or $email==="" or $cedula==="" or $departamento==="") {
		header ("Location: gus_agregauser.php?error=1");
		exit;
		}
		
		if ($pass1 != $pass2){
		header ("Location: gus_agregauser.php?error=2");
		exit;
		}
		
		/*if (!eregi("[1-6]",$nivel)){
		header ("Location: gus_agregauser.php?error=3");
		exit;
		}*/
		
		$usuarios_consulta = mysql_query("SELECT usuario_id FROM $sql_tabla WHERE login='$usuario'") or die(mysql_error());
		$total_encontrados = mysql_num_rows ($usuarios_consulta);
		mysql_free_result($usuarios_consulta);
		
		if ($total_encontrados != 0) {
			header ("Location: gus_agregauser.php?error=4");
		exit;
		}
		
		$usuario=stripslashes($usuario);
		$pass1 = md5($pass1);
		mysql_query("INSERT INTO $sql_tabla VALUES(null, upper('$nombre'), upper('$apellido'), $cedula, upper('$usuario'), '$pass1', '$departamento', upper('$email'), $status)") or die(mysql_error());
		
		
		
		
		mysql_close();
		
		/*echo "<script language='javascript'>
				alert('Usuario agregado con exito...');
				location.href='gus_agregauser.php';
		  </script>";*/
		  
	echo "<script language='javascript'>
	
		if (confirm('Usuario agregado con exito... ¿Desea asociar algun Sistema al usuario?')){;
			
			location.href='../autentificacion/aut_usuarios_sistemas.php?ultimo=si';
		
		}else{
		
			location.href='gus_gestionuser.php';
		
		}
		  </script>";

}
?>
<head>
<title>SISTEMA UNIFICADO DE SEGURIDAD</title>
<link href="../ccs/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="723" border="1" align="center" class="">
  
  <tr>
    <td height="92" colspan="2"><?php include('../plantillas/pl_cabecera.php')?></td>
  </tr>
  
  <tr>
    <td width="200" align="center" valign="top" bgcolor="#c8d8e8">
	<?php include('../plantillas/pl_menu.php');?>	</td>
  	
	<td width="574"  valign="top">
	
	<form method="post" action="gus_agregauser.php?accion=guardar">
  <table width="456" cellpadding="4" align="center">
      <td height="30" colspan="2" align="center" class="form_title" >Formulario Agregar Usuarios</td>
    </tr>
    <tr>
      <td colspan="2" class="formulario2"><hr noshade class="hr"></td>
    </tr>
    <tr>
      <td width="132" class="formulario1">Nombres:</td>
      <td width="300"><input name="nombre" type="text" class="campo_char" size="20" maxlength="50"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
	<tr>
      <td width="132" class="formulario1">Apellidos:</td>
      <td width="300"><input name="apellido" type="text" class="campo_char"size="20" maxlength="50"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
	 
	<tr>
      <td width="132" class="formulario1">Cedula:</td>
      <td width="300"><input name="cedula" type="text" class="campo_char" size="10" maxlength="8"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
	
	<tr>
      <td width="132" class="formulario1">Email:</td>
      <td width="300"><input name="email" type="text" class="campo_char" size="30" maxlength="50"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
	
	<tr>
      <td width="132" class="formulario1">Dep. De Trabajo:</td>
      <td width="300"> <select name="ubica_admin" class="campo_char" style="width:300px;">
        <option value="Null" selected>Seleccione...</option>
		<?php
 			while($row=mysql_fetch_array($result))
			{
				echo "<option value=".$row['cod_admin'].">".$row['ubic_admin']."</option>";
			}
		?>
      </select><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	 </td>
    </tr>
	
	<tr>
      <td width="132" class="formulario1">Login:</td>
      <td width="300"><input name="usuarionombre" type="text" class="campo_char" size="20" maxlength="15"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
    <tr>
      <td width="132" class="formulario1">Password:</td>
      <td width="300"><input name="password1" type="password" class="campo_char" size="10" maxlength="8"><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>
    <tr>
      <td width="132" class="formulario1">Password (repitalo):</td>
      <td width="300"><input name="password2" type="password" class="campo_char" size="10" maxlength="8">
      </font></b><br>
      <span class="mensaje_error1">[*]</span> <span class="mensaje_error"><?php echo $mens8?></span>	</td>
    </tr>

	<tr>
	  <td colspan="2" height="10" align="center"><br><input name="Submit" type="submit" class="textboton1" value="  Registrar  " />
	    &nbsp;&nbsp;
        <input name="back" type="button" class="textboton1"  id="back2" onClick="history.back(-1);" value="Volver" />
        &nbsp;&nbsp;
        <input name="reset" type="reset" class="textboton1" value="Restablecer" /></td>
    </tr>
	<tr>
	  <td colspan="2" height="27"><span class="mensaje_error1">[*]</span> <span class="mensaje_error"> Denota Campo Obligatorio </span></td>
    </tr>
	<tr>
      <td colspan="2" height="10"><hr noshade class="hr" />      </td>
    </tr>
</table>
</form>
	
	</td>
  </tr>
 

  <tr>
    <td colspan="2"><?php include('../plantillas/pl_piedepag.php')?></td>
  </tr>
</table>
</body>
</html>
