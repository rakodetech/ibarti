<?php
 class bbdd
 {
     var $conn;
     /*
     constructor: bbdd
         Constructor de la clase.
         Realiza la conección a la base de datos
     */
     function bbdd($bd){
         
            //$conex=mysql_connect("localhost","root","3$12root200z");
		      $conex=mysql_connect("localhost","root","4321");
        
		 if($conex){
             if(!mysql_select_db($bd, $conex))
                 echo "no selecciono la bd";
         }else
             echo "no se conecto";
         $this->conn = $conex;
         
     }
     
     /*
     Method: bbdd_fetch
         Devuelve la línea donde esta apuntando el puntero del recordset
     
     Parameteres:
         $r - recordset
     
     Returns:
         Devuelve una línea del recordset o null si ya se llego al final del array
     */
     function bbdd_fetch(&$r){
         $row = mysql_fetch_array($r);
         return $row;
     }
     
     /*
     Method: bbdd_num
         Devuelve la cantidad afectadas por una sentancia SELECT 
     
     Parameteres:
         $r - recordset
     */
     function bbdd_num(&$r){
         $cant = mysql_num_rows($r);
         return $cant;
     }
     
     function bbdd_qnum(&$sql){
         $r = $this->bbdd_query($sql);
         $cant = mysql_num_rows($r);
         return $cant;
     }
     
     /*
     Method: bbdd_id
         Devuelve el identificador generado en la última llamada a INSERT
     */
     function bbdd_id(){
         $id = mysql_insert_id($this->conn);
         return $id;
     }
     
     /*
     Method: bbdd_desc
         Desconecto la bd
     */
     function bbdd_desc(){
         mysql_close();
     }
     
     /*
     Method: bbdd_seguridad
         Aplica seguridad para el sqlinjection
     
     Parameteres:
         $tipo - si los datos son por GET o POST
         $valor - solo se aplica la seguridad a este dato
     
     Returns:
         Datos validados
     */
     function bbdd_seguridad($tipo,$valor=""){
         if($valor==""){
             $aux = array();
             //verifico si es get o post
             $valores = ($tipo=="_GET")?$_GET:$_POST;
             foreach($valores as $clave=>$valor){
                 if(is_array($valores[$clave]))
                     $aux[$clave] = array_map("mysql_real_escape_string", $valores[$clave]);
                 else
                     $aux[$clave] =  mysql_real_escape_string(stripslashes($valor));
             }
             
             if($tipo=="_GET")
                 $_GET = $aux;
             elseif($tipo=="_POST")
                 $_POST = $aux;
             
         }else{
             if($tipo=="_GET")
                 $_GET[$valor] = mysql_real_escape_string(stripslashes($_GET[$valor]));
             elseif($tipo=="_POST")
                 $_POST[$valor] = mysql_real_escape_string(stripslashes($_POST[$valor]));
             else
                 return mysql_real_escape_string(stripslashes($valor));
         }
     }
     
     /*
     Method: bbdd_afectadas
         Devuelve la cantidad de filas afectadas en la última sentencia INSERT, UPDATE o DELETE
     */
     function bbdd_afectadas(){
         return mysql_affected_rows($this->conn);
     }
     
	 /////////////////////////////////
	 
     function bbdd_errno(){
         $error = mysql_errno($this->conn);
         return $error;
     }
     
     function bbdd_error(){
         $error = mysql_error($this->conn);
         return $error;
     }
	 
	 //////////////////////////////////////////
     
     /*
     Method: bbdd_query
         Realiza una consulta a la base de datos.
         Si posee 2 o 3 parametros tmb redirecciona a la pagina indicada en estos parámetros
 
     Parameteres:
         1er (obligatorio) - Sentencia SQL a ser ejectada
         2do (opcional) - Archivo a donde se va a redireccionar
         3er (opcional) - Array asociativo que contiene el queryString de la url a redireccionarse
 
     Example:
         (start code)
         $sql = "INSERT INTO usuarios (nombre,apellido) VALUES ('fede','fede')";
         $bd->bbdd_query($sql);   //inserto los datos en la base
         (end)
     
     Example:
         (start code)
         $sql = "INSERT INTO usuarios (nombre,apellido) VALUES ('fede','fede')";
         $bd->bbdd_query($sql,"usuariosListar.php",array("id"=>1)); //inserto los datos en la bd y redirecciono a usuariosListar.php?id=1
         (end)
     
     note:
         Si la consulta genera un error (a nivel de mysql) llama al metodo debugDB() y muestra el error en pantalla
         
     Returns:
         Recordset con los datos de la consulta
     */
     function bbdd_query(){
         //realizo la consulta
         $sql = func_get_arg(0);
         $r = mysql_query($sql, $this->conn);
         
         //verifico si hay errores
         if($this->bbdd_errno()){
             //hay error
             return $this->debugDB();
         }else{
             //no hay error
             if(func_num_args() >= 2){
                 $url = func_get_arg(1);
                 if(func_num_args() == 3){
                     $query = func_get_arg(2);
                     url::redireccionar($url,$query);
                 }else
                     url::redireccionar($url);
             }
         }
         return $r;
     }
     
     function debugDB(){
         $errores = array(
                         1062 => array(
                                     "/Duplicate entry ('.*') for key [0-9]/",
                                     'El valor \1 esta siendo utilizado por otro registro <br/>'
                                     ),
                         1216 => array(
                                     "/Cannot add or update a child row: a foreign key constraint fails/",
                                     "No se pudo agregar/actualizar hay datos que referencian a otras tablas y no existen<br/>"
                                     ),
                         1217 => array(
                                     "/Cannot delete or update a parent row: a foreign key constraint fails/",
                                     "No se puede borrar/actualzar este registro porque esta relacionado con otros conceptos<br/>"
                                     )
                         );
   //      $texto = preg_replace($errores[$this->bbdd_errno()][0], $errores[$this->bbdd_errno()][1], $this->bbdd_error());
         if($texto == ""){
             $texto = $this->bbdd_error();
          }   
	 //    errores::errorForm($texto,"Error al cargar en la base de datos");
         return false;
     }  
     
     function bbdd_seek($recordset,$fila=0){
         mysql_data_seek($recordset,$fila);
     }
     
     function bbdd_seek_reset($recordset){
         $this->bbdd_seek($recordset,0);
     }
     
     function bbdd_num_fields($r){
         return mysql_num_fields($r);
     }
 }
 
 
 //////////////////////////
 //
 // IMPORTANTE: Se debe colocar el nombre de la base de datos al momento de instanciar
 //
 /////////////////////////
 
  //$bd = new bbdd(cchica);
 ?>