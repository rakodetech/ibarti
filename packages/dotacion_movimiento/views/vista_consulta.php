<?php
require "../model/dotacion_modelo.php";

$listado        = new dotaciones;
$cod            = $_POST['cod'];

$existencia     = $listado->get_listado_existente($cod);
if (count($existencia) > 0) {
    $fecha = $existencia[0]['fecha_actual'];
    $anulado = $existencia[0]['anulado'];
    $status    = $listado->comprobar_status($cod);
    $vista = $_POST['vista'];
    $metodo = $_POST['metodo'];

    //echo json_encode($existencia);
    ?>
    <form action="reportes/rp_dotacion_formato.php" id="reporte_dotacion" method="post" target="_blank">
        <div id="consultar_listado">
            <div id="consulta_cabecera" style="width:60%">
                <label style="float:left;font-size:24px">Codigo de Lote:<?php echo $cod ?></label>
                <label style="float:right;">Fecha Produccion:<?php echo $fecha ?></label><br>
                <label style="float:right;">Anulado:<?php echo ($anulado == 'T') ? ' SI' : ' NO' ?></label><br>

            </div>

            <div id="consulta_contenido" style="justify-content:center;">
                <table class="tabla_sistema" width="60%" border="1">
                    <tr>
                        <th>Codigo</th>
                        <th>Ficha</th>
                        <th>Trabajador</th>
                    </tr>
                    <?php

                    foreach ($existencia as $llave => $value) {
                        echo '
                <tr>
                    <td>' . $value['cod_dotacion'] . '</td>
                    <td>' . $value['cod_ficha'] . '</td>
                    <td>' . $value['nombres'] . '</td>
                </tr>
            ';
                    }
                    ?>
                </table>

            </div>
            <br>
            <div id="consulta_accion">
                <?php
                switch ($vista) {
                    case 'vista_dotacion':

                        if ($status[0]['sta'] == "01") {
                            echo '
                                <input type="button" id="anulado" value="Anular" onclick="confirmar_consulta(\'' . $cod . '\',\'anular\',\'' . $vista . '\')">
                                <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'confirmar\',\'' . $vista . '\')">
                                <input type="button" id="modificar" value="Modificar" onclick="confirmar_consulta(\'' . $cod . '\',\'modificar\',\'' . $vista . '\')">
                            ';
                        }
                        if ($status[0]['sta'] == "02") {
                            echo '
                        <input type="button" id="anulado" value="Anular" onclick="confirmar_consulta(\'' . $cod . '\',\'anular\',\'' . $vista . '\')">
                        <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'confirmar\',\'' . $vista . '\')">
                    ';
                        }

                        if ($status[0]['sta'] == "03") {
                            echo '
                            <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'confirmar\',\'' . $vista . '\')">
                            ';
                        }

                        break;
                }
            } else {
                echo '<H1>ESTE CODIGO NO EXISTE: #' . $cod . '</H1>';
            }
            ?>
            <input type="hidden" name="cod" value="<?php echo $cod;?>">
            <input type="hidden" name="vista" value="<?php echo $vista;?>">
        </div>
</form>