     <form action="autentificacion/aut_verifica.inc.php" method="post" autocomplete="off" >  
      
<!--            <form action="autentificacion/captcha/ejemplo/verificacion.php" method="post">  -->
				<?php
		// Mostrar error de Autentificaci&oacute;n.
		include ("autentificacion/aut_mensaje_error.inc.php");
			if (isset($_GET['error_login'])){
				$error=$_GET['error_login'];
				echo '<script language="javascript">
					alert("Error: '.$error_login_ms[$error].'");</script>';
			}
			?>             
                        
         <table width="450px" >
             <tr class="fondo00"><td colspan="3"><div class="art-postcontent" align="center"><h3>Acceso Al Sistema IBARTI.</h3></div></td>             </tr>
               <tr  class="fondo01"><td>Usuario:</td>
                   <td><input name="login" type="text" class="campo_char" size="16" autocomplete="off" /></td>
                   <td rowspan="5"> <img src="imagenes/PadlockUserControl.png" width="150" height="150" /></td>
               </tr>
               <tr  class="fondo01"><td>Clave:</td>
                   <td><input name="pass" type="password" class="campo_char" size="16"/></td>
              </tr>
               <tr  class="fondo01"><td>Imagen De Verificacion:</td>
                   <td><img src="autentificacion/captcha/captcha.php" /></td>
              </tr>

               <tr  class="fondo01"><td>Codigo de Verificacion:</td>
                   <td>	<input type="text" size="16" name="captcha" /></td>
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
               
               </table>         
          	 </form>
	<br />