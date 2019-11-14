<?php 
$ci           = $_GET["ci"]; 
$img_nomb     = $usuario;
$img_nomb_dst = $ci;
$imgURL = "imagenes/temp/";
$ext    = "jpg"; 
$tipo   = $_GET["tipo"];
if( $tipo == "01"){
$dst_w  = "200";
$dst_h  = "240";	
$imgDST = "imagenes/fotos/";
  $img_src = "imagenes/foto.jpg";

}elseif ( $tipo == "02"){
  $imgDST = "imagenes/cedula/";
  $img_src =  "imagenes/cedula.jpg";
$dst_w  = "410";
$dst_h  = "280";
	}else{
	 exit;
	}

?>
<!DOCTYPE html>
 <html lang="es"> 
<head>
<title>:: upLoad de Archivos con ajax ::</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="jQueryUpLoadyPHP/css/estilos.css" type="text/css" />
<script src="Jcrop/js/jquery.min.js"></script>
<script src="jQueryUpLoadyPHP/js/AjaxUpload.2.0.min.js"></script>
<script src="Jcrop/js/jquery.Jcrop.js"></script>
</head>
<script>
    $(function() {
    	// Botón para subir la firma
	   var img_url = $('#x1').val;
		var btn_firma = $('#addImage'), interval;
			new AjaxUpload('#addImage', {
				action: 'jQueryUpLoadyPHP/includes/uploadFile.php?valor=<?php echo $img_nomb;?>&imgURL=../../<?php echo $imgURL;?>',
				onSubmit : function(file , ext){
					if (! (ext && /^(jpg|png)$/.test(ext))){
						// extensiones permitidas
						alert('Sólo se permiten Imagenes .jpg o .png');
						// cancela upload
						return false;
					} else {
						document.getElementById('ext').value = ext;
						$('#loaderAjax').show();
						btn_firma.text('Espere por favor');
						this.disable();
					}
				},
				onComplete: function(file, response){
					// alert(response);
					
					btn_firma.text('Cambiar Imagen');
					
					respuesta = $.parseJSON(response);

					if(respuesta.respuesta == 'done'){
						$('#fotografia').removeAttr('scr');
					//	$('#fotografia').attr('src','jQueryUpLoadyPHP/images/' + respuesta.fileName);
						$('#fotografia').attr('src','<?php echo $imgURL;?>' + respuesta.fileName);	
					//	$('#preview').removeAttr('scr');
						$('#loaderAjax').show();						
						document.getElementById('subida').value = "SI";
						 prueba();							
						 	
					}
					else{
						alert(respuesta.mensaje);
					}
						
					$('#loaderAjax').hide();	
					
					this.enable();	
				}
		});
    });
</script>
<script type="text/javascript">
  function prueba(){
	  
  jQuery(function($){
    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
     //   boundx,
      //  boundy,
        // Grab some information about the preview pane
     //   $preview = $('#preview-pane'),
      //  $pcnt = $('#preview-pane .preview-container'),
      //  $pimg = $('#preview-pane .preview-container img'),
     //   xsize = $pcnt.width(),
      // ysize = $pcnt.height();
       xsize = document.getElementById('dst_w').value, 
      ysize = document.getElementById('dst_h').value ;
	   // alert(xsize);
	   // alert(size); 
    
    console.log('init',[xsize,ysize]);
    $('#fotografia').Jcrop({
      onChange: updatePreview,
      onSelect: updatePreview,
	   onRelease:  clearCoords,
      aspectRatio: xsize / ysize
    },function(){
      // Use the API to get the real image size
   //   var bounds = this.getBounds();
    //  boundx = bounds[0];
     // boundy = bounds[1];
      // Store the API in the jcrop_api variable
      jcrop_api = this;

      // Move the preview into the jcrop container for css positioning
   //    $preview.appendTo(jcrop_api.ui.holder);
    });
	
	
	  $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

    function updatePreview(c)
    {
	
	$('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);		
	/*
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;
        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      } */
    };

  function clearCoords(){
    $('#x1').val('');
    $('#y1').val('');
    $('#x2').val('');
    $('#y2').val('');
    $('#w').val('');
    $('#h').val('');  
  };

  });
  
  };  
      
  function SaveImg(){
	var Contenedor = "Contenedor01";
	var valor   = "jQueryUpLoadyPHP/includes/red_img.php"; 


	var ext      = document.getElementById('ext').value;
	var img_nomb  = document.getElementById('img_nomb').value;
	var img_nomb_dst  = document.getElementById('img_nomb_dst').value;
	var imgURL  = document.getElementById('imgURL').value;
	var imgDST  = document.getElementById('imgDST').value;
    var imgURL   = imgURL+img_nomb+"."+ext; 
    var imgDST   = imgDST+img_nomb_dst+"."+ext;
	var dst_w   = document.getElementById('dst_w').value;   
	var dst_h   = document.getElementById('dst_h').value;
	var x1      = document.getElementById('x1').value;
	var x2      = document.getElementById('x2').value;
	var y1      = document.getElementById('y1').value;
	var y2      = document.getElementById('y2').value;
	var w      = document.getElementById('w').value;
	var h      = document.getElementById('h').value;


	var subida  = document.getElementById('subida').value;
	
	var campo01 = 1; 
    var errorMessage = 'Debe Seleccionar Todo Los Campos';

     if(subida!='SI') {
     var errorMessage = 'Debe Subir Una Imagen';	 
	 var campo01 = campo01+1; 
	}  


	if(campo01 == 1){

	
	ajax=nuevoAjax();
	
		ajax.open("POST", valor, true);
		ajax.onreadystatechange=function()  
		{ 
			if (ajax.readyState==4){					
			document.getElementById(Contenedor).innerHTML = ajax.responseText;
			Mensaje();
			
			}
		} 
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");			
	ajax.send("imgURL="+imgURL+"&imgDST="+imgDST+"&dst_w="+dst_w+"&dst_h="+dst_h+"&x1="+x1+"&x2="+x2+"&y1="+y1+"&y2="+y2+"&w="+w+"&h="+h+"");
	}else{
	alert(errorMessage);
	 }
}    

/*
  function ClasifIMG(){
	 var valor = document.getElementById('tipo').value;

	 	
	 if(valor==''){	  	

	
		 alert("Debe Seleccionar Un Tipo de Imagen");
		}else if(valor == "01"){

		 var w = 200;
		 var h =  240;
		 var imgDST = "imagenes/fotos/";
		 document.getElementById('imgDST').value = imgDST;
	 	 document.getElementById('dst_w').value = w;
	 	 document.getElementById('dst_h').value = h;
	
		}else if(valor == "02"){

		 var w = 410;
		 var h =  308;
	 	 var imgDST = "imagenes/cedula/";
		 document.getElementById('imgDST').value = imgDST;
	 	 document.getElementById('dst_w').value = w;
	 	 document.getElementById('dst_h').value = h;
		}
		
		 var img_nomb_dst = document.getElementById('img_nomb_dst').value;
	 	 var ext          = "jpg";
    	 var src          = ""+imgDST+img_nomb_dst+"."+ext;		 
		 
	
			 
		 var puntero = document.getElementById('preview');
             puntero.removeAttribute('src');
			 puntero.setAttribute('src', src);
		//	$('#preview').removeAttr('scr');
		//	$('#preview').attr('src',src);	
	}
	
	*/ 
	  function Mensaje(){
		  
	 var valor = document.getElementById('mensaje').value;
	  var valor = document.getElementById('mensaje').value;
// 	 var imgDST = document.getElementById('imgDST').value;
//	 var img_nomb_dst = document.getElementById('img_nomb_dst').value;
//	 var ext          = "jpg";
//	 var src          = ""+imgDST+img_nomb_dst+"."+ext;		 
	 alert(valor);
	 Vinculo('inicio.php?area=formularios/add_imagenes&ci=<?php echo $ci;?>');

//		 var puntero=document.getElementById('preview');
 //            puntero.removeAttribute('src');
//			 puntero.setAttribute('src', src);
//	$('#preview').removeAttr('scr');
//	$('#preview').attr('src',src);	
//		 var puntero=document.getElementById('preview');
 //            puntero.removeAttribute('src');
//			 puntero.setAttribute(src);

	} 
</script>
<link rel="stylesheet" href="Jcrop/css/jquery.Jcrop.css" type="text/css" />
<div id="Contenedor01" class="mensaje"></div>
<!--
<label>Seleccione Tipo<select name="tipo" id="tipo" style="width:150px" onChange="ClasifIMG()">
      	<option value="">Seleccione...</option>
        <option value="01">Foto</option>
        <option value="02">Cedula</option>
</select></label>   -->
<table width="100%">
    <tr><td width="60%"><div id="contenedorImagen">
                    <img id="fotografia" class="fotografia" src="<?php echo $img_src?>"></div>
                <span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span> 
                      <input type="button" id="addImage"  value="Subir Imagen" class="readon art-button" />	
                </span>
                <div class="loaderAjax" id="loaderAjax">
                    <img src="">
                    <span>Publicando Fotografía...</span>
                </div></td>
    <td width="40%"><img id="preview" src="">       
    </td></tr>
	<tr><td>&nbsp;</td><td><div align="center"><span class="art-button-wrapper">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span> 
                      <input type="button" id="saveImg" onClick="SaveImg()" value="Guardar Imagen" class="readon art-button" />	
                </span></div></td></tr> 
</table>	    
    <div class="inline-labels">
    <input type="hidden" size="4" id="x1" name="x1" /> 
    <input type="hidden" size="4" id="y1" name="y1" />
    <input type="hidden" size="4" id="x2" name="x2" />
    <input type="hidden" size="4" id="y2" name="y2" />
    <input type="hidden" size="4" id="w" name="w" />
    <input type="hidden" size="4" id="h" name="h" />
    <input type="hidden"  id="imgURL" name="imgURL" value="<?php echo $imgURL;?>" />  
    <input type="hidden"  id="imgDST" name="imgDST" value="<?php echo $imgDST;?>" /> 
    <input type="hidden" id="dst_w" name="dst_w" value="<?php echo $dst_w;?>" />  
    <input type="hidden" id="dst_h" name="dst_h" value="<?php echo $dst_h;?>" /> 
    <input type="hidden" id="img_nomb" name="img_nomb" value="<?php echo $img_nomb;?>" />
    <input type="hidden" id="img_nomb_dst" name="img_nomb_dst" value="<?php echo $img_nomb_dst;?>"/>
    <input type="hidden" id="ext" name="ext" value="<?php echo $ext;?>"/> 
    <input type="hidden" id="subida" name="subida" value="NO"/>  
    
    </div>