// Constructor de la Clase Validacion//
//var WValidacion = new wValidacion()

function $HH(object) {
  var hash = Object.extend({}, object || {});
  Object.extend(hash, Enumerable);
  Object.extend(hash, Hash);
  return hash;
}

function Vacio(v){
	return ((v == null) || (v.length == 0));
}
var ValidaW;
//if (!ValidaW) ValidaW = {};
//if (!Spry.Widget) Spry.Widget = {};


function ValidaW(CampoID, TipoN, options){

//	alert(Tipo);
//var Repuesta = 'correcto';
	var Tipo = TipoN;
	var CampoId;
	var MINChars;
	var MAXChars;
	var VMAXChars = 0;
	var VMINChars = 0;
	var VMAXCharsExiste;
	var VMINCharsExiste;
	var continueValidacion = true;
	var CampoN = document.getElementById(CampoID);
	var RValue = CampoN.value;
	var RVacio = Vacio(RValue);
	var Nlength =  RValue.length;
	this.options = $H(options);
	if (RVacio === false){
		//alert(RVacion)
	//	return true;		
	
			switch (Tipo) {
				case 'none':	
				
				break;
				case 'integer':
					if(isNaN(RValue)==true){
						
					continueValidacion = false;						
					} 					

				break;
				case 'email': 
					var expR = /^[\w\.-]+@[\w\.-]+\.\w+$/i;
					if((expR.test(RValue))==false){
						continueValidacion = false;					
					}					
				break;
				/*
				case: 'alpha':
					  var RegExPattern = /(\d$)/; // var RegExPattern = /(\w+)\s(\w+)(\d$)/; 
    				  var errorMessage = 'Debe Selecionar Un Campo De La Lista';
     					if ((errorMessage.match(RegExPattern)) && errorMessage!='')) {
					continueValidacion = false;
				 	}						
				break; //*/
			
		
			}

/*	
				case: 'alpha':
					var expR2 = /^[a-zA-Z\s]+$/i;					
					if((expR2.test(RValue))==false){
						continueValidacion = false;
					}	
				break;
			
	
	
	/*		
	
	
	['validate-alpha', 'Use solo letras de la (a-z).', function (v) {
				return Validation.get('IsEmpty').test(v) ||  /^[a-zA-Z\s]+$/.test(v)
			}],
	['validate-alphanum', 'Use solo letras de la (a-z) o números del (0-9), omita cualquier otro caracter.', function(v) {
				return Validation.get('IsEmpty').test(v) ||  !/\W\s/.test(v)
			}],				
				/*
				
				case 'time': 
								
					//validation: function(value, options) {
						//	HH:MM:SS T
						var formatRegExp = /([hmst]+)/gi;
			//			var valueRegExp = /(\d+|AM?|PM?)/gi;
						//var formatGroups = options.format.match(formatRegExp);
						//var valueGroups = value.match(valueRegExp);
						var formatGroups = RValue.match(formatRegExp);
				//		var valueGroups = value.match(valueRegExp);
						//mast match and have same length
						if (formatGroups !== null && valueGroups !== null) {
							if (formatGroups.length != valueGroups.length) {
								continueValidacion = false;
							}
			
							var hourIndex = -1;
							var minuteIndex = -1;
							var secondIndex = -1;
							//T is AM or PM
							var tIndex = -1;
							var theHour = 0, theMinute = 0, theSecond = 0, theT = 'AM';
							for (var i=0; i<formatGroups.length; i++) {
								switch (formatGroups[i].toLowerCase()) {
									case "hh":
										hourIndex = i;
										break;
									case "mm":
										minuteIndex = i;
										break;
									case "ss":
										secondIndex = i;
										break;
									case "t":
									case "tt":
										tIndex = i;
										break;
								}
							}
							if (hourIndex != -1) {
								var theHour = parseInt(valueGroups[hourIndex], 10);
								if (isNaN(theHour) || theHour > (formatGroups[hourIndex] == 'HH' ? 23 : 12 )) {
									continueValidacion = false;
								}
							}
							if (minuteIndex != -1) {
								var theMinute = parseInt(valueGroups[minuteIndex], 10);
								if (isNaN(theMinute) || theMinute > 59) {
									continueValidacion = false;
								}
							}
							if (secondIndex != -1) {
								var theSecond = parseInt(valueGroups[secondIndex], 10);
								if (isNaN(theSecond) || theSecond > 59) {
									continueValidacion = false;
								}
							}
							if (tIndex != -1) {
								var theT = valueGroups[tIndex].toUpperCase();
								if (
									formatGroups[tIndex].toUpperCase() == 'TT' && !/^a|pm$/i.test(theT) || 
									formatGroups[tIndex].toUpperCase() == 'T' && !/^a|p$/i.test(theT)
								) {
									continueValidacion = false;
								}
							}
							var date = new Date(2000, 0, 1, theHour + (theT.charAt(0) == 'P'?12:0), theMinute, theSecond);
							return date;
						} else {
							continueValidacion = false;
						}
					
				break;*/
		

		if (continueValidacion != false){
			//return true;
			//return Nlength;
					
		   MINChars =  parseInt(this.options.minChars);
		   MAXChars =  parseInt(this.options.maxChars);

				// VALOR MAXIMO
				if(MAXChars > 0){
				VMAXChars = 1;
											
				}	
				if (VMAXChars == 1){			
				VMAXCharsExiste = 'SI'; 
				}
				
				if (VMAXCharsExiste == 'SI' && Nlength > MAXChars ){
					continueValidacion = false;
				}
	
				// VALOR MINIMO			
				if(MINChars > 0){
				VMINChars = 1;
				}
				
				if (VMINChars == 1){
					VMINCharsExiste = 'SI';
				}
				
				if (VMINCharsExiste == 'SI' && Nlength < MINChars){
				continueValidacion = false;
				
				}	
				
				
				if (continueValidacion == true){
					return true;
					}else{
					return false;	
				}
	
			
		}else{
			return false;	
		}
	

/*
if(!mustRevert && this.minChars !== null  && continueValidations) {
		if (testValue.length < this.minChars) {
			errors = errors | Spry.Widget.ValidationTextField.ERROR_CHARS_MIN;
			continueValidations = false;
		}
	}
*/	
	}else{
				
	return false;	
	}


} 


//	options.minChars = Spry.Widget.Utils.firstValid(options.minChars, validationDescriptor.minChars);	


/*

Validation.add('IsEmpty', '', function(v) {
				return  ((v == null) || (v.length == 0)); // || /^\s+$/.test(v));
			});


function Vacion(val){}


Validation.add('IsEmpty', '', function(v) {
				return  ((v == null) || (v.length == 0)); // || /^\s+$/.test(v));
			});


function valida_envia(){
    //valido el nombre
    if (document.fvalida.nombre.value.length==0){
       alert("Tiene que escribir su nombre")
       document.fvalida.nombre.focus()
       return 0;
    }

    //valido la edad. tiene que ser entero mayor que 18
    edad = document.fvalida.edad.value
    edad = validarEntero(edad)
    document.fvalida.edad.value=edad
    if (edad==""){
       alert("Tiene que introducir un número entero en su edad.")
       document.fvalida.edad.focus()
       return 0;
    }else{
       if (edad<18){
          alert("Debe ser mayor de 18 años.")
          document.fvalida.edad.focus()
          return 0;
       }
    }

    //valido el interés
    if (document.fvalida.interes.selectedIndex==0){
       alert("Debe seleccionar un motivo de su contacto.")
       document.fvalida.interes.focus()
       return 0;
    }

    //el formulario se envia
    alert("Muchas gracias por enviar el formulario");
    document.fvalida.submit();
}


//document.getElementById("num_partos").focus();

function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
/*
var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
	
}

function Valida_seccion_II_b(){

	if(eval(document.getElementById("num_partos").value) + eval(document.getElementById("num_cesareas").value) != eval(document.getElementById("num_vivos").value) + eval(document.getElementById("num_muertos").value)){
		
		alert("El número de embarazos debe ser igual al número de nacimietos");
		document.getElementById("num_partos").focus();
		return false;
		
	}
	
	if(eval(document.getElementById("num_vivos").value) < eval(document.getElementById("num_act_vivos").value)){
		alert("La cantidad de hijos actualmente vivos no puede ser menor a los nacidos vivos");
		document.getElementById("num_vivos").focus();
		return false;
		
	}
return true;

}
*/