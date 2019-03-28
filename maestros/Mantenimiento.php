<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- Copyright (c) 2006-2007. Adobe Systems Incorporated. All rights reserved. -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Spry Effects Notification mechanism Sample</title>

 
<script src="../spry/includes/SpryEffects.js" type="text/javascript"></script>
<!-- Fondo-->
<script language="javascript" type="text/javascript" src="../funciones/funciones.js"></script>
<script language="javascript" type="text/javascript" src="../spry/includes/xpath.js"></script>
<script language="javascript" type="text/javascript" src="../spry/includes/SpryData.js"></script>


<style type="text/css">

.animationContainer{
	height: 420px;
	width: 670px;
}

/*   DAtos*/
.demoDiv{
	background-color: #FFFFFF; 
	height: 420px;
	width: 700px;
	border: 1px solid black;
	margin-left: 1px;
	overflow: hidden;
}

.demoDiv1 {	background-color: #CCC; 
	height: 420px;
	width: 700px;
	border: 1px solid black;
	margin-left: 1px;
	overflow: hidden;
}

th{
font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 15px;
	color:#000066;
}
.fondo {
	background-image:url(../imagenes/fondoAm.jpg);
	background-repeat:repeat-y;
	cursor:pointer; 
}

.td_1{
    font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color:#000066;
    text-decoration: none; 
}

.td_2{ font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color:#000000;
}

</style>
</head>
<body onload="parallel_cluster.start();">

<div class="animationContainer">
  <div id="parallel_cluster" class="demoDiv">
    <table width="700" border="1">
      <tr>
        <th colspan="3"> MENU DE MANTENIMIENTO DE BASE DE DATOS</th>
      </tr>
      <tr id="1" onmouseover="Fondo('1','over')" onmouseout="Fondo('1','out')" 
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Centros')">
        <td width="8%"><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td width="30%"><span class="td_1"> Centros </span></td>
        <td width="62%" class="td_2">Mantenimiento de la tabla Centros </td>
      </tr>
      <tr id="2" onmouseover="Fondo('2','over')" onmouseout="Fondo('2','out')" 
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Estado_Civil')">
        <td><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td><span class="td_1">Estado Civil </span></td>
        <td class="td_2"> Mantenimiento de la tabla Estado Civil </td>
      </tr>
      <tr id="3" onmouseover="Fondo('3','over')" onmouseout="Fondo('3','out')"  
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Nivel_Educativo')">
        <td><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td><span class="td_1">Nivel Educativo</span></td>
        <td class="td_2"> Mantenimiento de la tabla Nivel Educativo </td>
      </tr>
      <tr id="4" onmouseover="Fondo('4','over')" onmouseout="Fondo('4','out')"  
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Tipo_Empleado')">
        <td><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td><span class="td_1">Tipo de Empleado</span></td>
        <td class="td_2"> Mantenimiento de la tabla Tipo de Empleado</td>
      </tr>
      <tr id="5" onmouseover="Fondo('5','over')" onmouseout="Fondo('5','out')"  
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Tipo_Suplencia')">
        <td><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td><span class="td_1">Tipo de Suplencia</span></td>
        <td class="td_2"> Mantenimiento de la tabla Tipo de Suplencia</td>
      </tr>	  
      <tr id="6" onmouseover="Fondo('6','over')" onmouseout="Fondo('6','out')"  
	             onclick="Vinculo('pl_Mantenimiento.php?area=Cons_Grado')">
        <td><img src="../imagenes/consultar.png" alt="Consultar" title="Consultar" /></td>
        <td><span class="td_1">Grado</span></td>
        <td class="td_2"> Mantenimiento de la tabla Grado de Empleados</td>
      </tr>	  
</table>
 
  </div>
</div>

<script type="text/javascript">
	var my_cluster = function(element)
	{
		Spry.Effect.Cluster.call(this, {toggle: true});

		this.name = 'my_cluster';
		var resize_hor = new Spry.Effect.Size(element, {width:10, height: 10, units:'px'}, {width:700, height: 10, units:'px'}, {duration: 500, toggle: true});
		this.addNextEffect(resize_hor);

		var resize_ver = new Spry.Effect.Size(element, {width:700, height: 10, units:'px'}, {width:700, height: 420, units:'px'}, {duration: 500, toggle: true});
		this.addNextEffect(resize_ver);
	}
	
	my_cluster.prototype = new Spry.Effect.Cluster();
	my_cluster.prototype.constructor = my_cluster;


	var parallel_cluster = new Spry.Effect.Cluster({toggle:true});
	
	var previous_cluster = new my_cluster("parallel_cluster");
	parallel_cluster.addParallelEffect(previous_cluster);

	var hilite = new Spry.Effect.Highlight("parallel_cluster", {duration: 3000, to: "#E3E2E1", toggle: true});
	parallel_cluster.addParallelEffect(hilite);
</script>

</body>
</html>
