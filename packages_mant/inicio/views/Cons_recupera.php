<script language="JavaScript" type="text/javascript">
  $("#valida").on('submit', function(evt){
    evt.preventDefault();
    cambiar_clave();
    //<button id="cambiar" type="submit">Cambiar clave</button>
  })
</script>

<form id="valida" autocomplete="off" action="">
  <table width="450px" id="fase1" class="fondo01" style="background: #EAFFEA" border="1px">
    <tr>
      <td style="text-align: center; padding-top: 10px; font-weight: bold;">Ingrese su usuario (login)</td>
    </tr>
    <tr>
      <td style="text-align: center;  ">
        <input type="text" name="" id="user">
      </td>
    </tr>
    <tr>
      <td style="text-align: center;" id="cargas">
        <img src="imagenes/buscar.gif" onclick = "comprobar_usuario()"  width="24px" title="Verificar usuario">
      </td>
    </tr>

  </table>

  <table width="450px" style="display: none;background: #EAFFEA" id="fase2" border="1px">
    <tr>
      <td id="correo" height='20px' style="text-align: center;padding-top: 10px; ">        
      </td>
    </tr>
    <tr>
      <td style="text-align: center; font-weight: bold;  " >Ingrese su correo</td>
    </tr>
    <tr>
      <td style="text-align: center;  "><input type="email" name="" id="email"  ></td>
    </tr>
    <tr>
      <td style="text-align: center;  "> <img src="imagenes/buscar.gif" onclick = "enviar_mail()" title="Enviar codigo"  width="24px"></td>
    </tr>
  </table>
  <div id="cargando" style="display: none;" align="center">
    <img src="imagenes/loading.gif" style="float: center;" onclick = "enviar_mail()" title="Enviar codigo"  width="24px">
    Procesando Informacion
  </div>
  <table width="450px" style="display: none;background: #EAFFEA" id="fase3" border="1px">
    <tr>
      <td style="text-align: center; padding-top: 10px; font-weight: bold;" >Ingrese el código</td>
    </tr>
    <tr>
      <td style="text-align: center;  "><input type="text" name="" id="cod"></td>
    </tr>
    <tr>
      <td style="text-align: center;  "> <img src="imagenes/buscar.gif" onclick = "verificar_codigo()" title="Ingresar codigo" width="24px"></td>
    </tr>
  </table>

  <table width="450px" style="display: none;background: #EAFFEA" id="fase4" border="1px">
    <tr>
      <td style="text-align: center; padding-top: 10px; font-weight: bold;" >Ingrese su nueva clave</td>
    </tr>
    <tr>
      <td style="text-align: center;  "><input type="password" required="required" maxlength="11" minlength="8" id="new"  ></td>
    </tr>
    <tr>
      <td style="text-align: center; font-weight: bold;" >Confirme su clave</td>
    </tr>
    <tr>
      <td style="text-align: center;  "><input type="password" required="required" maxlength="11" minlength="8" name="" id="new-verif"  ></td>
    </tr>
    <tr>
      <td> 
       <div align="center"> 
        <span class="art-button-wrapper">
          <span class="art-button-l"> </span>
          <span class="art-button-r"> </span>
          <input id="cambiar" type="submit" title="Cambiar clave" value="Cambiar clave" class="readon art-button" />
        </span>
      </div> 
    </td>
  </tr>
</table>
<div align="left">
  <span class="art-button-wrapper">
    <span class="art-button-l"> </span>
    <span class="art-button-r"> </span>
    <input type="button" name="regresar" onclick="Cons_inicio()" value="Regresar" class="readon art-button" >
  </span>
</div>

</form>

