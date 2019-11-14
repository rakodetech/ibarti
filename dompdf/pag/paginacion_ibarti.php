<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("Helvetica");
  $size = 9;
  //RGB(34,177,76)
  $color = array(0,0,0);
  $text_height = Font_Metrics::get_font_height($font, $size);

  $foot = $pdf->open_object();
  
  $w = $pdf->get_width();
  $h = $pdf->get_height();

  // Dibuja una linea
  $y = $h - $text_height - 16;
  $pdf->line(16, $y, $w - 16, $y, $color, 0.5);

  $pdf->close_object();
  $pdf->add_object($foot, "all");

  $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";  

  // Centra el Texto
  $width = Font_Metrics::get_text_width("Pagina 1 de 2", $font, $size);
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);

  $text = "Webmaster: IBARTI.COM Correo: info@ibarti.com, wgarcia@ibarti.com Copyright 2012. All Rights Reserved";  

  $y = $h - $text_height - 32;
  
  $width = Font_Metrics::get_text_width("Webmaster: IBARTI.COM Correo: info@ibarti.com, wgarcia@ibarti.com Copyright 2012. All Rights Reserved", $font, $size);
  
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
}
</script>
