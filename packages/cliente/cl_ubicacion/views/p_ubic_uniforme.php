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
		var cod_cargo = document.getElementById("codigo_cargo"+auto+"").value;
        var errorMessage = 'Debe Ingresar minimo 1 producto ';
        var campo01 = 0;
        if (!cod_sub_linea) {
            campo01++;
		}
		if (!cod_cargo) {
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
            ajax.send("cod_sub_linea=" + cod_sub_linea + "&codigo=" + codigo + "&cod_cargo="+ cod_cargo + "");
        } else {
            alert(errorMessage);
        }
    }

	function ValidarSubmitUniforme(auto, metodo) {
		var cod_ubic = document.getElementById("codigo_ubic").value;
		var usuario = document.getElementById("usuario").value;
		var cod_sub_linea = document.getElementById("stdIDuniforme" + auto + "").value;
		var cod_cargo = document.getElementById("codigo_cargo" + auto + "").value;
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
						$("#codigo_cargo").val("");
						$("#cantidad_uniforme").val(0)
					}
				}else{
					toastr.success('Actualizado con exito.');
				}
				//window.location.href=""+href+"";
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("codigo=" + cod_ubic + "&cod_cargo=" + cod_cargo + "&cod_sub_linea=" + cod_sub_linea + "&cantidad=" + cantidad_uniforme  + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
	}

	function Borrar(auto, metodo) {
		if (confirm("� Esta Seguro Eliminar Este Registro")) {
			var cod_ubic = document.getElementById("codigo_ubic").value;
			var cod_cargo = document.getElementById("codigo_cargo" + auto + "").value;
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
					toastr.success('Actualizado con exito.');
					//window.location.href=""+href+"";
				}
			}
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			ajax.send("codigo=" + cod_ubic + "&cod_sub_linea=" + cod_sub_linea + "&cod_cargo="+ cod_cargo + "&cantidad=" + cantidad_uniforme + "&usuario=" + usuario + "&href=''&metodo=" + metodo + "&proced=" + proced + "");
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
			<th width="40%" class="etiqueta">Sub Linea
            <input type="hidden" name="producto" id="stdIDuniforme" value=""/></th>
			<th width="30%" class="etiqueta">Cargo</th>
            <th width="15%" class="etiqueta">Cantidad</th>
			<th width="15%"><img src="imagenes/loading2.gif" alt="Agregar Registro" width="40" height="40" title="Agregar Registro" border="null" class="imgLink" /></th>
		</tr>
		<tr class="fondo02">
        <td>       
        <input type="text" id="codigo_sub_linea_uniforme" value="" placeholder="Sub Linea de Uniforme" required style="width:250px"/>
      </td>
		<td>
		<select style="width:250px" id="codigo_cargo" required>
		<option value="">Seleccione</option>
		<?php
			$sqlcargo =	"SELECT codigo, descripcion FROM cargos WHERE `status` = 'T';";
			$querycargo = $bd->consultar($sqlcargo);
			while ($datos = $bd->obtener_fila($querycargo, 0)) {
				echo '<option value="' . $datos[0] . '">' . $datos[1] . '</option>';
			} 
		?>
		</select></td>
      <td>
       <input type="number" id="cantidad_uniforme" style="width:50px" value="1" min="0"  required placeholder="">
		</td>	
		<td><span class="art-button-wrapper">
					<span class="art-button-l"> </span>
					<span class="art-button-r"> </span>
					<input type="button" name="submit" id="submit" value="Agregar" class="readon art-button" onclick="agregarProductoUniforme('', 'agregar')" />
				</span></td>
		</tr>
		</table>
		<table id="Contenedor04" width="60%" border="0" align="center">
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

var cod_ubic_base = document.getElementById("codigo_ubic").value;
ActualizarDetUniforme(cod_ubic_base);
  </script>