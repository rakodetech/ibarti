// Variables para setear

onload=function() 
{
	
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo"); 
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");  
/*	divMensaje=document.getElementById("transparenciaMensaje");  */
	form=document.getElementById("formulX");
/*	urlDestino="mail.php";*/
	
	claseNormal="input";
	claseError="inputError";
	
	preCarga("ok.gif", "loading.gif", "error.gif");
}


function preCarga()
{
	imagenes=new Array();
	for(i=0; i<arguments.length; i++)
	{
		imagenes[i]=document.createElement("img");
		imagenes[i].src=arguments[i];
	}
}

function nuevoAjax()
{ 
	var xmlhttp=false; 
	try 
	{ 
		// No IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest(); } 
	return xmlhttp; 
}

function limpiaForm()
{
	for(i=0; i<=4; i++)
	{
		form.elements[i].className=claseNormal;
	}
	document.getElementById("inputComentario").className=claseNormal;
}

function campoError(campo)
{
	campo.className=claseError;
	error=1;
}

function ocultaMensaje()
{
	divTransparente.style.display="none";
}

function muestraMensaje(mensaje)
{
	divMensaje.innerHTML=mensaje;
	divTransparente.style.display="block";
}


// Mensajes de ayuda

if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
else navegador=1;

function colocaAyuda(event)
{
	if(navegador==0)
	{
		var corX=window.event.clientX+document.documentElement.scrollLeft;
		var corY=window.event.clientY+document.documentElement.scrollTop;
	}
	else
	{
		var corX=event.clientX+window.scrollX;
		var corY=event.clientY+window.scrollY;
	}
	cAyuda.style.top=corY+20+"px"; 
	cAyuda.style.left=corX+15+"px";
}

function ocultaAyuda()
{
	cAyuda.style.display="none";
	if(navegador==0) 
	{
		document.detachEvent("onmousemove", colocaAyuda);
		document.detachEvent("onmouseout", ocultaAyuda);
	}
	else 
	{
		document.removeEventListener("mousemove", colocaAyuda, true);
		document.removeEventListener("mouseout", ocultaAyuda, true);
	}
}
/*
muestraAyuda (event, this, 'Empresa' , 'tool')  
EL orden de la funcion es oblicatorio de lo cual 

event, this, = Son funciones de Javas scripst

'Empresa' = Es el nombre del titulo A mostrar
'tool' , es el nombre de formulario  
*/


function muestraAyuda(event, valor,campo, formulario_id)
{
var titulo = campo;
var mens = valor.name; 
var formulX = formulario_id;



	colocaAyuda(event);
	
	if(navegador==0) 
	{ 
		document.attachEvent("onmousemove", colocaAyuda); 
		document.attachEvent("onmouseout", ocultaAyuda); 
	}
	else 
	{
		document.addEventListener("mousemove", colocaAyuda, true);
		document.addEventListener("mouseout", ocultaAyuda, true);
	}
	
/*	cNombre.innerHTML=campo; //asignar el titulo del campo
	cTex.innerHTML=ayuda[campo]; //asigna el mensaje 
	*/
	cNombre.innerHTML= titulo;
	cTex.innerHTML= mens;
	
	cAyuda.style.display="block";
}