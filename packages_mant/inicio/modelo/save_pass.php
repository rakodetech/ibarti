<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../".Funcion;
require_once  "../../../".class_bdI;

class save_pass
{
	private $datos;
	private $bd;
	

	function __construct()
	{
		$this->datos   = array();
		
		$this->bd = new Database;
	}

	public function get_data_pass($usuario){
		$sql = "SELECT login ,concat(nombre , ' ' , apellido) nombre, email,pass ,codigo
				from men_usuarios
				WHERE login = '$usuario'
				AND email <> ''
				AND  `status` = 'T'
		";
		
		$query         = $this->bd->consultar($sql);
		return $datos= $this->bd-> obtener_fila($query);

	}

	public function set_data_pass($cod_usuario,$old_clave,$new_clave){
		$sql = "UPDATE men_usuarios SET   
           pass             = '$new_clave',     pass_old    =  '$old_clave',
           clave_invalidad  = 0,  
           fec_us_mod   = CURDATE(),
           fec_mod_pass =  CURDATE()
   		  WHERE codigo = '$cod_usuario';
		";
		
		return $this->bd->consultar($sql);
	}

}
?>
