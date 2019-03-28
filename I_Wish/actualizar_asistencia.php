<?php
/**
 * Actualiza una meta especificada por su identificador
 */

require 'Asistencia.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);

    // Actualizar asistencia
    $retorno = Asistencia::update(
        $body['idmovil'],
        $body['cod_ficha'],
        $body['cod_cliente'],
        $body['fec_us_ing'],
        $body['cod_concepto'],
        $body['cod_ubicacion']);

    if ($retorno) {
        // Código de éxito
        print json_encode(
            array(
                'estado' => '1',
                'mensaje' => 'Actualización éxitosa')
        );
    } else {
        // Código de falla
        print json_encode(
            array(
                'estado' => '2',
                'mensaje' => 'Actualización fallida')
        );
    }
}

