
<script language="javascript">

$("#login_form").on('submit', function(evt){
	 evt.preventDefault();
	 Ver_log();
});
</script>

<form id="login_form"  name="login_form" action="autentificacion/aut_verifica.inc.php" method="post" autocomplete="off" >
<!--            <form action="autentificacion/captcha/ejemplo/verificacion.php" method="post">  -->
         <table width="450px" >
             <tr class="fondo00"><td colspan="3"><div class="art-postcontent" align="center"><h3>Acceso Al Sistema IBARTI.</h3></div></td>             </tr>
               <tr  class="fondo01"><td>Usuario:</td>
                   <td><input name="login" id="log_us" type="text" class="campo_char" size="16" autocomplete="off" /></td>
                   <td rowspan="5"> <img src="imagenes/PadlockUserControl.png" width="150" height="150" /></td>
               </tr>
               <tr  class="fondo01"><td>Clave:</td>
                   <td ><input id="log_p" name="pass" type="password" class="campo_char" size="16"/></td>
              </tr>
               <tr  class="fondo01"><td>Verificar Captcha</span></td>
                 <td id="captcha_contenedor"></td>
              </tr>

               <tr  class="fondo01"><td>Codigo de Verificacion:</td>
                   <td>	<input type="text" size="16" id="log_cap" name="captcha" placeholder="Ingrese Captcha" /></td>
              </tr>


               <tr  class="fondo01"><td colspan="2"><div align="center"> <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>

                <input name="submit" type="submit" value="Entrar" class="readon art-button" />
                </span>&nbsp;
                <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>

                <input name="reset" type="reset" value="Cancelar" class="readon art-button" />
                </span></div></td>

               </tr>
               <tr class="fondo01"><td colspan="3" ><div align="center"><a href="#" onclick="recuperar_pass()">Recuperar Clave</a>
               </div>
               </td></tr>

               </table>
          	 </form>