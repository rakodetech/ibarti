<?php
require "../model/dotacion_modelo.php";

$listado        = new dotaciones;
$cod            = $_POST['cod'];
$vista = $_POST['vista'];
$existencia     = $listado->get_listado_existente($cod, $vista);

if (count($existencia) > 0) {
    $fecha = $existencia[0]['fecha_actual'];
    $anulado = $existencia[0]['anulado'];
    $status    = $listado->comprobar_status($cod, $vista);
    $metodo = $_POST['metodo'];
    $modulo_accion = array();
    if ($vista == "clo" || $vista == "cla") {
        $modulo_accion[0] = "Confirmación";
    } else {
        $modulo_accion[0] = "";
    }

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
                <br>
                <table class="tabla_sistema" width="60%" border="1">
                    <tr>
                        <th>Codigo</th>
                        <th>Ficha</th>
                        <th>Trabajador</th>
                        <th>Dotacion Anulada</th>
                        <?php
                        echo ($modulo_accion[0] != "") ? '<th>' . $modulo_accion[0] . '</th>' : '';
                        ?>
                    </tr>
                    <?php

                    foreach ($existencia as $llave => $value) {
                        $contenido = '<tr>
                        <td>' . $value['cod_dotacion'] . '</td>
                        <td>' . $value['cod_ficha'] . '</td>
                        <td>' . $value['nombres'] . '</td>
                        <td>' . $value['dotacion_anulado'] . '</td>';

                        if($vista=="clo"){
                            if ($modulo_accion[0] != "") {
                                $activo = ($value['estado_detalle'] == "05") ? " checked='checked'/>" : '/>';
                                $contenido .= "<td><input type='checkbox' value='" . $value['cod_dotacion'] . "' onclick=\"confirmacion_lote_operaciones('$cod', '" . $value["cod_dotacion"] . "', '$vista',this.checked) \"" . $activo . " </td>";
                            }
                        }

                        if($vista=="cla"){
                            if ($modulo_accion[0] != "") {
                                $activo = ($value['estado_detalle'] == "07") ? " checked='checked'/>" : '/>';
                                $contenido .= "<td><input type='checkbox' value='" . $value['cod_dotacion'] . "' onclick=\"confirmacion_lote_operaciones('$cod', '" . $value["cod_dotacion"] . "', '$vista',this.checked) \"" . $activo . " </td>";
                            }
                        }

                        

                        $contenido .= '</tr>';
                        echo $contenido;
                    }
                    ?>
                </table>

            </div>
            <br>
            <div id="consulta_accion">
                <?php

                if ($vista != "clo" && $vista != "cla") {
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
                    
                    if ($status[0]['sta'] == "03" || $status[0]['sta'] == "09") {
                        echo '
                                    <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'confirmar\',\'' . $vista . '\')">
                                    ';
                    }
                }
            } else {
                echo '<H1>ESTE CODIGO NO EXISTE: #' . $cod . '</H1>';
            }
            ?>
            <input type="hidden" name="cod" value="<?php echo $cod; ?>">
            <input type="hidden" name="vista" value="<?php echo $vista; ?>">
        </div>
</form>