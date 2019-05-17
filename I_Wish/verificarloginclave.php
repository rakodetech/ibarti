<?php
/**
 * Obtiene el detalle de una asistencia especificada por
 * su identificador "idAsistencia"
 */

require 'Asistencia.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idMeta']) ){

        // Obtener parámetro idAsistencia

        $parametro = $_GET['idMeta'];
        // Tratar retorno
        $retorno = Asistencia::LOGINCLAVE($parametro);


        if ($retorno) {

            $meta["estado"] = "1";
            $meta["asistencia"] = $retorno;
            $meta["error"] = $retorno;
            // Enviar objeto json de la meta
            print json_encode($meta);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'Acceso Denegado , Usuario o Clave Incorrecto'
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

