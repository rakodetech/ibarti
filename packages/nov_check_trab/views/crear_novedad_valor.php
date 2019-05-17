<?php

require "../modelo/nov_check_trab_modelo.php";
$clasif = $_POST['clasif'];
$tipo = $_POST['tipo'];
$c_l      = new check_list;
$novedad = $c_l->obtener_novedad($clasif, $tipo);
$data = "[";
?>

<table width="100%" border="1">
    <tr style="border:1px solid; text-align:center;" >
        <td width="40%" style='border:1px solid; text-align:center;'><b>Novedad:</b></td>
        <td width="30%" style='border:1px solid; text-align:center;'><b>Valor</b></td>
        <td width="30%" style='border:1px solid; text-align:center;'><b>Observacion</b></td>
</tr>
    <tr>
        <?php
        foreach ($novedad as $index => $valor) {
            $data .=($index>0?",":"").'{"novedad":"'.$valor[1].'","valores":[';
            echo " <tr style='border:1px solid; text-align:center;'>
            <td style='border:1px solid; text-align: justify;'>$valor[1]</td>
            <td style='border:1px solid; text-align:center;'>";
            $valores = $c_l->obtener_valor($valor[0]);
            foreach ($valores as $index2 => $valor2) {
                
                $data.=($index2>0?",":"").'"'.$valor2[1].'"';
                
                echo $valor2[1].'<input type="radio" required="required" name="valores['.$valor[0].']" value="'.$valor2[0].'"> ';
            }
            $data.="]}";
            echo "</td><td style='border:1px solid; text-align:center;'><textarea name='obs[".$valor[0]."]' style='width:95%'></textarea></td></tr>";
        }
        
        $data.="]";
        ?>
        
    </tr>
    
</table>
