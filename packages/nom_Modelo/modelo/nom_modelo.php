<?php

class Nom_modelo
{
  private $bd;
	function __construct()
	{
    $this->datos   = array();
    $this->bd = new Database;
	}

	public function get_concetos(cod){
    $sql = " SELECT * FROM horarios ORDER BY 2 ASC ";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->  obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
	}
  public function get_concetos_all(){
    $sql = " SELECT * FROM horarios ORDER BY 2 ASC ";
    $query = $this->bd->consultar($sql);

    while ($datos= $this->bd->  obtener_fila($query)) {
      $this->datos[] = $datos;
    }
    return $this->datos;
  }


}
?>
