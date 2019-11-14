<?php
// require "../../../modulo/horario/modelo/horario_modelo.php";
// $horario = new Horario_modelo;

  class Horario_modelo
  {
    private $bd;
    private $horario;
    function __construct(){
      define("SPECIALCONSTANT", true);
      // include_once "../../../funciones/funciones.php";
      require "../../../autentificacion/aut_config.inc.php";
      require "../../../".class_bdI;
    //  require "../../../".Leng;

      $this->bd = new DataBase();
      $this->horario = array();
  }

    function get_horario(){

      $sql = " SELECT horarios.codigo, horarios.nombre,
                      horarios.hora_entrada, horarios.hora_salida,
                      horarios.inicio_marc_entrada, horarios.fin_marc_entrada,
                      horarios.inicio_marc_salida, horarios.fin_marc_salida,
                      horarios.dia_trabajo, horarios.minutos_trabajo,
                      horarios.`status`
                 FROM horarios
            ORDER BY 2 ASC ";
      $query         = $this->bd->consultar($sql);

      while ($datos=$bd->obtener_name($query,0)){
          $this->horario[] = $datos;
        }

    }
  }
?>
