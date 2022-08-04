<?php
require "../modelo/cliente_modelo.php";
$bd = new Cliente();
$doc          = $_POST["doc"];
$cliente        = $_POST["cliente"];
$row01    = $bd->get_documento($cliente, $doc);
$url      = $row01[0];
$link     = $row01[1];

$titulo     = "Subir Imagen ";
//$img_src    = $url.$link;		
$directorio = "../imagenes/documentos_cl/";
$url_new    = "imagenes/documentos_cl/";
if (file_exists("../../../../" . $link)) {

  $img_src = $link;
} else {
  $img_src = "imagenes/img-no-disponible.png";
}
?>
<script type="text/javascript" src="upload/functions.js"></script>
<link rel="stylesheet" href="jQueryUpLoadyPHP/css/estilos.css" type="text/css" />
<link rel="stylesheet" href="upload/upload.css" type="text/css" />
<!-- <script src="Jcrop/js/jquery.min.js"></script> -->
<div align="center" class="etiqueta_title"><?php echo $titulo; ?> </div>
<hr />
<div id="Contenedor01" class="mensaje"></div>

<form enctype="multipart/form-data" class="formulario">
  <table width="100%">
    <tr>
      <td width="100%">
        <div id="contenedorImagen"><img id="fotografia" class="fotografia" src="<?php echo $img_src ?>"></div>
        <input name="archivo" type="file" id="imagen" value="Subir Imagen" /><br />
        <span class="art-button-wrapper" id="imgMostrar" style="display:none">
          <span class="art-button-l"> </span>
          <span class="art-button-r"> </span>
          <input type="button" id="subir_img" value="Subir imagen" class="readon art-button" onClick="subirImagenCliente('<?php echo $directorio; ?>')" /></span>
        <br />
        <br />
        <!--div para visualizar mensajes-->
        <div class="messages"></div><br /><br />
        <!--div para visualizar en el caso de imagen-->
        <div class="showImage"></div>
      </td>
    </tr>
  </table>
  <input name="cliente" id="cliente" type="hidden" value="<?php echo $cliente; ?>" />
  <input name="doc" id="doc" type="hidden" value="<?php echo $doc; ?>" />
  <input name="url_new" id="url_new" type="hidden" value="<?php echo $url_new; ?>" />
</form>