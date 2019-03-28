function activar(){  
	if ( document.getElementById("filterTF").disabled == true) {
	document.getElementById("filterTF").disabled=!document.getElementById("filterTF").disabled; 
	document.getElementById("containsCB").disabled=!document.getElementById("containsCB").disabled;
	}
	if (document.getElementById("ContenidoPag").value == ""){
	document.getElementById("filterTF").disabled   = true; 
	document.getElementById("containsCB").disabled = true;
	}
}

function FilterData()
{
var campo = document.getElementById("ContenidoPag").value; 
	var tf = document.getElementById("filterTF");
	if (!tf.value)
	{
		// If the text field is empty, remove any filter
		// that is set on the data set.//
	//	data XML  //
		ds1.filter(null);
		return;
	}
	// Set a filter on the data set that matches any row
	// that begins with the string in the text field.
	var regExpStr = tf.value;
		if (!document.getElementById("containsCB").checked)
		regExpStr = "^" + regExpStr;

	var regExp = new RegExp(regExpStr, "i");	
	var filterFunc = function(ds, row, rowNumber)
	{    //campo a filtrar   	var str = row["undeje"]; //
		var str = row[campo];
		if (str && str.search(regExp) != -1)
			return row;
		return null;
	};  //             ojo   ******************************* ;;;;;
    //  data XML //
	ds1.filter(filterFunc);
}

function StartFilterTimer()
{
	if (StartFilterTimer.timerID)
		clearTimeout(StartFilterTimer.timerID);
	StartFilterTimer.timerID = setTimeout(function() { StartFilterTimer.timerID = null; FilterData(); }, 100);
}

///////////////////////////////////////////////////////////////////////////  22 /////////
function activar2(){
  
	if (document.getElementById("filterTF2").disabled == true) {
	document.getElementById("filterTF2").disabled=!document.getElementById("filterTF2").disabled; 
	document.getElementById("containsCB2").disabled=!document.getElementById("containsCB2").disabled;
	}

	if (document.getElementById("ContenidoPag2").value == ""){
	document.getElementById("filterTF2").disabled   = true; 
	document.getElementById("containsCB2").disabled = true;
	}
}

function FilterData2()
{
var campo = document.getElementById("ContenidoPag2").value; 
	var tf = document.getElementById("filterTF2");
	if (!tf.value)
	{
		// If the text field is empty, remove any filter
		// that is set on the data set.//
	//	data XML  //
		ds2.filter(null);
		return;
	}

	var regExpStr = tf.value;
		if (!document.getElementById("containsCB2").checked)
		regExpStr = "^" + regExpStr;

	var regExp = new RegExp(regExpStr, "i");
	
	var filterFunc = function(ds, row, rowNumber)
	{    //campo a filtrar   	var str = row["undeje"]; //
		var str = row[campo];
		if (str && str.search(regExp) != -1)
			return row;
		return null;
	};

    //  data XML //
	ds2.filter(filterFunc);
}

function StartFilterTimer2()
{
	if (StartFilterTimer2.timerID)
		clearTimeout(StartFilterTimer2.timerID);
	StartFilterTimer2.timerID = setTimeout(function() { StartFilterTimer2.timerID = null; FilterData2(); }, 100);
}

function ValidarTamano2(valorC){
var valueC    = valorC.value;
var MaxCamposPag =  parseInt(document.getElementById("MaxCamposPagX2").value);

	if( ( valueC >MaxCamposPag || valueC < 1 ||  isNaN(valueC)  )){ 
		document.getElementById("tamanoCampos2").disabled= true;
		valorC.style.backgroundColor="#FF9F9F";
		
	}else{
		document.getElementById("tamanoCampos2").disabled= false;
		valorC.style.backgroundColor=""
	}
}

///////////////////////////////////////////////////////////////////////////  33 /////////
function activar3(){
  
	if (document.getElementById("filterTF3").disabled == true) {
	document.getElementById("filterTF3").disabled=!document.getElementById("filterTF3").disabled; 
	document.getElementById("containsCB3").disabled=!document.getElementById("containsCB3").disabled;
	}

	if (document.getElementById("ContenidoPag3").value == ""){
	document.getElementById("filterTF3").disabled   = true; 
	document.getElementById("containsCB3").disabled = true;
	}
}

function FilterData3()
{
var campo = document.getElementById("ContenidoPag3").value; 
	var tf = document.getElementById("filterTF3");
	if (!tf.value)
	{
		// If the text field is empty, remove any filter
		// that is set on the data set.//
	//	data XML  //
		ds3.filter(null);
		return;
	}

	var regExpStr = tf.value;
		if (!document.getElementById("containsCB3").checked)
		regExpStr = "^" + regExpStr;

	var regExp = new RegExp(regExpStr, "i");
	
	var filterFunc = function(ds, row, rowNumber)
	{    //campo a filtrar   	var str = row["undeje"]; //
		var str = row[campo];
		if (str && str.search(regExp) != -1)
			return row;
		return null;
	};

    //  data XML //
	ds3.filter(filterFunc);
}

function StartFilterTimer3()
{
	if (StartFilterTimer3.timerID)
		clearTimeout(StartFilterTimer3.timerID);
	StartFilterTimer3.timerID = setTimeout(function() { StartFilterTimer3.timerID = null; FilterData3(); }, 100);
}

function ValidarTamano3(valorC){
var valueC    = valorC.value;
var MaxCamposPag =  parseInt(document.getElementById("MaxCamposPagX3").value);

	if( ( valueC >MaxCamposPag || valueC < 1 ||  isNaN(valueC)  )){ 
		document.getElementById("tamanoCampos3").disabled= true;
		valorC.style.backgroundColor="#FF9F9F";
		
	}else{
		document.getElementById("tamanoCampos3").disabled= false;
		valorC.style.backgroundColor=""
	}
}

///////////////////////////////////////////////////////////////////////////  44 /////////
function activar4(){
  
	if (document.getElementById("filterTF4").disabled == true) {
	document.getElementById("filterTF4").disabled=!document.getElementById("filterTF4").disabled; 
	document.getElementById("containsCB4").disabled=!document.getElementById("containsCB4").disabled;
	}

	if (document.getElementById("ContenidoPag4").value == ""){
	document.getElementById("filterTF4").disabled   = true; 
	document.getElementById("containsCB4").disabled = true;
	}
}

function FilterData4()
{
var campo = document.getElementById("ContenidoPag4").value; 
	var tf = document.getElementById("filterTF4");
	if (!tf.value)
	{
		// If the text field is empty, remove any filter
		// that is set on the data set.//
	//	data XML  //
		ds4.filter(null);
		return;
	}

	var regExpStr = tf.value;
		if (!document.getElementById("containsCB4").checked)
		regExpStr = "^" + regExpStr;

	var regExp = new RegExp(regExpStr, "i");
	
	var filterFunc = function(ds, row, rowNumber)
	{    //campo a filtrar   	var str = row["undeje"]; //
		var str = row[campo];
		if (str && str.search(regExp) != -1)
			return row;
		return null;
	};

    //  data XML //
	ds4.filter(filterFunc);
}

function StartFilterTimer4()
{
	if (StartFilterTimer4.timerID)
		clearTimeout(StartFilterTimer4.timerID);
	StartFilterTimer4.timerID = setTimeout(function() { StartFilterTimer4.timerID = null; FilterData4(); }, 100);
}

function ValidarTamano4(valorC){
var valueC    = valorC.value;
var MaxCamposPag =  parseInt(document.getElementById("MaxCamposPagX4").value);

	if( ( valueC >MaxCamposPag || valueC < 1 ||  isNaN(valueC)  )){ 
		document.getElementById("tamanoCampos4").disabled= true;
		valorC.style.backgroundColor="#FF9F9F";
		
	}else{
		document.getElementById("tamanoCampos4").disabled= false;
		valorC.style.backgroundColor=""
	}
}