<?php
/**
 * Obtiene todas las metas de la base de datos
 */

require 'Asistencia.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $asistencias = Asistencia::getAll();

    if ($asistencias) {

        $datos["estado"] = 1;
        $datos["asistencia"] = $asistencias;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

