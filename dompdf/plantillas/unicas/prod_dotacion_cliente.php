<?php
require('../' . PlantillaDOM . '/header_ibarti_2.php');
include('../' . pagDomPdf . '/paginacion_ibarti.php');
?>
<style>
    table {
        font-size: 10px;
    }

    #titulo_header {
        font-size: 13px;
    }

    .nota {
        font-size: 9px;
    }
</style>
<div style="border: 1.5px solid #1B5E20;">
    <div>
        <table style="padding-top: 5px;">
            <tbody>
                <tr>
                    <td style="padding-bottom: 3px" class="titulos" colspan="4">
                        INFORMACIÓN DOTACIÓN CLIENTE
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="etiqueta">Código: </span><span class="texto"><?php echo $row['codigo']; ?></span>
                    </td>
                    <td>
                        <span class="etiqueta">Fecha: </span><span class="texto"><?php echo $row['fec_dotacion']; ?></span>
                    </td>
                    <td><span class="etiqueta">N. <?php echo $leng['cliente']; ?>: </span>
                        <span class="texto"><?php echo $row['cliente']; ?></span>
                    </td>
                    <td><span class="etiqueta"><?php echo $leng['ubicacion']; ?>: </span><span class="texto"><?php echo $row['ubicacion']; ?></span></td>
                </tr>
                <tr>
                    <td colspan="3"><span class="etiqueta">Descripción: </span>
                        <span class="texto"><?php echo $row['descripcion']; ?></span></td>
                    <td><span class="etiqueta">ANULADO: </span>
                        <span class="texto"><?php echo $row['anulado']; ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <tbody>
                <?php
                echo "<tr style='background-color: #4CAF50;'>
            <td width='20%'><span class='etiqueta'>Linea</span></td>
            <td width='20%'><span class='etiqueta'>Sub Linea</span></td>
            <td width='25%'><span class='etiqueta'>Producto</span></td>
            <td width='5%'><span class='etiqueta'>Cantidad</span></td>
            <td width='20%'><span class='etiqueta'>Eans</span></td>
            <td width='10%'><span class='etiqueta'>Firma</span></td>
            </tr>";
                $i = 0;
                while ($producto = $bd->obtener_name($queryp)) {
                    if ($i % 2 == 0) {
                        echo "<tr>";
                    } else {
                        echo "<tr class='odd_row'>";
                    } ?>
                    <td>
                        <span class="texto"><?php echo $producto['linea']; ?></span>
                    </td>
                    <td>
                        <span class="texto"><?php echo $producto['sub_linea']; ?></span>
                    </td>
                    <td>
                        <span class="texto"><?php echo $producto['producto']; ?></span>
                    </td>
                    <td>
                        <span class="texto"><?php echo $producto['cantidad']; ?></span>
                    </td>
                    <td>
                        <span class="texto">
                            <?php
                            $sqleans = "SELECT a.cod_ean FROm ajuste_alcance_reng_eans a
                            WHERE a.cod_ajuste = " . $row['codigo'] . " AND a.reng_num = " . $producto['reng_num'] . "";
                            $queryEans = $bd->consultar($sqleans);
                            $eans = 'No Aplica';
                            $j = 0;
                            while ($ean = $bde->obtener_name($queryEans)) {
                                if ($j == 0) {
                                    $eans  = $ean['cod_ean'];
                                } else {
                                    $eans = $eans . ", " . $ean['cod_ean'];
                                }
                                ++$j;
                            }
                            echo $eans;
                            ?>
                        </span>
                    </td>
                    <!-- text-align: center; -->
                    <td style="font-size: 9px;">
                        ___________________
                    </td>
                    </tr>
                <?php ++$i;
                } ?>
            </tbody>
        </table>
    </div>
    <br>
    <table>
        <tbody>
            <tr>
                <td style="text-align: center;font-size: 9px;">
                    _________________________<br>
                    <span class="firma">Revisado Por</span><br><br>
                    _____________________<br>
                    <span class="firma"><?php echo $leng['ci']; ?></span><br><br>
                    _____________________<br>
                    <span class="firma">Firma</span>
                </td>
                <td style="text-align: center;font-size: 9px;">
                    _________________________<br>
                    <span class="firma">Recibido Por</span><br><br>
                    _____________________<br>
                    <span class="firma"><?php echo $leng['ci']; ?></span><br><br>
                    _____________________<br>
                    <span class="firma">Firma</span>
                </td>
                <td style="text-align: center;font-size: 9px;">
                    _________________________<br>
                    <span class="firma">Verificado Por</span><br><br>
                    _____________________<br>
                    <span class="firma"><?php echo $leng['ci']; ?></span><br><br>
                    _____________________<br>
                    <span class="firma">Firma</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;">
                    <span class="nota"><?php echo $row['nota_unif']; ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php
if ($bd->isConnected()) {
    $bd->liberar();
} ?>
</body>

</html>