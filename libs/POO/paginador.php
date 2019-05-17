<?php
class paginador
{
    //constantes
    var $CONST_CANTMOSTRAR = 10;
    var $CONST_CANTNUMEROS = 10;
    
    //variables
    var $cantMostrar;
    var $cantNumeros;
    var $bd;
    var $fechas;
    var $sql;
    var $pag;
	var $orden;
    
    function paginador($bd,$sql,$pag,$orden){
        /*
        @Descricion: Contructor de la clase
        
        @Param $bd: objeto de conexion de la base de datos
        
        @Param $sql: Sentencia sql para consultar la base y obtener el listad y el paginado
        
        @Param $pag: Pagina del paginado en donde estoy
        
        */
        $this->cantMostrar = $this->CONST_CANTMOSTRAR;
        $this->cantNumeros = $this->CONST_CANTNUMEROS;
        $this->bd = $bd;
        $this->flechas = array();
        $this->sql = $sql;
        $this->pag = $pag;
		$this->orden = $orden;
        $this->flechas();
        $this->paginarSQL();
    }
    
    function paginarSQL(){
        /*
        @Descripcion: Me devuelve la sentencia sql lista para mostrar el listado
        */
        $pag = $this->pag*$this->cantMostrar;
		$orden = $this->orden;
        $sql = $this->sql." ORDER BY ".$orden." LIMIT ".$pag.",".$this->cantMostrar;
        $this->sql = $sql;
    }
    
    function cantNumerosIntermedios($cantPaginas){
        /*
        @Descripcion: verifico la cantidad de numeros intermedios
        */
        $this->cantNumeros = ($this->cantNumeros <= $cantPaginas)?$this->cantNumeros:$cantPaginas;
    }
    
    function flechas(){
        /*
        @Descripcion: Metodo que se encarga de armar el paginado (flechitas)
        */
    
        //obtengo la cantidad de registros
        $cantRegistros = $this->cantDeRegistros();

        //obtengo la cantidad de paginas
        $cantPaginas = $this->cantidadPaginas($cantRegistros);
        
        //verifico la cantidad de numeros intermedios
        $this->cantNumerosIntermedios($cantPaginas);
        
        //obtengo la url de los links
        $url = $this->obtenerUrl();
        
        //PRIMERO
    
        if($this->pag!=0){
            $flechas[0] = '<a href="'.$url.'&pag=0'.'">|<</a>&nbsp;';
        }else{
            $flechas[0] = "|<&nbsp;";
        }
        
        //ANTERIOR 10
        $pagant = $this->pag-10;
        $pagant = ($pagant<0)?0:$pagant;
        if($this->pag!=0){
            $flechas[1]= '<a href="'.$url.'&pag='.$pagant.'"><<</a>&nbsp;';
        }else{
            $flechas[1]= "<<&nbsp;";
        }
        
        //ANTERIOR
        $pagant = $this->pag-1;
        $pagant = ($pagant<0)?0:$pagant;
        if($this->pag!=0){
            $flechas[2]= '<a href="'.$url.'&pag='.$pagant.'"><</a>&nbsp;';
        }else{
            $flechas[2]= "<&nbsp;";
        }
        
        //INTERMEDIOS

        $fechas[3] = array();
        
        if($this->pag == 0)
            $primero = 0;
        else if($this->pag < ceil($this->cantNumeros/2))
            $primero = 0;
        else
            $primero = ($this->pag-floor($this->cantNumeros/2));
        
        //$ultimo = $primero + $cantIntemedios -1;
        
        $ultimo = (($primero + $this->cantNumeros)>$cantPaginas)?$cantPaginas:($primero + $this->cantNumeros);
        
        if($primero > ($cantPaginas - $this->cantNumeros)){
            $primero = ($cantPaginas - $this->cantNumeros);
            $ultimo = $cantPaginas;
        }
        
        
        $j=0;
        for($i=$primero; $i<=$ultimo; $i++){
            if($i == $this->pag){
                $flechas[3][$j] = ($i+1)."&nbsp;";;
            }else{
                $flechas[3][$j] = '<a href="'.$url.'&pag='.$i.'"';
                $flechas[3][$j] .= ">".($i+1)."</a>&nbsp;";
            }
            $j++;
        }
        if(!$j)
            $flechas[3] = "0";
        
        //SIGUIENTE   
		
        $pagprox = $this->pag+1;
        $pagprox = ($pagprox>$cantPaginas)?$cantPaginas:$pagprox;
        if($this->pag!=$cantPaginas){
            $flechas[4] = '<a href="'.$url.'&pag='.$pagprox.'">></a>&nbsp;';
        }else{
            $flechas[4] = ">&nbsp;";
        }
        
        //SIGUIENTE 10
        $pagprox = $this->pag+10;
        $pagprox = ($pagprox>$cantPaginas)?$cantPaginas:$pagprox;
        if($this->pag!=$cantPaginas) {
            $flechas[5] = '<a href="'.$url.'&pag='.$pagprox.'">>></a>&nbsp;';
        }else{
            $flechas[5] = ">>&nbsp;";
        }
        
        //ULTIMA
        $pagprox = $cantPaginas;
        if($this->pag!=$cantPaginas){
            $flechas[6] = '<a href="'.$url.'&pag='.$pagprox.'">>|</a>&nbsp;';
        }else{
            $flechas[6] = ">|&nbsp;";
        }
        
        $this->flechas = $flechas;
    }
    
    function obtenerUrl(){
        /*
        @Descripcion: Obtengo la url y el query string asi puedo ir a otra pag del paginado sin perder nada
                    es muy util si estoy en un buscador
        */
        $pagina = $_SERVER["PHP_SELF"];
        $query = $_SERVER["QUERY_STRING"];
        
        
        if(strpos($query,"&pag") !== false){
            $posPag = strpos($query,"&pag");
        }else if(strpos($query,"pag") !== false){
            $posPag = strpos($query,"pag");
        }else{
            $posPag = false;
        }
        
        if($posPag !==false){
            $primeraParte = substr($query,0,$posPag);
            $segundaParte = strstr(substr($query,$posPag+1,strlen($query)),'&');
            if($primeraParte == "")
                $query = $this->verif($segundaParte);
            else if($segundaParte == "")
                $query = $this->verif($primeraParte);
            else
                $query = $this->verif($segundaParte)."&".$this->verif($primeraParte);
        }
        
        return $pagina."?".$query;
    }
    
    
    function cantDeRegistros(){
        /*
        @Descripcion: Metodo que devuelve el total de registros q hay en la base de datos
        */
        $pos = strpos($this->sql, " from ");
        if(!$pos) $pos = strpos($this->sql, " FROM ");
        $sql_aux = substr($this->sql,$pos,strlen($this->sql));
        $sql = "select count(*) cant ".$sql_aux;
        $r = $this->bd->bbdd_query($sql);
        list($total) = $this->bd->bbdd_fetch($r);
        return $total;
    }
    
    function cantidadPaginas($cantRegistros){
        /*
        @Descripcion: Metodo q me devuelve la cantidad de paginas del paginado
        */
        $cantPaginas = ceil($cantRegistros/$this->cantMostrar);
        $cantPaginas -= 1;
        
        return $cantPaginas;
    }
    
    function verif($query){
        if(substr($query,0,1)=="&")
            return substr($query,1,strlen($query));
        else if(substr($query,-1,1)=="&")
            return substr($query,0,strlen($query)-1);
        else
            return $query;
    }
    
    function mostrarFlechas(){
        /*
        @Descripcion: metodo q me devuelve las flechitas del paginado
        */
        $cant = count($this->flechas);
        $flechas = "";
        for($i=0; $i<$cant; $i++){
            if($i!=3)
                $flechas .= $this->flechas[$i];
            else{
                for($j=0; $j<count($this->flechas[$i]); $j++){
                    $flechas .= $this->flechas[$i][$j];
                }
            }
        }
        return $flechas;
    }
	
	
    
    function mostrarListado($campos, $hrefAgregar, $hrefModificar, $hrefEliminar){
        /*
        @Descripcion: Metodo que muestra el contenido en la pagina
		*/
        
		$pag = $this->pag;
		$orden = $this->orden;
			
		if(isset($_GET['area'])){
			$url = $_SERVER["PHP_SELF"].'?area='.$_GET['area'].'&';
		}else{
			$url = $_SERVER["PHP_SELF"].'?';
		}
	
        
		$r = $this->bd->bbdd_query($this->sql);
		if($this->bd->bbdd_num($r)){?>

<table border="1">
  <tr>
    <?php
			
			//muestro las etiquetas del listado creando sus respectivos link que indican el orden 
			foreach($campos as $etiquetas => $muestraCampos){
            	echo '<td height="30px" class="Estilo1" ><a href="'.$url.'orden='.$campos[$etiquetas].'&pag='.$pag.'" class"etiqueta">'.$etiquetas.'</a></td>';
			}
			                  // ICONO AGREGAR O BUSCAR //
		/*	echo '<td width="18%" align="center" valign="middle"><a href="'.$hrefAgregar.'"><img src="../images/agregar.gif" alt="Agregar"  border="null" title="Agregar Registro" />  </a>
				  <a href="'.$hrefBuscar.'"><img src="../images/buscar.gif" alt="Buscar"  border="null" title="Buscar Registro" />
			</td>
			
			</tr>';*/
		
			//muestro los datos del listado
			echo '<tr>';
            while($row = $this->bd->bbdd_fetch($r)){
				foreach($campos as $etiquetas => $muestraCampos){	
			?>
			
	 <td>  <?php /* if($muestraCampos == status_id ){
									 $statu = $row[$muestraCampos];
									 if ($statu == 0){
									  echo 'Inactivo'; //si viene la variables status 
									 }else{ 
									  echo 'Activo';
									 } 	
								}else{
									echo $row[$muestraCampos];
								}  */  echo $row[$muestraCampos];           ?>
    </td>
    <?php }
				// ICONO DE MODIFICAR O DE ELIMINAR  //
								
			/*	echo '<td align="center" valign="middle"><a href="'.$hrefModificar.'&campoClave='.$row[0].'"> <img src="../images/modificar.gif" alt="Modificar" border="null" title="Modificar Registro" /> </a>  <a href="'.$hrefEliminar.'?campoClave='.$row[0].'&archivo=eliminar'.'"> <img src="../images/borrar.gif" alt="Eliminar"  border="null" title=" Eliminar Registro"/> </a></td>'; */
				
			echo '</tr>';
			}
			?>
</table>
<?php }
    }
}
?>
