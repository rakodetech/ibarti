/////////////////////////////////////////////////////////////////////////////////////////////////////////
// FUNCIONES PARA CREAR EL CALENDARIO Y LA VENTANA DE SELECCION DE FECHAS
// Autor: Oscar Hernandez Caballero
// Ultima revision: Febrero de 2010
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// COMO USAR ESTAS FUNCIONES:
//
//   1. incluir en el <HEAD> el código
//
//			<link rel="stylesheet" href="./css/calendario.css" type="text/css">
//			<script type="text/javascript" src="./js/calendario.js"></script>
//			<script type="text/javascript" src="./js/fechas.js"></script>//
//
//
//   2. incluir despues de <BODY> este codigo
//
//			<!--////CAPA DE VENTANA DE SELECCION DE FECHAS---> 
//			<div id="ventanaSeleccionFechas"></div>
//			<!--////CAPA DE CALENDARIO ---> 
//			<DIV id="ventanaCalendario"></DIV>
//
//
//   3. Para mostrar la ventana de seleccion de fechas desde un input text con id="fecha_ejemplo" poner el código....
//
//   		<input type="text" id="fecha_ejemplo" size="20" onclick="javascript:showVentanaSeleccionFechas('fecha_ejemplo', 'Fecha de ejemplo');">
//
//
//   4. Para mostrar un calendario desde un input text con id="fecha_ejemplo" de un formulario "formEjemplo" poner el código....
//
//			<input type="text" id="fecha_ejemplo" size="10" onclick="javascript:muestraCalendario('formEjemplo', 'fecha_ejemplo');">&nbsp;
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	/////////////////////////////////////////////// 
	// variables de las imagenes del calendario
	//////////////////////////////////////////////
	calFleIzq=new Image
	calFleIzq.src="imagenes/calFleIzq.gif"
	calFleDer=new Image
	calFleDer.src="imagenes/calFleDer.gif"
	calCerrar=new Image
	calCerrar.src="imagenes/calCerrar.gif"
    //////////////////////////////////////////////

	
	
    ///////////////////////////////////////////////////// 
	// funcion que recupera las coordenadas del raton
	///////////////////////////////////////////////////
	var posX,posY;
	document.onmousemove = setMouseCoords;
	
	function setMouseCoords(e) {
		if(document.all) {
			posX = window.event.clientX;
			posY = window.event.clientY;
		} else {
			posX = e.pageX;
			posY = e.pageY;
		}
	}
	///////////////////////////////////////////////////




	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// VALIDACION DE LA VENTANA DE SELECCION DE FECHAS /////////////////////////////////////////////////
	// Estado del codigo: ESTABLE
	///////////////////////////////////////////////////////////////////////////////////////////////////
	function Aceptar(camposeleccion) {
		var strFecha;
		var fecha_desde;
		var fecha_hasta;
		
		// comprobamos que las fechas sean correctas, y fechaDesde sea <= a la fechaHasta
		fecha_desde = document.formSeleccionFechas.fechaDesde.value;
		fecha_hasta = document.formSeleccionFechas.fechaHasta.value;
		
		if (!chkFechaOk(fecha_desde) && fecha_desde != '') {
			alert ("La fecha Desde es incorrecta");
			return false;
		}
		
		if (!chkFechaOk(fecha_hasta) && fecha_hasta != '') {
			alert ("La fecha Hasta es incorrecta");
			return false;
		}
		
		if (chkEsMenor(fecha_hasta, fecha_desde)) {
			alert("La fecha Hasta no puede ser menor que la fecha Desde");
			return false;
		}
		
		if (fecha_desde == '' && fecha_hasta == '' && !(document.formSeleccionFechas.vacio.checked)) {
			alert("Elija al menos una fecha o vacio");
			return false;
		}
		
		if ( (fecha_desde != '' || fecha_hasta != '') && (document.formSeleccionFechas.vacio.checked)) {
			alert("Si selecciona una fecha no puede seleccionar que el campo este vacio");
			return false;
		}
		
		// si todo ha ido bien...
			hideVentanaSeleccionFechas();
			
			// damos formato a la visualización de la fecha
			if (fecha_desde == fecha_hasta) {
				strFecha = '=' + fecha_desde;
			}
			if (fecha_desde == '' && fecha_hasta != '') {
				strFecha = '<=' + fecha_hasta;
			}
			if (fecha_desde != '' && fecha_hasta == '') {
				strFecha = '>=' + fecha_desde;
			}
			if (fecha_desde == '' && fecha_hasta == '') {
				strFecha = '';
			}
			if (chkEsMenor(fecha_desde, fecha_hasta)) {
				strFecha = '(' + fecha_desde + ',' + fecha_hasta + ')';
			}	
			if (document.formSeleccionFechas.omitir.checked) {
			    strFecha = 'NO' + strFecha;
			}
			if (document.formSeleccionFechas.vacio.checked) {
			    strFecha = strFecha + '=';
			}
			
		    // asignamos la cadena construida al input text de la fecha
			eval('document.getElementById("'+camposeleccion+'").value="'+strFecha+'";');
			//eval('document.' + formularioseleccion + '.' + camposeleccion + '.value=strFecha');
	}
	////////////////////////////////////////////////////////////////////////////////////////////////




	// /////////////////////////////////////////////////////////////////////////////////////////////
    // FUNCION QUE MUESTRA LA VENTANA DE SELECCION DE FECHAS
    // Estado del codigo: ESTABLE
    // /////////////////////////////////////////////////////////////////////////////////////////////
	function showVentanaSeleccionFechas(campo, textoCampo) {
		var VentanaHTML = '';	
	    VarCerrar="hideVentanaSeleccionFechas();";
	    VentanaHTML = VentanaHTML + '<form name="formSeleccionFechas" id="formSeleccionFechas">';
	    VentanaHTML = VentanaHTML + '<table border="0" width="200">';
	    VentanaHTML = VentanaHTML +   '<tr>';
	    VentanaHTML = VentanaHTML +     '<td bgcolor="#000000">';	
	    VentanaHTML = VentanaHTML +       '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="blanco">';
	    VentanaHTML = VentanaHTML +         '<tr>';
	    VentanaHTML = VentanaHTML +           '<td>';	
	    VentanaHTML = VentanaHTML +             '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="blanco">';
	    VentanaHTML = VentanaHTML +               '<tr class=azulclaro2>';
	    VentanaHTML = VentanaHTML +                 '<td width="6"></td>';
	    VentanaHTML = VentanaHTML +                 '<td class="txtnegro" align=left>' + textoCampo + '</td>';
	    VentanaHTML = VentanaHTML +                 '<td class="txtnegro" align=right>';
	    VentanaHTML = VentanaHTML +                   '<a href="javascript:'+VarCerrar+'"><img name="calCerrar" src="'+calCerrar.src+'" border="0" vspace="2" title="cerrar"></a></td>';
		VentanaHTML = VentanaHTML +                 '<td width="5"></td>';
	    VentanaHTML = VentanaHTML +               '</tr>';
	    VentanaHTML = VentanaHTML +               '<tr>';
	    VentanaHTML = VentanaHTML +                 '<td width="6"></td>';
	    VentanaHTML = VentanaHTML +                 '<td valign="top" align="center" colspan="3">';
	          <!--tabla contenido><-->
	    VentanaHTML = VentanaHTML +                   '<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="blanco">';
		VentanaHTML = VentanaHTML +                     '<tr height="5">';
	    VentanaHTML = VentanaHTML +                       '<td></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
	    VentanaHTML = VentanaHTML +                     '<tr class="txtnegro"  height="17">';
	    VentanaHTML = VentanaHTML +                       '<td class="txtnegro">fecha Desde:</td>';
	    VentanaHTML = VentanaHTML +                       '<td><input type="text" name="fechaDesde" size="10" onclick="javascript:muestraCalendario(\'formSeleccionFechas\', \'fechaDesde\', ' + posX + ', ' + posY +')"></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
	    VentanaHTML = VentanaHTML +                     '<tr class="txtnegro" height="17">';
	    VentanaHTML = VentanaHTML +                       '<td class="txtnegro">fecha Hasta:</td>';
	    VentanaHTML = VentanaHTML +                       '<td><input type="text" name="fechaHasta" size="10" onclick="javascript:muestraCalendario(\'formSeleccionFechas\', \'fechaHasta\', ' + posX + ', ' + posY +')"></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
	    VentanaHTML = VentanaHTML +                     '<tr height="17">';
	    VentanaHTML = VentanaHTML +                       '<td class="txtnegro">omitir:</td>';
	    VentanaHTML = VentanaHTML +                       '<td><input type="checkbox" name="omitir"></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
	    VentanaHTML = VentanaHTML +                     '<tr height="17">';
	    VentanaHTML = VentanaHTML +                       '<td class="txtnegro">vac&iacute;o:</td>';
	    VentanaHTML = VentanaHTML +                       '<td><input type="checkbox" name="vacio"></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
		VentanaHTML = VentanaHTML +                     '<tr height="10">';
	    VentanaHTML = VentanaHTML +                       '<td></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
		VentanaHTML = VentanaHTML +                     '<tr height="17">';
	    VentanaHTML = VentanaHTML +                       '<td colspan=2 align="center"><input type="button" id="boton" value="aceptar" onclick="Aceptar(\''+campo+'\')"></td>';
	    VentanaHTML = VentanaHTML +                     '</tr>';
	    VentanaHTML = VentanaHTML +                     '<tr>';
	   	VentanaHTML = VentanaHTML +                     '</tr>';
		VentanaHTML = VentanaHTML +                   '</table>';
		      <!--tabla contenido><-->
		VentanaHTML = VentanaHTML +                 '</td>';
		VentanaHTML = VentanaHTML +               '</tr>';
		VentanaHTML = VentanaHTML +               '<tr>';
		VentanaHTML = VentanaHTML +                 '<td colspan="3" height="5"></td>';
		VentanaHTML = VentanaHTML +                 '<td width="5"></td>';
		VentanaHTML = VentanaHTML +               '</tr>';
		VentanaHTML = VentanaHTML +             '</table>';
	   	VentanaHTML = VentanaHTML +           '</td>';
	   	VentanaHTML = VentanaHTML +         '</tr>';
	   	VentanaHTML = VentanaHTML +       '</table>';
	   	VentanaHTML = VentanaHTML +     '</td>';
	   	VentanaHTML = VentanaHTML +   '</tr>';
	   	VentanaHTML = VentanaHTML + '</table>';
	   	VentanaHTML = VentanaHTML + '</form>';
		///////////////////////////////////////////////////////////////////////////////////  	 
		
		document.getElementById("ventanaSeleccionFechas").style.top = (posY+20) + "px";
		document.getElementById("ventanaSeleccionFechas").style.left = posX + "px";
		document.getElementById("ventanaSeleccionFechas").innerHTML = VentanaHTML;
		document.getElementById("ventanaSeleccionFechas").style.display = "block";
	}
	
    //////////////////////////////////////////////////////////////////////////////////
	// FUNCIONES QUE OCULTA LAS VENTANAS DE SELECCION DE FECHAS 
    // Estado del codigo: ESTABLE
	/////////////////////////////////////////////////////////////////////////////////
	function hideVentanaSeleccionFechas() {
		document.getElementById("ventanaSeleccionFechas").style.display = "none";
	}
	
	function hideVentanaCalendario() {
		document.getElementById("ventanaCalendario").style.display = "none";
	}
	//////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////
	// función muestraCalendario()
    // Estado del codigo: ESTABLE
	/////////////////////////////////////////////////////////////////////////////////
	function muestraCalendario(valorFormulario, valorCampo, x, y)
	  {
		CrearCalendario();
		controlCalendario(valorFormulario, valorCampo, x+10, y+20);
	  }

	///////////////////////////////////////////////////////////////////
	//Ocultamos las ventanas dependiendo de las que estén abiertas////
	/////////////////////////////////////////////////////////////////
	var ventanaCalendario;
	var ventanaSeleccionFechas;
	ventanaCalendario = true;
	ventanaSeleccionFechas = true;

	/////////////////////////////////////////////////////////////////////////////////////////
	// function controlCalendario: pone la capa ventanaCalendario  visible
    // Estado del codigo: ESTABLE
	//////////////////////////////////////////////////////////////////////////////////////////
	function controlCalendario(valorFormulario, valorCampo, x, y){
	    formulario	= valorFormulario;
	    campo		= valorCampo;
	    
		if(ventanaCalendario==true){
			window.document.getElementById('ventanaCalendario').style.visibility="visible";
			window.document.getElementById('ventanaCalendario').style.top = y;
			window.document.getElementById('ventanaCalendario').style.left = x;
		}
	}


	///////////////////////////////////////////////////////////////////////////////////////////////
	// funcion Verificar
    // Estado del codigo: ESTABLE
	///////////////////////////////////////////////////////////////////////////////////////////////
	function Verificar(FechaDif, Dif)
	{
		var HoyDif = new Date(FechaDif);
		var Aux = new Date(FechaDif);
		
		if (Dif==0) {
		    if (HoyDif.getMonth() == 0) {
				HoyDif.setMonth(11);
				HoyDif.setYear(HoyDif.getFullYear()-1);
		    } else {
				HoyDif.setMonth((HoyDif.getMonth()-1));
		    }
			
		} else {
			//corregido por Oscar en Enero de 2006
			HoyDif.setMonth(HoyDif.getMonth()+1);
			if ((HoyDif.getMonth() - Aux.getMonth()) == 2) {
				HoyDif.setDate(1);
				HoyDif.setMonth(Aux.getMonth()+1);
			}
		}
		document.getElementById('ventanaCalendario').innerHTML = Calendario(HoyDif);
	}

	///////////////////////////////////////////////////////////////////////////////////////////////
	// funcion DiaSel
    // Estado del codigo: ESTABLE
	///////////////////////////////////////////////////////////////////////////////////////////////
	function DiaSel(FechaSel, Dia)
	{
		var HoySel=new Date(FechaSel);
		
		HoySel.setDate(Dia)
		
	    var FechaSeleccionada;
	    var diaSeleccionado;
	    var mesSeleccionado;
	    
	    diaSeleccionado = HoySel.getDate();
	    mesSeleccionado = eval(HoySel.getMonth()+1);
	    
	    if ( diaSeleccionado < 10) {
			diaSeleccionado = "0" + diaSeleccionado;
	    }
	    if ( mesSeleccionado < 10) {
			mesSeleccionado = "0" + mesSeleccionado;
	    }
	     
	    FechaSeleccionada = (diaSeleccionado + "-" + mesSeleccionado + "-" + HoySel.getFullYear());
	    
	    //alert (FechaSeleccionada);
	    	
		eval('document.' + formulario + '.' + campo + '.value=FechaSeleccionada');
		
		hideVentanaCalendario();
		
		
	}

	///////////////////////////////////////////////////////////////////////////////////////////////
	// funcion Calendario: devuelve el HTML del calendario con el dia actual marcado
    // Estado del codigo: ESTABLE
	///////////////////////////////////////////////////////////////////////////////////////////////
	function Calendario(Fecha)
	{
	 
	  var Hoy=new Date(Fecha);
	
	  var Hoy2="'" + Hoy + "'"
	  
	  var EsteDia;
	  var DiasPorMes=[31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	  Anyo=Hoy.getFullYear();
	
	  EsteDia=Hoy.getDate();
	
	  
	  // Actualizacion del mes de Febrero (por los anyos bisiestos)
	  if (((Anyo % 4 == 0) && (Anyo % 100 != 0)) || (Anyo % 400 == 0))
	    DiasPorMes[1] = 29; 
	  // Numero de dias del mes actual
	  NDias =DiasPorMes[Hoy.getMonth()];
	
	  // Calculo que dia de la semana es el primero del mes
	  PrimerDia=Hoy;
	  PrimerDia.setDate(1);
		 // Observacion: Obtengo el dia de hoy (p.e, 10-11-1999) y calculo que dia de la semana 
		 // es el dia 1 del mismo mes y año (p.e, 1-11-1999) 
		Comienzo=PrimerDia.getDay();
	  
	  if (Comienzo==0)
	  	Comienzo = 6
	  else 
	  	Comienzo = Comienzo - 1; 
	     
	 <!-- Escritura en la pantalla de la tabla correspondiente al mes actual -->
	    var CalendarioTexto = '';	
	
	
	    CalendarioTexto = '<table border="0"><tr><td bgcolor="#000000">'	
	    CalendarioTexto = CalendarioTexto + '<table border="0" cellpadding="0" cellspacing="1" width="100%" class="blanco"><tr><td>'	
	    CalendarioTexto = CalendarioTexto + '<table width="200" border="0" cellspacing="0" cellpadding="0" class="blanco">'
	    CalendarioTexto = CalendarioTexto + '<tr><td width="6"></td><td class="blanco" width="59">'	
	    //////////////////////Mes anterior
	    CalendarioTexto = CalendarioTexto + '<a href="javascript:Verificar(' + Hoy2 + ',0)">'
	    CalendarioTexto = CalendarioTexto + '<img name="calFleIzq" src='+calFleIzq.src+' border="0" vspace="2" title="Mes Anterior"></a>'   
	
	    /////////////////////Mes siguiente	
	    CalendarioTexto = CalendarioTexto + '<a href="javascript:Verificar(' + Hoy2 + ',1)">'
	    CalendarioTexto = CalendarioTexto + '<img name="calFleDer" src='+calFleDer.src+' border="0" vspace="2" hspace="4" title="Mes Siguiente"></a></td>'
	
	    /////////////////////Cabecera, nombre mes
	    var Mes = "";
	
	    switch (Hoy.getMonth()+1){
		case 1:
			Mes = "Enero"; 
			break;
		case 2:
			Mes = "Febrero"; 
			break;		
		case 3:
			Mes = "Marzo";
			break; 
		case 4:
			Mes = "Abril"; 
			break;
		case 5:
			Mes = "Mayo";
			break;
		case 6:
			Mes = "Junio"; 
			break;
		case 7:
			Mes = "Julio"; 
			break;
		case 8:
			Mes = "Agosto"; 
			break;
		case 9:
			Mes = "Septiembre"; 
			break;
		case 10:
			Mes = "Octubre"; 
			break;
		case 11:
			Mes = "Noviembre";
			break;
		case 12:
			Mes = "Diciembre"; 
			break;	
		default: 
			Mes = "Error";
			break;
		}
	    
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro" height="18" align="center" width="99">'
	    CalendarioTexto = CalendarioTexto + Mes +' de ' + Anyo + '</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="white" align="right" width="31">'
	 
	    /////////////////////Cerrar calendario/
	    
	    VarCerrar="hideVentanaCalendario();"
	    CalendarioTexto = CalendarioTexto + '<a href="javascript:'+VarCerrar+'"><img name="calCerrar" src="'+calCerrar.src+'" border="0" vspace="2" title="cerrar"></a></td>'
	    
	    CalendarioTexto = CalendarioTexto + '<td width="5" class="blanco" valign="top">&nbsp;</td>'
	
	    CalendarioTexto = CalendarioTexto + '</TR>'
	    CalendarioTexto = CalendarioTexto + '<tr>' 
	    CalendarioTexto = CalendarioTexto + '<td width="6"></td>'
	    CalendarioTexto = CalendarioTexto + '<td valign="top" align="center" colspan="3">'
	          <!--tabla contenido><-->
	    CalendarioTexto = CalendarioTexto + '<table width="95%" border="0" cellspacing="1" cellpadding="0" align="center" class="blanco">'
	    CalendarioTexto = CalendarioTexto + '<tr class="azulclaro2" align="center" height="17">'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">L</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">M</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">X</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">J</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">V</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">S</td>'
	    CalendarioTexto = CalendarioTexto + '<td class="txtnegro">D</td>'
	    CalendarioTexto = CalendarioTexto + '</tr>'
		 
	   CalendarioTexto = CalendarioTexto + "<TR>";
	   	 
	   columna=0;
	   for (i=0; i<Comienzo; i++)
	      {
	        CalendarioTexto = CalendarioTexto + "<TD>";
	        columna++;
	        CalendarioTexto = CalendarioTexto + "</TD>"
	      }
	
	   // Escritura de los dias del mes
	      for (i=1; i<=NDias; i++)
	      { 
				CalendarioTexto = CalendarioTexto + "<TD class=textonegro>";
		        CalendarioTexto = CalendarioTexto + '<a href="javascript:DiaSel(' + Hoy2 + ',' + i + ');">';
		        //alert(i + ' / ' + EsteDia);
		        
		        if (i == EsteDia)
		        {  
					CalendarioTexto = CalendarioTexto + "<FONT COLOR='blue'>"
				}  	
				else if (columna == 6)
				      {   	
						CalendarioTexto = CalendarioTexto + "<FONT COLOR='red'>"
				      }
				      else 
				      {	
				     	CalendarioTexto = CalendarioTexto + "<FONT COLOR='black'>";
				      }	
		                
		        CalendarioTexto = CalendarioTexto + '<CENTER>'+i+' </CENTER>';
			
			CalendarioTexto = CalendarioTexto + "</FONT> ";
			CalendarioTexto = CalendarioTexto + '</a>';
			CalendarioTexto = CalendarioTexto + "</TD>";
			
			columna++;
			
		        if (columna == 7)
			        {             
			        CalendarioTexto = CalendarioTexto + "</TR><TR>";            
			        columna=0;
			        }
	      }		
		 
	   	 CalendarioTexto = CalendarioTexto + "</TR>";
	
		 CalendarioTexto = CalendarioTexto + '</table>'
		 CalendarioTexto = CalendarioTexto + '</td>'
		 CalendarioTexto = CalendarioTexto + '</tr>'
		 CalendarioTexto = CalendarioTexto + '<tr>' 
		 CalendarioTexto = CalendarioTexto + '<td colspan="4" height="5">'
		 CalendarioTexto = CalendarioTexto + '</td>'
		 CalendarioTexto = CalendarioTexto + '<td width="5">'
		 CalendarioTexto = CalendarioTexto + '</td>'
		 CalendarioTexto = CalendarioTexto + '</tr>'
	
		 CalendarioTexto = CalendarioTexto + '</table>'
	   	 CalendarioTexto = CalendarioTexto + '</td></tr></table>'
	   	 CalendarioTexto = CalendarioTexto + '</td></tr></table>'
	   	 
		 return CalendarioTexto
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////
	


	///////////////////////////////////////////////////////////////////////////////////////////////
	// funcion Calendario: devuelve el HTML del calendario con el dia actual marcado
    // Estado del codigo: ESTABLE
	///////////////////////////////////////////////////////////////////////////////////////////////
	function CrearCalendario()
	{
		var FechaActual=new Date();
		//document.getElementById('ventanaCalendario').innerHTML = Calendario(FechaActual);
		document.getElementById("ventanaCalendario").style.top = (posY+20) + "px";
		document.getElementById("ventanaCalendario").style.left = posX + "px";
		document.getElementById("ventanaCalendario").innerHTML = Calendario(FechaActual);
		document.getElementById("ventanaCalendario").style.display = "block";
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////// F I N   D E    C O D I G O    E S T A B L E  //////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////


