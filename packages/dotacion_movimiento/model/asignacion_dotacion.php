<?php
define("SPECIALCONSTANT", true);
require  "../../../autentificacion/aut_config.inc.php";
require_once "../../../" . Funcion;
require_once  "../../../" . class_bdI;

$bd = new DataBase();
$result = array();
$cod = isset($_POST['cod']) ? $_POST['cod'] : '';
$data = isset($_POST['data']) ? json_decode($_POST['data']) : array();
$metodo = $_POST['metodo'];
$vista  = $_POST['vista'];
$usuario = $_POST['us'];

switch ($vista) {
    case 'vista_dotacion':
        switch ($metodo) {
            case 'agregar':
                if (count($data) > 0) {
                    $obs = $_POST['obs'];
                    try {
                        $sql = "INSERT INTO dotacion_proceso (cod_us_ing,fec_us_ing,cod_us_mod,fec_us_mod,status,anulado,observacion) VALUES ('$usuario',current_date,'$usuario',current_date,'01','F','$obs')";
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);

                        try {
                            $sql = "SELECT MAX(dotacion_proceso.codigo) from dotacion_proceso";
                            $query = $bd->consultar($sql);
                            $codigo = $bd->obtener_fila($query, 1)[0];
                            $values = "";
                            foreach ($data as $key => $value) {
                                if ($key > 0) {
                                    $values .= ",";
                                }
                                $values .= "('$codigo','$value','04',current_date,'$usuario',current_date,'$usuario')";
                            }
                            $sql = "INSERT INTO dotacion_proceso_det (cod_dotacion_proceso,cod_dotacion,status,fec_us_ing,cod_us_ing,fec_us_mod,cod_us_mod) VALUES " . $values;
                            $result['sql'][] = $sql;
                            $query        = $bd->consultar($sql);
                            $result['confirmacion'] = true;
                            $result['codigo'] = $codigo;
                            //code...
                        } catch (Exception $e) {
                            $error =  $e->getMessage();
                            $result['error'] = true;
                            $result['mensaje'] = $error;
                            if ($result['error'] = true) {
                                //echo $result['mensaje'];
                                $result['confirmacion'] = false;
                            }
                            //throw $th;
                        }
                        //code...
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'] = $error;
                        if ($result['error'] = true) {
                            //echo $result['mensaje'];
                        }
                        //throw $th;
                    }
                }

                break;
            case 'modificar':
                if (count($data) > 0) {
                    $values = "";
                    if ($cod != "") {
                        $result['mensaje'] = $metodo . $vista;
                        try {
                            $obs = $_POST['obs'];
                            $sql = "UPDATE dotacion_proceso SET observacion = '$obs' WHERE dotacion_proceso.codigo = '$cod'";
                            $query        = $bd->consultar($sql);
                            $sql = "DELETE FROM dotacion_proceso_det WHERE dotacion_proceso_det.cod_dotacion_proceso = '$cod'";
                            $query        = $bd->consultar($sql);
                            try {
                                foreach ($data as $key => $value) {
                                    if ($key > 0) {
                                        $values .= ",";
                                    }
                                    $values .= "('$cod','$value','04',current_date,'$usuario',current_date,'$usuario')";
                                }
                                $sql = "INSERT INTO dotacion_proceso_det (cod_dotacion_proceso,cod_dotacion,status,fec_us_ing,cod_us_ing,fec_us_mod,cod_us_mod) VALUES " . $values;
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                                $result['codigo'] = $cod;
                                //code...
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'] = $error;
                                if ($result['error'] = true) {
                                    //echo $result['mensaje'];
                                    $result['confirmacion'] = false;
                                }
                                //throw $th;
                            }
                        } catch (Exception $e) {
                            $error =  $e->getMessage();
                            $result['error'] = true;
                            $result['mensaje'] = $error;
                            if ($result['error'] = true) {
                                // echo $result['mensaje'];
                                $result['confirmacion'] = false;
                            }
                        }
                    }
                    //code...

                }
                break;
            case 'anular':
                try {
                    $sql = "UPDATE dotacion_proceso SET  
                    status = '08',
                    anulado='T',
                    fec_us_mod= current_date,
                    cod_us_mod='$usuario'
                    WHERE codigo = '$cod'
                    ";
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    $result['confirmacion'] = true;
                    /*
                    try {
                        $sql = "UPDATE dotacion_proceso_det,dotacion_proceso
                        SET 
                            dotacion_proceso_det.`status` = '08',
                        dotacion_proceso_det.fec_us_mod = CURRENT_DATE,
                         dotacion_proceso_det.cod_us_mod = '$usuario'
                        WHERE 
                            dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
                        AND 
                            dotacion_proceso.codigo = '$cod'";
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $result['confirmacion'] = true;
                        //code...
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $result['mensaje'][] = $error;
                        $result['confirmacion'] = true;
                    }
                    //code...*/
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
            case 'confirmar':
                try {
                    $sql = "UPDATE dotacion_proceso SET  
                    status = '02',
                    fec_us_mod= current_date,
                    cod_us_mod='$usuario' 
                    WHERE codigo = '$cod'
                    ";
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    $result['confirmacion'] = true;

                    //code...
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {
                        //echo $result['mensaje'];
                        $result['confirmacion'] = false;
                    }
                }
                break;
        }
        break;

    case 'vista_recepcion':
        switch ($metodo) {
            case 'agregar':
                if (count($data) > 0) {
                    try {
                        $obs = $_POST['obs'];
                        $sql = "INSERT INTO dotacion_recepcion (cod_us_ing,fec_us_ing,cod_us_mod,fec_us_mod,status,anulado,observacion) VALUES ('$usuario',current_date,'$usuario',current_date,'01','F','$obs')";
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);

                        try {
                            $sql = "SELECT MAX(dotacion_recepcion.codigo) from dotacion_recepcion";
                            $query = $bd->consultar($sql);
                            $codigo_recepcion = $bd->obtener_fila($query, 1)[0];
                            $values = "";
                            foreach ($data as $key => $value) {
                                $sql = "SELECT MAX(dotacion_proceso_det.cod_dotacion_proceso) FROM dotacion_proceso_det WHERE cod_dotacion = '$value'";
                                $query = $bd->consultar($sql);
                                $codigo_dotacion = $bd->obtener_fila($query, 1)[0];
                                if ($key > 0) {
                                    $values .= ",";
                                }
                                $values .= "('$codigo_dotacion','$codigo_recepcion','$value','06',current_date,'$usuario',current_date,'$usuario')";
                            }

                            $sql = "INSERT INTO dotacion_recepcion_det (cod_dotacion_proceso,cod_dotacion_recepcion,cod_dotacion,status,fec_us_ing,cod_us_ing,fec_us_mod,cod_us_mod) VALUES " . $values;
                            $result['sql'][] = $sql;
                            $query        = $bd->consultar($sql);


                            $result['confirmacion'] = true;
                            $result['codigo'] = $codigo_recepcion;
                            //code...
                        } catch (Exception $e) {
                            $error =  $e->getMessage();
                            $result['error'] = true;
                            $result['mensaje'] = $error;
                            if ($result['error'] = true) {
                                //echo $result['mensaje'];
                                $result['confirmacion'] = false;
                            }
                            //throw $th;
                        }
                        //code...
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'] = $error;
                        if ($result['error'] = true) {
                            //echo $result['mensaje'];
                        }
                        //throw $th;
                    }
                }

                break;
            case 'modificar':
                if (count($data) > 0) {
                    $values = "";
                    if ($cod != "") {
                        $result['mensaje'] = $metodo . $vista;
                        try {
                            $obs = $_POST['obs'];
                            $sql = "UPDATE dotacion_recepcion SET observacion = '$obs' WHERE dotacion_recepcion.codigo = '$cod'";
                            $query        = $bd->consultar($sql);
                            $sql = "DELETE FROM dotacion_recepcion_det WHERE dotacion_recepcion_det.cod_dotacion_recepcion = '$cod'";
                            $query        = $bd->consultar($sql);

                            try {

                                $values = "";
                                foreach ($data as $key => $value) {
                                    $sql = "SELECT MAX(dotacion_proceso_det.cod_dotacion_proceso) FROM dotacion_proceso_det WHERE cod_dotacion = '$value'";
                                    $query = $bd->consultar($sql);
                                    $codigo_dotacion = $bd->obtener_fila($query, 1)[0];
                                    if ($key > 0) {
                                        $values .= ",";
                                    }
                                    $values .= "('$codigo_dotacion','$cod','$value','06',current_date,'$usuario',current_date,'$usuario')";
                                }

                                $sql = "INSERT INTO dotacion_recepcion_det (cod_dotacion_proceso,cod_dotacion_recepcion,cod_dotacion,status,fec_us_ing,cod_us_ing,fec_us_mod,cod_us_mod) VALUES " . $values;
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                                $result['codigo'] = $cod;
                                //code...
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'] = $error;
                                if ($result['error'] = true) {
                                    //echo $result['mensaje'];
                                    $result['confirmacion'] = false;
                                }
                                //throw $th;
                            }
                        } catch (Exception $e) {
                            $error =  $e->getMessage();
                            $result['error'] = true;
                            $result['mensaje'] = $error;
                            if ($result['error'] = true) {
                                // echo $result['mensaje'];
                                $result['confirmacion'] = false;
                            }
                        }
                    }
                    //code...

                }
                break;
            case 'anular':
                try {
                    $sql = "UPDATE dotacion_recepcion SET  
                status = '08',
                anulado='T',
                fec_us_mod= current_date,
                cod_us_mod='$usuario'
                WHERE codigo = '$cod'
                ";
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    $result['confirmacion'] = true;
                    /*
                    try {
                        $sql = "UPDATE dotacion_recepcion_det,dotacion_recepcion
                    SET 
                        dotacion_recepcion_det.`status` = '08',
                        dotacion_recepcion_det.fec_us_mod = CURRENT_DATE,
                        dotacion_recepcion_det.cod_us_mod = '$usuario'
                    WHERE 
                        dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
                    AND 
                        dotacion_recepcion.codigo = '$cod'";
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $result['confirmacion'] = true;
                        //code...
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $result['mensaje'][] = $error;
                        $result['confirmacion'] = true;
                    }*/
                    //code...
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
            case 'confirmar':
                try {
                    $sql = "UPDATE dotacion_recepcion SET  
                    status = '02',
                    fec_us_mod= current_date,
                    cod_us_mod='$usuario' 
                    WHERE codigo = '$cod'
                    ";
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    $result['confirmacion'] = true;

                    //code...
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {
                        //echo $result['mensaje'];
                        $result['confirmacion'] = false;
                    }
                }
                break;
        }
        break;
    case 'clo':
        switch ($metodo) {
            case 'agregar_confirmacion':
                $cod_dotacion = $_POST['cod_dotacion'];
                try {
                    $sql = 'UPDATE dotacion_proceso,
                            dotacion_proceso_det
                            SET dotacion_proceso_det.`status` = "05",
                                dotacion_proceso.`status` = "03",
                            dotacion_proceso.fec_us_mod= current_date,
                            dotacion_proceso.cod_us_mod= "' . $usuario . '",
                            dotacion_proceso_det.fec_us_mod= current_date,
                            dotacion_proceso_det.cod_us_mod= "' . $usuario . '"
                            WHERE dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
                            AND dotacion_proceso.codigo =  "' . $cod . '"
                            AND dotacion_proceso_det.cod_dotacion = "' . $cod_dotacion . '"
                    ';
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    try {
                        $sql = 'SELECT COUNT(dotacion_proceso_det.codigo) 
                                    FROM dotacion_proceso,dotacion_proceso_det 
                                WHERE
                                    dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
                                AND 
                                    dotacion_proceso.codigo = "' . $cod . '" 
                                AND
                                    dotacion_proceso_det.status<>"05"
                                ';
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $contador = $bd->obtener_fila($query, 0)[0];

                        if ($contador == 0) {
                            try {
                                $sql = 'UPDATE dotacion_proceso
                                    SET dotacion_proceso.`status` = "09",
                                    dotacion_proceso.fec_us_mod= current_date,
                                    dotacion_proceso.cod_us_mod= "' . $usuario . '"
                                    WHERE dotacion_proceso.codigo =  "' . $cod . '"
                                ';
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'][] = $error;
                                if ($result['error'] = true) {

                                    $result['confirmacion'] = false;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'][] = $error;
                        if ($result['error'] = true) {

                            $result['confirmacion'] = false;
                        }
                    }
                    $result['confirmacion'] = true;
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
            case 'remover_confirmacion':
                $cod_dotacion = $_POST['cod_dotacion'];
                try {
                    $sql = 'UPDATE dotacion_proceso,
                            dotacion_proceso_det
                            SET dotacion_proceso_det.`status` = "04",dotacion_proceso.`status` = "03",
                            dotacion_proceso_det.fec_us_mod= current_date,
                            dotacion_proceso_det.cod_us_mod= "' . $usuario . '"
                            WHERE dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
                            AND dotacion_proceso.codigo =  "' . $cod . '"
                            AND dotacion_proceso_det.cod_dotacion = "' . $cod_dotacion . '"
                    ';
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    try {
                        $sql = 'SELECT COUNT(dotacion_proceso_det.codigo) 
                                    FROM dotacion_proceso,dotacion_proceso_det 
                                WHERE
                                    dotacion_proceso.codigo = dotacion_proceso_det.cod_dotacion_proceso
                                AND 
                                    dotacion_proceso.codigo = "' . $cod . '" 
                                AND
                                    dotacion_proceso_det.status="05"
                                ';
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $contador = $bd->obtener_fila($query, 0)[0];

                        if ($contador <= 0) {
                            try {
                                $sql = 'UPDATE dotacion_proceso
                                    SET dotacion_proceso.`status` = "02",
                                    dotacion_proceso.fec_us_mod= current_date,
                                    dotacion_proceso.cod_us_mod= "' . $usuario . '"
                                    WHERE dotacion_proceso.codigo =  "' . $cod . '"
                                ';
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'][] = $error;
                                if ($result['error'] = true) {

                                    $result['confirmacion'] = false;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'][] = $error;
                        if ($result['error'] = true) {

                            $result['confirmacion'] = false;
                        }
                    }
                    $result['confirmacion'] = true;
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
        }
        break;

    case 'cla':
        switch ($metodo) {
            case 'agregar_confirmacion':
                $cod_dotacion = $_POST['cod_dotacion'];
                try {
                    $sql = 'UPDATE dotacion_recepcion,
                            dotacion_recepcion_det
                            SET dotacion_recepcion_det.`status` = "07",
                                dotacion_recepcion.`status` = "03",
                            dotacion_recepcion.fec_us_mod= current_date,
                            dotacion_recepcion.cod_us_mod= "' . $usuario . '",
                            dotacion_recepcion_det.fec_us_mod= current_date,
                            dotacion_recepcion_det.cod_us_mod= "' . $usuario . '"
                            WHERE dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
                            AND dotacion_recepcion.codigo =  "' . $cod . '"
                            AND dotacion_recepcion_det.cod_dotacion = "' . $cod_dotacion . '"
                    ';
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    try {
                        $sql = 'SELECT COUNT(dotacion_recepcion_det.codigo) 
                                    FROM dotacion_recepcion,dotacion_recepcion_det 
                                WHERE
                                    dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
                                AND 
                                    dotacion_recepcion.codigo = "' . $cod . '" 
                                AND
                                    dotacion_recepcion_det.status<>"07"
                                ';
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $contador = $bd->obtener_fila($query, 0)[0];

                        if ($contador == 0) {
                            try {
                                $sql = 'UPDATE dotacion_recepcion
                                    SET dotacion_recepcion.`status` = "09",
                                    dotacion_recepcion.fec_us_mod= current_date,
                                    dotacion_recepcion.cod_us_mod= "' . $usuario . '"
                                    WHERE dotacion_recepcion.codigo =  "' . $cod . '"
                                ';
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'][] = $error;
                                if ($result['error'] = true) {

                                    $result['confirmacion'] = false;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'][] = $error;
                        if ($result['error'] = true) {

                            $result['confirmacion'] = false;
                        }
                    }
                    $result['confirmacion'] = true;
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
            case 'remover_confirmacion':
                $cod_dotacion = $_POST['cod_dotacion'];
                try {
                    $sql = 'UPDATE dotacion_recepcion,
                            dotacion_recepcion_det
                            SET dotacion_recepcion_det.`status` = "06",
                            dotacion_recepcion.`status` = "03",
                            dotacion_recepcion_det.fec_us_mod= current_date,
                            dotacion_recepcion_det.cod_us_mod= "' . $usuario . '"
                            WHERE dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
                            AND dotacion_recepcion.codigo =  "' . $cod . '"
                            AND dotacion_recepcion_det.cod_dotacion = "' . $cod_dotacion . '"
                    ';
                    $result['sql'][] = $sql;
                    $query        = $bd->consultar($sql);
                    try {
                        $sql = 'SELECT COUNT(dotacion_recepcion_det.codigo) 
                                    FROM dotacion_recepcion,dotacion_recepcion_det 
                                WHERE
                                    dotacion_recepcion.codigo = dotacion_recepcion_det.cod_dotacion_recepcion
                                AND 
                                    dotacion_recepcion.codigo = "' . $cod . '" 
                                AND
                                    dotacion_recepcion_det.status="07"
                                ';
                        $result['sql'][] = $sql;
                        $query        = $bd->consultar($sql);
                        $contador = $bd->obtener_fila($query, 0)[0];

                        if ($contador <= 0) {
                            try {
                                $sql = 'UPDATE dotacion_recepcion
                                    SET dotacion_recepcion.`status` = "02",
                                    dotacion_recepcion.fec_us_mod= current_date,
                                    dotacion_recepcion.cod_us_mod= "' . $usuario . '"
                                    WHERE dotacion_recepcion.codigo =  "' . $cod . '"
                                ';
                                $result['sql'][] = $sql;
                                $query        = $bd->consultar($sql);
                                $result['confirmacion'] = true;
                            } catch (Exception $e) {
                                $error =  $e->getMessage();
                                $result['error'] = true;
                                $result['mensaje'][] = $error;
                                if ($result['error'] = true) {

                                    $result['confirmacion'] = false;
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $error =  $e->getMessage();
                        $result['error'] = true;
                        $result['mensaje'][] = $error;
                        if ($result['error'] = true) {

                            $result['confirmacion'] = false;
                        }
                    }
                    $result['confirmacion'] = true;
                } catch (Exception $e) {
                    $error =  $e->getMessage();
                    $result['error'] = true;
                    $result['mensaje'][] = $error;
                    if ($result['error'] = true) {

                        $result['confirmacion'] = false;
                    }
                }
                break;
        }
        break;
}
echo json_encode($result);
