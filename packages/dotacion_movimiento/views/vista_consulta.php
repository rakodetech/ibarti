<?php
require "../model/dotacion_modelo.php";

$listado        = new dotaciones;
$cod            = $_POST['cod'];
$vista = $_POST['vista'];
$existencia     = $listado->get_listado_existente($cod, $vista);

if (count($existencia) > 0) {
    $fecha = $existencia[0]['fecha_actual'];
    $anulado = $existencia[0]['anulado'];
    $obs = $existencia[0]['obs'];
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
                <span style="float:left;"><label style="font-size:24px">Codigo de Lote:<?php echo $cod ?></label><br><label style="float:left;font-size:14px">Observacion: <?php echo $obs ?></label></span>

                <label style="float:right;">Fecha Produccion:<?php echo $fecha ?></label><br>
                <label style="float:right;">Anulado:<?php echo ($anulado == 'T') ? ' SI' : ' NO' ?></label><br>

            </div>

            <div id="consulta_contenido" style="justify-content:center;">
                <br>
                <table class="tabla_sistema" id="seleccion" width="60%" border="1">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Ficha</th>
                            <th>Trabajador</th>
                            <th>Dotacion Anulada</th>
                            <?php
                            $sec = "";
                            $sec .= ($modulo_accion[0] != "") ? '<th>' . $modulo_accion[0] . '</th>' : '';
                            $sec .= ($modulo_accion[0] != "") ? '<th><input type="checkbox" title="SELECCIONAR TODO"' . ' onchange="confirmacion_lote_operaciones(\'' . $cod . '\',\'\',\'' . $vista . '\',this.checked,\'masiva\')"/></th>' : '';
                            echo $sec;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($existencia as $llave => $value) {
                            $contenido = '<tr >
                        <td>' . $value['cod_dotacion'] . '</td>
                        <td>' . $value['cod_ficha'] . '</td>
                        <td>' . $value['nombres'] . '</td>
                        <td>' . $value['dotacion_anulado'] . '</td>';

                            if ($vista == "clo") {
                                if ($modulo_accion[0] != "") {
                                    $activo = ($value['estado_detalle'] == "05") ? " checked='checked '/>" : '/>';
                                    $desabilitar = (intval($value['existe']) > 0) ? " disabled='disabled' " : '';
                                    $contenido .= "<td><input type='checkbox' value='" . $value['cod_dotacion'] . "' onchange=\"confirmacion_lote_operaciones('$cod', '" . $value["cod_dotacion"] . "', '$vista',this.checked,'normal') \"" . $desabilitar . $activo . " </td><td></td>";
                                }
                            }

                            if ($vista == "cla") {
                                if ($modulo_accion[0] != "") {
                                    $activo = ($value['estado_detalle'] == "07") ? " checked='checked'/>" : '/>';
                                    $contenido .= "<td><input type='checkbox' value='" . $value['cod_dotacion'] . "' onchange=\"confirmacion_lote_operaciones('$cod', '" . $value["cod_dotacion"] . "', '$vista',this.checked,'normal') \"" . $activo . " </td><td></td>";
                                }
                            }



                            $contenido .= '</tr>';
                            echo $contenido;
                        }
                        ?>
                    </tbody>
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
                                <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'imprimir\',\'' . $vista . '\')">
                            ';
                    }

                    if ($status[0]['sta'] == "03" || $status[0]['sta'] == "09") {
                        echo '
                                    <input type="button" id="imprimir" value="Imprimir" onclick="confirmar_consulta(\'' . $cod . '\',\'imprimir\',\'' . $vista . '\')">
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