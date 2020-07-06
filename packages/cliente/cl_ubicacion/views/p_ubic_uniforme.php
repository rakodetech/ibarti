<?php
$sql01 =	"SELECT clientes_ub_uniforme.cod_sub_linea, prod_sub_lineas.descripcion sub_linea, clientes_ub_uniforme.cantidad
                   FROM clientes_ub_uniforme, prod_sub_lineas
                  WHERE clientes_ub_uniforme.cod_sub_linea = prod_sub_lineas.codigo
				  AND clientes_ub_uniforme.cod_cl_ubicacion = '$codigo'";
?>
<script language="javascript">
    function agregarProductoUniforme(auto, metodo) {
        var cod_sub_linea = document.getElementById("stdIDuniforme" + auto + "").value;
		var codigo = document.getElementById("codigo_ubic").value;
        var errorMessage = 'Debe Ingresar minimo 1 producto ';
        var campo01 = 0;
        if (!cod_sub_linea) {
            campo01++;
		}
		if (cantidad_uniforme == 0) {
            campo01++;
        }
        if (campo01 == 0) {
            //var href = "inicio.php?area=maestros/Cons_Servicio_Tipo";
            var valor = "scripts/sc_cl_ubic_validar_uniforme.php";
            ajax = nuevoAjax();
            ajax.open("POST", valor, true);
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4) {
                    // document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
                    //window.location.href=""+href+"";
                    if (ajax.responseText == 0) {
                        ValidarSubmitUniforme(auto, metodo);
                    } else {
                        alert("Ya Existe este Registro (" + cod_sub_linea + ")");
                    }
                }
            }
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("cod_sub_linea=" + cod_sub_linea + "&codigo=" + codigo + "");
        } else {
            alert(errorMessage);
        }
    }

	function ValidarSubmitUniforme(auto, metodo) {
		var cod_ubic = document.getElementById("codigo_ubic").value;
		var usuario = document.getElementById("usuario").value;
		var cod_sub_linea = document.getElementById("stdIDuniforme" + auto + "").value;
		var cantidad_uniforme = document.getElementById("cantidad_uniforme" + auto + "").value;
		
		var valor = "scripts/sc_cl_ubic_uniforme.php";
		var proced = "p_cl_ubic_uniforme";
		ajax = nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
				if ((metodo == "agregar") || (metodo == "eliminar")) {
					ActualizarDetUniforme(cod_ubic);
					if(metodo == "agregar"){
						$("#stdIDuniforme").val("");
						$("#codigo_sub_linea_uniforme").val("");
						$("#cantidad_uniforme").val(0)
					}
				}else{
					toastr.success('Actualizado con exito.');
				}
				//window.location.href=""+href+"";
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo=" + cod_ubic + "&cod_sub_linea=" + cod_sub_linea + "&cantidad=" + cantidad_uniforme  + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
	}

	function Borrar(auto, metodo) {
		if (confirm("� Esta Seguro Eliminar Este Registro")) {
			var cod_ubic = document.getElementById("codigo_ubic").value;
            var cod_sub_linea = document.getElementById("stdIDuniforme" + auto + "").value;
			var cantidad_uniforme = document.getElementById("cantidad_uniforme" + auto + "").value;
			var ususario = "";

			var valor = "scripts/sc_cl_ubic_uniforme.php";
			var proced = "p_cl_ubic_uniforme";

			ajax = nuevoAjax();
			ajax.open("POST", valor, true);
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4) {
					document.getElementById("Cont_mensaje").innerHTML = ajax.responseText;
					ActualizarDetUniforme(cod_ubic);
					//window.location.href=""+href+"";
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo=" + cod_ubic + "&cod_sub_linea=" + cod_sub_linea + "&cantidad=" + cantidad_uniforme + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
		} else {
			alert(errorMessage);
		}
	}

	function ActualizarDetUniforme(codigo) {
		var valor = "ajax/Add_cl_ubic_uniforme.php";
		ajax = nuevoAjax();
		ajax.open("POST", valor, true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4) {
				toastr.success('Actualizado con exito.');
				document.getElementById("Contenedor04").innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo=" + codigo + "");
	}
</script>
<div align="center" class="etiqueta_title"> UNIFORME </div>
<hr />
<div id="Cont_mensaje" class="mensaje"></div>
<div>
     <table width="60%" border="0" align="center">
		<tr class="fondo01">
			<!-- <th width="20%" style="display:none" class="etiqueta">Codigo Ubicacion</th> -->
			<th width="70%" class="etiqueta">Sub Linea
            <input type="hidden" name="producto" id="stdIDuniforme" value=""/></th>
            <th width="18%" class="etiqueta">Cantidad</th>
			<th width="12%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" class="imgLink" /></th>
		</tr>
		<tr class="fondo02">
        <td>       
        <input type="text" id="codigo_sub_linea_uniforme" value="" placeholder="Ingrese Dato del <?php echo $leng['producto'];?>" required style="width:450px"/>
      </td>
      <td>
       <input type="number" id="cantidad_uniforme" style="width:100px" value="1" min="0"  required placeholder="">
		</td>	
		<td><span class="art-button-wrapper">
					<span class="art-button-l"> </span>
					<span class="art-button-r"> </span>
					<input type="button" name="submit" id="submit" value="Agregar" class="readon art-button" onclick="agregarProductoUniforme('', 'agregar')" />
				</span></td>
		</tr>
		</table>
		<table id="Contenedor04" width="60%" border="0" align="center">
		<tr>
			<td colspan="5" class="etiqueta_title">Listado</td>
		</tr>
		<?php
		$query = $bd->consultar($sql01);
		$i = 0;
		$valor = 0;
		while ($datos = $bd->obtener_fila($query, 0)) {
			$i++;
			if ($valor == 0) {
				$fondo = 'fondo01';
				$valor = 1;
			} else {
				$fondo = 'fonddo02';
				$valor = 0;
			}
			$modificar = 	 "'" . $i . "', 'modificar'";
			$borrar    = 	 "'" . $i . "', 'eliminar' ";
			echo '<tr class="' . $fondo . '">
				  <td>     
                  <input type="text" id="codigo_sub_linea_uniforme'.$i.'" value="'.$datos['sub_linea'].'" disabled  style="width:450px"/>
                  <input type="hidden" name="trabajador" id="stdIDuniforme'.$i.'" value="'.$datos['cod_sub_linea'].'"/>
                </td>
                <td>
                 <input type="number" id="cantidad_uniforme'.$i.'" style="width:100px"  value="'.$datos['cantidad'].'" min="1">
			   </td>
			   <td align="center"><img src="imagenes/actualizar.bmp" alt="Actualizar" title="Actualizar Registro" border="null" width="20px" height="20px" class="imgLink" onclick="ValidarSubmitUniforme('.$modificar.')" />&nbsp;
		  <img src="imagenes/borrar.bmp" alt="Detalle" title="Borrar Registro" width="25" height="25" border="null"
			   onclick="Borrar(' . $borrar . ')" class="imgLink" />
		  </td>
	</tr>';
		} ?>
	</table>
</div>
<div align="center">
	<input name="metodo" type="hidden" value="<?php echo $metodo; ?>" />
	<input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />

	<input type="hidden" id="cod_ubic_uniforme" name="codigo" value="<?php echo $codigo; ?>" />
	<input type="hidden" id="i" value="<?php echo $i; ?>" />
</div>
<br />
<br />

<script language="JavaScript" type="text/javascript">
new autoComplete({
	data: {
		src: async function () {
		// Loading placeholder text
		const query = document.querySelector("#codigo_sub_linea_uniforme").value;
		// Fetch External Data Source
		const source = await fetch("packages/cliente/cl_ubicacion/views/uniformeGET.php?q="+query+"");
		const data = await source.json();
		// Returns Fetched data
		return data;
		},
		key: ["descripcion"],
	},
	sort: function (a, b) {
		if (a.match < b.match) {
		return -1;
		}
		if (a.match > b.match) {
		return 1;
		}
		return 0;
	},
	query: {
		manipulate: function (query) {
		return query.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
		},
	},
	trigger: {
		event: ["input","focusin", "focusout"],
		condition: function (query) {
		return !!query.replace(/ /g, "").length && query !== "hamburger";
		},
	},
	placeHolder: "Producto",
	selector: "#codigo_sub_linea_uniforme",
	debounce: 0,
	searchEngine: "strict",
	highlight: true,
	maxResults: 10,
	resultsList: {
		render: true,
		container: function (source) {
		source.setAttribute("id", "autoComplete_list");
		},
		element: "ul",
		destination: document.querySelector("#codigo_sub_linea_uniforme"),
		position: "afterend",
	},
	resultItem: {
		content: function (data, source) {
			source.innerHTML = data.match;
		},
		element: "li",
	},
	noResults: function () {
		
	},
	onSelection: function (feedback) {
		document.querySelector("#codigo_sub_linea_uniforme").blur();
		const selection = feedback.selection.value.descripcion;
		// Clear Input
		document.querySelector("#codigo_sub_linea_uniforme").value = "";
		// Change placeholder with the selected value
		document.querySelector("#codigo_sub_linea_uniforme").setAttribute("placeholder", selection);
		$("#stdIDuniforme").val(feedback.selection.value.codigo);
	},
}); 

  </script>