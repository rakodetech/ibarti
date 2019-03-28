<?php

/**
 * Representa el la estructura de las asistencias diarias
 * almacenadas en la base de datos
 */
require 'Database.php';

class Asistencia
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'asistencia'
     *
     * @param $idasistencia Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {

           $consulta = "SELECT * FROM asistenciamovil order by cod_ficha asc";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
             $e->getMessage();
            return $e;;
        }
    }

    public static function getNOMINAS($idAsistencia)
    {

       $consultacod= "SELECT * from v_int_usuario where login='$idAsistencia'";
          try {
            // Preparar sentencia
             $comandosql = Database::getInstance()->getDb()->prepare($consultacod);
            // Ejecutar sentencia preparada
            $comandosql->execute(array('login' => $idAsistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $idcodusuario= $row["codigo"];

           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
             $consulta="SELECT v_int_contratos.codigo as idmovil, v_int_contratos.descripcion AS cod_ficha
                         FROM v_int_usuario_roles , v_int_trab_roles, v_int_ficha , v_int_contratos
                         WHERE v_int_usuario_roles.cod_usuario = '$idcodusuario'
                         AND v_int_usuario_roles.cod_rol = v_int_trab_roles.cod_rol
                         AND v_int_trab_roles.cod_ficha = v_int_ficha.cod_ficha
                         AND v_int_ficha.cod_contracto = v_int_contratos.codigo GROUP BY v_int_contratos.codigo
                         ORDER BY 2 DESC";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));

            return $comando->fetchAll(PDO::FETCH_ASSOC);
          cerrar($pdo,$comando);
        } catch (PDOException $e) {
                 $e->getMessage();
            return $e;
        }
        
    }
      public static function getROLES($idAsistencia)
    {
        // Consulta de la asistencia diaria

          $consulta = "SELECT t1.codigo as idmovil,
                            t1.descripcion as cod_ficha FROM v_int_roles as t1 INNER JOIN v_int_usuario_roles AS t2 ON t1.codigo = t2.cod_rol AND t2.cod_usuario='$idAsistencia'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
    public static function getROLESBUSCAR($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $consulta = "SELECT codigo as idmovil,
                            descripcion as cod_ficha FROM v_int_roles WHERE codigo like '%$idAsistencia%' or descripcion like '%$idAsistencia%'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
      public static function getCLIENTES($idAsistencia)
    {
        // Consulta de la asistencia diaria

        $consulta =  "SELECT Distinct t1.codigo as idmovil,t1.nombre cod_ficha,t1.status  FROM v_int_cliente as t1 LEFT JOIN v_int_cl_ubic AS t2 ON t1.codigo=t2.cod_cliente LEFT JOIN v_int_usuario_clientes as t3 ON t2.cod_ubicacion=t3.cod_ubicacion where t3.cod_usuario='$idAsistencia' and t1.status='T'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }

     public static function getCLIENTESBUSCAR($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $consulta =  "SELECT codigo as idmovil,nombre as cod_ficha  FROM v_int_cliente  where codigo like '%$idAsistencia%' or nombre like '%$idAsistencia%'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
     public static function getUBICACIONBUSCAR($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $consulta =  "SELECT cod_ubicacion as idmovil,ubicacion as cod_ficha  FROM v_int_cl_ubic  where cod_cliente ='$idAsistencia'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }

       public static function getFICHAS($idAsistencia)
    {
        $idrol= strstr($idAsistencia, '-', true);
        $idclaveaux= strstr($idAsistencia, '-');
        $idnomina=substr($idclaveaux,1,strlen($idclaveaux));


        $consulta = "SELECT Distinct t1.cod_ficha as idmovil,t1.cod_ficha as cod_ficha,t1.nombres as cod_cliente,t1.apellidos as cod_ubicacion,t1.cod_ficha_status as cod_concepto FROM v_int_ficha as t1 LEFT JOIN v_int_trab_roles as t2 ON t1.cod_ficha=t2.cod_ficha where t2.cod_rol='$idrol' and t1.cod_contracto='$idnomina' and t1.cod_ficha_status='A'";


        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
       public static function getFICHASCONTRACTO($idAsistencia)
    {
        // Consulta de la asistencia diaria

        $consulta = "SELECT cod_ficha as idmovil,cod_ficha as cod_ficha,nombres as cod_cliente,apellidos as cod_ubicacion,cod_ficha_status as cod_concepto,cod_contracto FROM v_int_ficha where cod_contracto='$idAsistencia' and cod_ficha_status='A'";


        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }



    public static function getCONCEPTOS()
    {

           $consulta = "SELECT codigo as idmovil,abrev as cod_ficha,status as cod_cliente FROM v_int_conceptos where status='T' and asist_diaria='T' order by codigo asc";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
             $e->getMessage();
            return $e;
        }
    }
    public static function getUSUARIOS()
    {

    $consulta = "SELECT t1.codigo as idmovil,t1.cedula as cod_ficha ,t1.login  as cod_cliente ,t1.nombre as cod_ubicacion,t1.apellido as cod_concepto,t1.fec_us_ing as fec_us_ing FROM v_int_usuario as t1 INNER JOIN v_int_men_perfil_menu AS t2 ON t1.cod_perfil = t2.cod_men_perfil AND t2.cod_menu =405";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
             $e->getMessage();
            return $e;;
        }
    }
    
    public static function getByIdUSUARIO($idAsistencia)
    {
        // Consulta de la asistencia diaria

        $link = mysqli_connect('c122.gconex.com', 'ib_integracion','$$ib_INTEG2016' );

        mysqli_select_db($link,'ib_demo');
        $tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes
        $result = mysqli_query($link, "SELECT t1.codigo ,t1.cedula as cod_ficha ,t1.login  as cod_cliente ,t1.nombre as cod_ubicacion,t1.apellido as cod_concepto,t1.fec_us_ing as fec_us_ing,t1.pass FROM v_int_usuario as t1 INNER JOIN v_int_men_perfil_menu AS t2 ON t1.cod_perfil = t2.cod_men_perfil AND t2.cod_menu='405' and  t1.codigo='$idAsistencia'");

        mysqli_data_seek ($result, 0);

        $extraido= mysqli_fetch_array($result);

        $idmovil=$extraido['codigo'];

          $consulta="SELECT codigo as idmovil,cedula as cod_ficha,login as cod_cliente,nombre as cod_ubicacion,apellido as concepto,fec_us_ing as fec_us_ing from v_int_usuario where codigo='$idmovil'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
       public static function getByIdUSUARIOLOGIN($idAsistencia,$idclave)
    {
        // Consulta de la asistencia diaria
        
         $password=md5($idclave);

          $consulta="SELECT login as idmovil,cedula as cod_ficha,login as cod_cliente,nombre as cod_ubicacion,apellido as concepto,fec_us_ing as fec_us_ing from v_int_usuario where login='$idAsistencia' and pass='$password'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia,$idclave));
            // Capturar primera fila del resultado
            $row = $comando->fetchALL(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;;
        }
    }
         public static function CONFIGURA($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $idlogin= strstr($idAsistencia, '-', true);
        $idclaveaux= strstr($idAsistencia, '-');
        $idclave=substr($idclaveaux,1,strlen($idclaveaux));


         $fp = fopen("ibartic.txt", "r");

           $numlinea=0;
          while(!feof($fp)) {

              $linea = fgets($fp);
               if ($numlinea==0){
                   $url=$linea;
                }
               if ($numlinea==1){
                   $bd=$linea;
                }
                if ($numlinea==2){
                   $login=trim($linea);
                }
                 if ($numlinea==3){
                   $password=trim($linea);
                }
                
                $numlinea=$numlinea + 1;
             }
             fclose($fp);
             $consulta="select Host as idmovil,User as cod_ficha,Password as cod_cliente from mysql.user where User='$login' and Password='$password'";
         try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return  $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
             $e->getMessage();
            return $e;
        }
    }

       public static function LOGINCLAVE($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $idlogin= strstr($idAsistencia, '-', true);
        $idclaveaux= strstr($idAsistencia, '-');
        $idclave=substr($idclaveaux,1,strlen($idclaveaux));

        $password=md5($idclave);

        $consulta="SELECT login as idmovil,cedula as cod_ficha,login as cod_cliente,nombre as cod_ubicacion,apellido as cod_concepto,cod_perfil as fec_us_ing from v_int_usuario where login='$idlogin' and pass='$password'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            $e->getMessage();
            return $e;
        }
    }

    /**
     * Obtiene los campos de una asistencia con un identificador
     * determinado
     *
     * @param $idAsistencia Identificador de la asistencia diaria
     * @return mixed
     */
     public static function getfechadiariacierre($idAsistencia)
    {
        // Consulta de la asistencia diaria
         $idnomina= strstr($idAsistencia, '-', true);
         $idloginaux= strstr($idAsistencia, '-');
        $rol=substr($idloginaux,1,strlen($idloginaux));

        $consulta="SELECT Min(v_int_asistencia_apertura.fec_diaria) AS cod_ficha, v_int_asistencia_apertura.fec_cierre as cod_ubicacion,
					 v_int_asistencia_apertura.codigo, v_int_contratos.descripcion AS contracto, v_int_roles.descripcion AS rol
				FROM v_int_asistencia_apertura , v_int_asistencia_cierre , v_int_contratos, v_int_roles
			   WHERE v_int_asistencia_apertura.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = '$idnomina'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_asistencia_cierre.cod_contracto
				 AND v_int_asistencia_cierre.cod_rol = '$rol'
				 AND v_int_asistencia_apertura.codigo = v_int_asistencia_cierre.cod_as_apertura
				 AND v_int_asistencia_cierre.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_contratos.codigo
				 AND v_int_roles.codigo = '$rol' ";
          try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $row;


        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }



    }
     public static function getasistenciausuario($idAsistencia)
    {
        // Consulta de la asistencia diaria
         $idnomina= strstr($idAsistencia, '-', true);
         $idloginaux= strstr($idAsistencia, '-');
        $rol=substr($idloginaux,1,strlen($idloginaux));

        $consulta="SELECT Min(v_int_asistencia_apertura.fec_diaria) AS fec_diaria, v_int_asistencia_apertura.fec_cierre,
					 v_int_asistencia_apertura.codigo, v_int_contratos.descripcion AS contracto, v_int_roles.descripcion AS rol
				FROM v_int_asistencia_apertura , v_int_asistencia_cierre , v_int_contratos, v_int_roles
			   WHERE v_int_asistencia_apertura.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = '$idnomina'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_asistencia_cierre.cod_contracto
				 AND v_int_asistencia_cierre.cod_rol = '$rol'
				 AND v_int_asistencia_apertura.codigo = v_int_asistencia_cierre.cod_as_apertura
				 AND v_int_asistencia_cierre.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_contratos.codigo
				 AND v_int_roles.codigo = '$rol' ";
          try {
            // Preparar sentencia
            
             $comandosql = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comandosql->execute(array($idasistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $codaperturahoy= $row["codigo"];

           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }

        //date('Y-m-d');
        $consulta="SELECT v_int_asistencia.cod_ficha as cod_ficha,CONCAT(v_int_ficha.apellidos, ' ', v_int_ficha.nombres) AS cod_ubicacion,
					   v_int_asistencia.cod_cliente,v_int_cliente.nombre AS cliente,
					   v_int_asistencia.cod_ubicacion as idmovil, v_int_cl_ubic.ubicacion AS ubicacion,
					   v_int_asistencia.cod_concepto, v_int_conceptos.descripcion,
					   v_int_conceptos.abrev as cod_concepto, v_int_asistencia.hora_extra,
					   v_int_asistencia.hora_extra_n, v_int_asistencia.vale,
					   v_int_asistencia.feriado, v_int_asistencia.no_laboral AS NL
				  FROM v_int_asistencia , v_int_ficha, v_int_trab_roles, v_int_cliente,
				       v_int_cl_ubic , v_int_conceptos
			     WHERE v_int_asistencia.cod_as_apertura = '$codaperturahoy'
				   AND v_int_asistencia.cod_ficha = v_int_ficha.cod_ficha
			       AND v_int_ficha.cod_ficha = v_int_trab_roles.cod_ficha
			       AND v_int_asistencia.cod_cliente = v_int_cliente.codigo
				   AND v_int_asistencia.cod_ubicacion = v_int_cl_ubic.cod_ubicacion
				   AND v_int_asistencia.cod_concepto = v_int_conceptos.codigo
				   AND v_int_trab_roles.cod_rol = '$rol'
			  ORDER BY cod_ficha ASC";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
             }
    }
     
     public static function getnominasusuario($idAsistencia)
    {
        // Consulta de la asistencia diaria
      $fechaservidor=date('Y-m-d');
      $consulta ="SELECT @rownum := @rownum +1 AS idmovil,t6.codigo AS cod_ficha,t4.abrev AS cod_concepto, t3.ubicacion AS cod_ubicacion,t5.fec_diaria as fec_us_ing
FROM (

SELECT @rownum :=0
)r, v_int_usuario AS t1
LEFT JOIN v_int_usuario_clientes AS t2 ON t1.codigo = t2.cod_usuario
RIGHT JOIN v_int_cl_ubic AS t3 ON t2.cod_ubicacion = t3.cod_ubicacion
RIGHT JOIN v_int_cliente AS t4 ON t3.cod_cliente = t4.codigo
RIGHT JOIN v_int_asistencia_apertura AS t5 ON t1.codigo = t5.cod_us_ing
RIGHT JOIN v_int_contratos AS t6 ON t6.codigo = t5.cod_contracto
WHERE t1.login = '$idAsistencia' and t5.status='T'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
   public static function getnominaslogincliente($idAsistencia)
    {
        // Consulta de la asistencia diaria
        
         $idlogin= strstr($idAsistencia, '-', true);
        $idloginaux= strstr($idAsistencia, '-');
        $idcliente=substr($idloginaux,1,strlen($idloginaux));
      $fechaservidor=date('Y-m-d');
      $consulta ="SELECT @rownum := @rownum +1 AS idmovil,t6.codigo AS cod_ficha,t4.abrev AS cod_concepto, t3.ubicacion AS cod_ubicacion,t5.fec_diaria as fec_us_ing
FROM (

SELECT @rownum :=0
)r, v_int_usuario AS t1
LEFT JOIN v_int_usuario_clientes AS t2 ON t1.codigo = t2.cod_usuario
RIGHT JOIN v_int_cl_ubic AS t3 ON t2.cod_ubicacion = t3.cod_ubicacion
RIGHT JOIN v_int_cliente AS t4 ON t3.cod_cliente = t4.codigo
RIGHT JOIN v_int_asistencia_apertura AS t5 ON t1.codigo = t5.cod_us_ing
RIGHT JOIN v_int_contratos AS t6 ON t6.codigo = t5.cod_contracto
WHERE t1.login = '$idlogin' and t5.status='T' and t4.codigo='$idcliente'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
   public static function getnominasloginrol($idAsistencia)
    {
        // Consulta de la asistencia diaria

         $idlogin= strstr($idAsistencia, '-', true);
        $idloginaux= strstr($idAsistencia, '-');
        $idrol=substr($idloginaux,1,strlen($idloginaux));
      $fechaservidor=date('Y-m-d');
      $consulta ="SELECT @rownum := @rownum +1 AS idmovil, t6.codigo AS cod_ficha, t4.ubicacion AS cod_concepto, t8.abrev AS cod_ubicacion, t5.fec_diaria AS fec_us_ing
FROM (

SELECT @rownum :=0
)r, v_int_usuario AS t1
LEFT JOIN v_int_usuario_roles AS t2 ON t1.codigo = t2.cod_usuario
RIGHT JOIN v_int_usuario_clientes AS t3 ON t1.codigo = t3.cod_usuario
RIGHT JOIN v_int_cl_ubic AS t4 ON t3.cod_ubicacion = t4.cod_ubicacion
RIGHT JOIN v_int_asistencia_apertura AS t5 ON t1.codigo = t5.cod_us_ing
RIGHT JOIN v_int_contratos AS t6 ON t5.cod_contracto = t6.codigo
RIGHT JOIN v_int_roles AS t7 ON t2.cod_rol = t7.codigo
RIGHT JOIN v_int_cliente AS t8 ON t8.codigo = t4.cod_cliente
WHERE t1.login = '$idlogin'
AND t5.apertura = 'S'
AND t7.codigo = '$idrol'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetchAll(PDO::FETCH_ASSOC);;
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    public static function getById($idAsistencia)
    {
        // Consulta de la asistencia diaria


        $consulta = "SELECT t1.idmovil as idmovil ,
                             CONCAT(t2.cod_ficha,'-',t2.cedula,'-',t2.nombres,' ',t2.apellidos) as cod_ficha,
                             CONCAT(t3.codigo,'-',t3.nombre) as cod_cliente,
                             CONCAT(t4.codigo,'-',t4.descripcion) as cod_ubicacion,
                             t1.fec_us_ing as fec_us_ing,
                             CONCAT(t5.codigo,'-',t5.abrev,'-',t5.descripcion) as cod_concepto
                             FROM asistenciamovil as t1 INNER JOIN ficha as t2 ON t1.cod_ficha=t2.cod_ficha INNER JOIN clientes as t3 ON t1.cod_cliente=t3.codigo INNER JOIN clientes_ubicacion as t4 ON t1.cod_ubicacion=t4.codigo INNER JOIN conceptos as t5 ON t1.cod_concepto=t5.codigo WHERE t1.idmovil = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idMeta      identificador
     * @param $titulo      nuevo titulo
     * @param $descripcion nueva descripcion
     * @param $fechaLim    nueva fecha limite de cumplimiento
     * @param $categoria   nueva categoria
     * @param $prioridad   nueva prioridad
     */
    public static function update(
        $idAsistencia,
        $cod_ficha,
        $cod_cliente,
        $cod_ubicacion,
        $fec_us_ing,
        $cod_concepto
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE asistencia" .
            " SET cod_ficha=?, cod_cliente=?, cod_ubicacion=?, fec_us_ing=?, cod_concepto=? " .
            "WHERE idmovil=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($cod_ficha, $cod_cliente, $cod_ubicacion, $fec_us_ing, $cod_concepto, $idAsistencia));

        return $cmd;
    }

    /**
     * Insertar una nueva meta
     *
     * @param $cod_ficha      codigo del trabajador
     * @param $cod_cliente codigo del cliente
     * @param $    fecha fecha del dia asistencia
     * @param $cod_contracto   codigo de la nomina
     * @param $cod_concepto
     * @return PDOStatement
     */
    public static function insert(
        $cod_ficha,
        $cod_cliente,
        $fec_us_ing,
        $cod_concepto,
        $hora_extra,
        $hora_extra_n,
        $vale,
        $cod_ubicacion,
        $cod_us_ing)
    {
          //obtener idnomina
          $consultanomina="SELECT * from v_int_ficha where cod_ficha='$cod_ficha'";
          try {
            // Preparar sentencia
             $comandosql = Database::getInstance()->getDb()->prepare($consultanomina);
            // Ejecutar sentencia preparada
            $comandosql->execute(array($idasistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $idnomina= $row["cod_contracto"];
            $rol=   $row["cod_rol"];
           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
          // fin nomina
          
          //comienzo de codasapertura
          $consulta="SELECT Min(v_int_asistencia_apertura.fec_diaria) AS fec_diaria, v_int_asistencia_apertura.fec_cierre,
					 v_int_asistencia_apertura.codigo, v_int_contratos.descripcion AS contracto, v_int_roles.descripcion AS rol
				FROM v_int_asistencia_apertura , v_int_asistencia_cierre , v_int_contratos, v_int_roles
			   WHERE v_int_asistencia_apertura.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = '$idnomina'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_asistencia_cierre.cod_contracto
				 AND v_int_asistencia_cierre.cod_rol = '$rol'
				 AND v_int_asistencia_apertura.codigo = v_int_asistencia_cierre.cod_as_apertura
				 AND v_int_asistencia_cierre.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_contratos.codigo
				 AND v_int_roles.codigo = '$rol' ";
          try {
            // Preparar sentencia
             $comandosql = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comandosql->execute(array($idasistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $codaperturahoy= $row["codigo"];

           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
         // Sentencia INSERT
        $comando = "INSERT INTO asistencia(cod_as_apertura,cod_ficha,cod_cliente,fec_us_ing,cod_concepto,hora_extra,hora_extra_n,vale,cod_ubicacion,cod_us_ing) VALUES('$codaperturahoy',?,?,?,?,?,?,?,?,?)";
        // Preparar la sentencia
        try {

        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($cod_ficha,
             $cod_cliente,
             $fec_us_ing,
             $cod_concepto,
             $hora_extra,
             $hora_extra_n,
             $vale,
             $cod_ubicacion,
             $cod_us_ing)
        );

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
     }
      public static function getASISTENCIAESTA($idAsistencia)
    {
        $idficha= strstr($idAsistencia, '-', true);
        $idfichaaux= strstr($idAsistencia, '-');
        $idconcepto=substr($idfichaaux,1,strlen($idfichaaux));
        
         $consultanomina="SELECT * from v_int_ficha where cod_ficha='$idficha'";
          try {
            // Preparar sentencia
             $comandosql = Database::getInstance()->getDb()->prepare($consultanomina);
            // Ejecutar sentencia preparada
            $comandosql->execute(array($idasistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $idnomina= $row["cod_contracto"];
            $rol=   $row["cod_rol"];
           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
          // fin nomina

          //comienzo de codasapertura
          $consultaas="SELECT Min(v_int_asistencia_apertura.fec_diaria) AS fec_diaria, v_int_asistencia_apertura.fec_cierre,
					 v_int_asistencia_apertura.codigo, v_int_contratos.descripcion AS contracto, v_int_roles.descripcion AS rol
				FROM v_int_asistencia_apertura , v_int_asistencia_cierre , v_int_contratos, v_int_roles
			   WHERE v_int_asistencia_apertura.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = '$idnomina'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_asistencia_cierre.cod_contracto
				 AND v_int_asistencia_cierre.cod_rol = '$rol'
				 AND v_int_asistencia_apertura.codigo = v_int_asistencia_cierre.cod_as_apertura
				 AND v_int_asistencia_cierre.`status` = 'T'
				 AND v_int_asistencia_apertura.cod_contracto = v_int_contratos.codigo
				 AND v_int_roles.codigo = '$rol' ";
          try {
            // Preparar sentencia
             $comandosql = Database::getInstance()->getDb()->prepare($consultaas);
            // Ejecutar sentencia preparada
            $comandosql->execute(array($idasistencia));
            $resultado = $comandosql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $row) {

	        $codaperturahoy= $row["codigo"];
            $fechadiaria=   $row["fec_diaria"];
           }

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }


        $consulta = "SELECT t1.cod_us_ing as idmovil,
                            t1.cod_ficha,
                            t1.cod_cliente,
                            CONCAT(t3.apellidos,'-',t3.nombres) as cod_ubicacion,
                           t1.fec_diaria as fec_us_ing,
                           CONCAT(t1.cod_concepto,'-',t4.abrev) as cod_concepto FROM v_int_asistencia as t1 INNER JOIN v_int_usuario AS t2 ON t1.cod_us_ing = t2.codigo AND t1.cod_ficha='$idficha' and t1.fec_diaria='$fechadiaria' INNER JOIN v_int_ficha as t3 ON t1.cod_ficha=t3.cod_ficha INNER JOIN v_int_conceptos as t4 ON t1.cod_concepto=t4.codigo where t1.cod_concepto='$idconcepto' order by t3.apellidos ASC";

      // $consulta = "Select cod_ficha,fec_diaria FROM v_int_asistencia where fec_diaria='$fechahoy' and cod_ficha=?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $e->getMessage();
            return $e;
        }
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idAsistencia identificador de la asistencia
     * @return bool Respuesta de la eliminación
     */
          public static function borrarasistencia($idAsistencia)
    {
        $idficha= strstr($idAsistencia, '-', true);
        $idfichaaux= strstr($idAsistencia, '-');
        $idconcepto=substr($idfichaaux,1,strlen($idfichaaux));

        $consulta = "DELETE FROM asistencia where cod_ficha='$idficha' and cod_concepto='$idconcepto'";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAsistencia));

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }
    public static function delete($idmovil)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM asistenciamovil WHERE idmovil=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idmovil));
    }
     public static function verificarlogin($clave)
    {
        // Sentencia verificar clave
             $clave=md5($clave);
             $comando = "SELECT * FROM v_int_usuario WHERE pass='$clave'";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($clave));
    }
}

?>
