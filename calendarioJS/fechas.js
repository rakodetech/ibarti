/************************************************************************
//Validaciones de fechas
************************************************************************/
// Obtiene la fecha de hoy

function getTodayDate()
{
  var d, s= new String("");
  d = new Date();
  s += d.getDate() + "/";
  s += (d.getMonth()+ 1) + "/";
  s += d.getFullYear();
  return(s);
}

// retorna true si la diferencia de las fechas  es mayor de 18 
function fechasesmenor18 (fechacar, fechanac)
	{
	var dianac,mesnac,yearnac,diacar,mescar,yearcar,restayear;

	dianac = getDia (fechanac);
	mesnac = getMes (fechanac);
	yearnac = getYear (fechanac);
	
	diacar = getDia (fechacar);
	mescar = getMes (fechacar);
	yearcar = getYear (fechacar);

	restayear=yearcar-yearnac;
	
	if (parseInt(restayear,10)>18)
		return false;		
	else if (parseInt(restayear,10)==18) 
			if (parseInt(mescar,10)>parseInt(mesnac,10))
				return false;
			else if (parseInt(mesnac,10)==parseInt(mescar,10))
					if (parseInt(diacar,10)>=parseInt(dianac,10))
						return false; 	
	return true;		
}

// Comprueba que el formato de una fecha sea:
// dd/mm/yyyy
// Devuelve true si se cumple el formato
// o false en otro caso
//
    function chkMaskFecha( str ){
exp= /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
if(!exp.test(str))
           return false;
        else
           return true;
     }

// Recibe una fecha y nos devuelve el dia
// 
function getDia( str ){

var dia="";
var posIni=0;
var posFin=0;
    
posFin=str.indexOf("/");
dia=str.substring(posIni,posFin);

return (dia);
     
     }

// Recibe una fecha y nos devuelve el mes
//

     function getMes( str ){

var mes="";
var posIni=0;
var posFin=0;

posFin=str.indexOf("/");
posIni=posFin;
posFin=str.lastIndexOf("/");
mes=str.substring(posIni+1,posFin);

return (mes);

     }

// Recibe una fecha y nos devuelve el ano
//
     function getYear( str ){

var year="";
var posIni=0;

posIni=str.lastIndexOf("/");
year=str.substring(posIni+1,str.length+1);

return (year);

     }

// Comprueba la longitud de un ano
// Si el formato de este es "aa" lo pasamos a "aaaa"
// Devuelve el ano

function chkFormatoYear( str ){

  var Year;
  if (str.length==2)
          {
Year=parseInt(str,10);
if (Year>=0 && Year<49)
{
Year=Year+2000;
}
else
{
Year=Year+1900;
}
   }
   else
   {
Year=parseInt(str,10);
   }

   return Year;

}

// Comprueba que una fecha sea correcta
// Devuelve true si la fecha es correcta y false en caso contrario 
//
//
function chkFechaOk(str) {
  		var Dia;
		var Mes;
		var Year;

		
		Year=getYear(str);
		Mes=parseInt(getMes(str),10);
		Dia=getDia(str);
		Year=chkFormatoYear(Year);

		 if((Mes==1) || (Mes==3) || (Mes==5) ||(Mes==7) ||(Mes==8) ||(Mes==10) ||(Mes==12))
		 {
				if(Dia<=0 || Dia>31)
					{return false;}
		 }
		 else if((Mes==4) ||(Mes==6) ||(Mes==9) ||(Mes==11))
		 {
				if(Dia<=0 || Dia>30)
					{return false;}
		 }
		 else if(Mes==2)
		 {
				if((Year%4==0)&&(Year%100!=0)||(Year%400==0))
				{
					if(Dia<=0||Dia>29)
						{return false;}
				}
				else
				{
					if(Dia<=0||Dia>28)
						{return false;}
				}
		 }
		 else
		 {return false;}  
		 
		 return true;
 }

//  Crea dos objetos de tipo Date de javascript con las fechas que le llegan y
//  llama a la funcion que valida si una es menor que la otra
//  devuelve true si la primera fecha es menor que la segunda
//  o false en caso contrario
//

function chkEsMenor (fechaIni,fechaFin)
{
fechaIniAux=new Date();
fechaFinAux=new Date();

if ( ( !chkFechaOk(fechaIni) )|| ( !chkFechaOk(fechaFin) ) )
{
     return false;
}
else
{
	
fechaIniAux.setMonth(getMes(fechaIni)-1);
fechaIniAux.setDate(getDia(fechaIni));
fechaIniAux.setYear(getYear(fechaIni));

fechaFinAux.setMonth(getMes(fechaFin)-1);
fechaFinAux.setDate(getDia(fechaFin));
fechaFinAux.setYear(getYear(fechaFin));

/* ESTO LO HE CAMBIADO PARA VER SI FUNCIONA 
fechaIniAux.setDate(getDia(fechaIni));
fechaIniAux.setMonth(getMes(fechaIni)-1);
fechaIniAux.setYear(getYear(fechaIni));

fechaFinAux.setDate(getDia(fechaFin));
fechaFinAux.setMonth(getMes(fechaFin)-1);
fechaFinAux.setYear(getYear(fechaFin));
*/

if (!chkRangoFechasMenor (fechaIniAux,fechaFinAux))
{
return false;
}

}
return true;

}

////////////////////////////////////////////////////////////////////////////////
// Nombre Función: fechasDiferenciaEnDias
// Parámetros:     fechaIni -- es la fecha inicial
//                 fechaFin -- es la fecha final
//                 
// Descripción:    la función compara las fechas y determina si el 
//                 número de días en que se diferencian es mayor que
//                 al número de días pasados como parámetro.
//                 Se almacenan las fechas de entrada en fechas auxiliares
//                 de tipo Date(), que son restadas dando como resultado
//                 el número de milisegundos de diferencia.
//                 Este número se convierte en días y se redondea al entero
//                 menor más cercano.
//
//  Julio/2002    (Oscar Hernández Caballero)
///////////////////////////////////////////////////////////////////////////////
function fechasDiferenciaEnDias (fechaIni,fechaFin) {
  if ( (!chkFechaOk(fechaIni)) || (!chkFechaOk(fechaFin)) )
  {
       return false;
  }

  fechaIniAux=new Date();
  fechaFinAux=new Date();

  
  fechaIniAux.setMonth(getMes(fechaIni)-1);
  fechaIniAux.setDate(getDia(fechaIni));
  fechaIniAux.setYear(getYear(fechaIni));

  fechaFinAux.setMonth(getMes(fechaFin)-1);
  fechaFinAux.setDate(getDia(fechaFin));
  fechaFinAux.setYear(getYear(fechaFin));
  
  //alert(fechaIniAux);
  //alert(fechaFinAux);
  
  var tiempoRestante = fechaFinAux.getTime() - fechaIniAux.getTime();
  
  
  var dias = Math.abs(Math.floor(tiempoRestante / (1000 * 60 * 60 * 24)));
  
  
  //alert(dias + " días de diferencia");
  return dias;
  
  
}
/////////////////////////////////////////////////////////////



// Comprueba que una fecha sea menor que la otra
// Devuelve true si la primera fecha es menor que la segunda
// o false en caso contrario
//


function chkRangoFechasMenor(fechaIni,fechaFin){

       if ((fechaFin-fechaIni)>0)

return true;
else

return false;

}


//  Crea dos objetos de tipo Date de javascript con las fechas que le llegan y
//  llama a la funcion que valida si una es mayor que la otra
//  devuelve true si la primera fecha es mayor que la segunda
//  o false en caso contrario
//

function chkEsMayor (fechaIni,fechaFin)
{
fechaIniAux=new Date();
fechaFinAux=new Date();

if ( ( !chkFechaOk(fechaIni) )|| ( !chkFechaOk(fechaFin) ) )
{
     return false;
}
else
{

fechaIniAux.setMonth(getMes(fechaIni)-1);
fechaIniAux.setDate(getDia(fechaIni));
fechaIniAux.setYear(getYear(fechaIni));

fechaFinAux.setMonth(getMes(fechaFin)-1);
fechaFinAux.setDate(getDia(fechaFin));
fechaFinAux.setYear(getYear(fechaFin));

/* ESTO LO HE MODIFICADO 

fechaIniAux.setDate(getDia(fechaIni));
fechaIniAux.setMonth(getMes(fechaIni)-1);
fechaIniAux.setYear(getYear(fechaIni));

fechaFinAux.setDate(getDia(fechaFin));
fechaFinAux.setMonth(getMes(fechaFin)-1);
fechaFinAux.setYear(getYear(fechaFin));
*/

if (!chkRangoFechasMayor (fechaIniAux,fechaFinAux))
{
return false;
}

}
return true;

}

// Comprueba que una fecha sea menor que la otra
// Devuelve true si la primera fecha es mayor que la segunda
// o false en caso contrario
//


function chkRangoFechasMayor(fechaIni,fechaFin){

       if ((fechaIni-fechaFin)>0)

return true;
else

return false;

}


// Recibe una fecha y la pasa a formato dd/mm/yyyy
// Devuelve la fecha con el formato indicado
//

function getFormatOk (str) {

var Dia;
var Mes;
var Year;

Dia=getDia(str);
Mes=getMes(str);
Year=getYear(str);

if (parseInt(Dia,10)<10 && Dia.charAt(0)!="0")
{
Dia="0"+Dia;
}

if (parseInt(Mes,10)<10 && Mes.charAt(0)!="0")
{
Mes="0"+Mes;
}

Year = chkFormatoYear(Year);

return (Dia+"/"+Mes+"/"+Year);

}


function chkSonIguales(fechaIni,fechaFin){
   return (!chkEsMayor(fechaIni,fechaFin) && !chkEsMenor(fechaIni,fechaFin));
}


function cambiaFecha(dia,mes,year,cajafecha)	
{
	cajafecha.value = dia + "/" + mes + "/" + year		
}


function calcularEdad(cumple){

todaysTime = new Date();
birthTime = new Date(cumple);

todaysYear = todaysTime.getFullYear()
todaysMonth = todaysTime.getMonth()
todaysDate = todaysTime.getDate()
todaysHour = todaysTime.getHours()
todaysMinute = todaysTime.getMinutes()
todaysSecond = todaysTime.getSeconds()
birthYear = birthTime.getFullYear()
birthMonth = birthTime.getMonth()
birthDate = birthTime.getDate()
birthHour = birthTime.getHours()
birthMinute = birthTime.getMinutes()
birthSecond = birthTime.getSeconds()

if ((todaysYear / 4) == (Math.round(todaysYear / 4))) {
   countLeap = 29}
else {
     countLeap = 28}

if (todaysMonth == 2) {
   countMonth = countLeap}
else {
     if (todaysMonth == 4) {
        countMonth = 30}
     else {
        if (todaysMonth == 6) {
           countMonth = 30}
        else {
           if (todaysMonth == 9) {
              countMonth = 30}
           else {
              if (todaysMonth == 11) {
                 countMonth = 30}
              else {
                 countMonth = 31}}}}}


if (todaysMinute > birthMinute) {
   diffMinute = todaysMinute - birthMinute
   calcHour = 0}
else {
   diffMinute = todaysMinute + 60 - birthMinute
   calcHour = -1}
if (todaysHour > birthHour) {
   diffHour = todaysHour - birthHour + calcHour
   calcDate = 0}
else {
   diffHour = todaysHour + 24 - birthHour  + calcHour
   calcDate = -1}
if (todaysDate > birthDate) {
   diffDate = todaysDate - birthDate + calcDate
   calcMonth = 0}
else {
   diffDate = todaysDate + countMonth - birthDate  + calcDate
   calcMonth = -1}
if (todaysMonth > birthMonth) {
   diffMonth = todaysMonth - birthMonth + calcMonth
   calcYear = 0}
else {
   diffMonth = todaysMonth + 12 - birthMonth + calcMonth
   calcYear = -1}
diffYear = todaysYear - birthYear + calcYear

if (diffMinute == 60) {
   diffMinute = 0
   diffHour = diffHour + 1}
if (diffHour == 24) {
   diffHour = 0
   diffDate = diffDate + 1}
if (diffDate == countMonth) {
   diffDate = 0
   diffMonth = diffMonth + 1}
if (diffMonth == 12) {
   diffMonth = 0
   diffYear = diffYear + 1}
  
   
  if ((diffDate==6 && diffMonth>0) || (diffDate>6) )
      diffYear=diffYear+1;
  
  return diffYear;
} 


function fechapasado(fechatexto)
{
var fecha;
var hoy;
hoy = new Date();
fecha=new Date();
fecha.setMonth(getMes(fechatexto)-1);
fecha.setDate(getDia(fechatexto));
fecha.setYear(getYear(fechatexto));
if (fecha - hoy < 0)
  return true;
else 
  return false;
}