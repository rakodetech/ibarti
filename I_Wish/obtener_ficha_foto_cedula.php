<?php

$con = mysql_connect('localhost', 'root', '');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES utf8");

$cities['fichas'] = array();

if( $con )
{
    mysql_select_db('fichas');

    $res = mysql_query('select * from fichas');

    while( $row = mysql_fetch_array($res) ) {
        array_push($cities['fichas'], array(
            'id'    => $row['cod_ficha'],
            'name'  => $row['cedula'],
            'photo' => base64_encode($row['foto'])
        ));
    }
    mysql_free_result($res);
    mysql_close($con);
}

header('Content-type: application/json');
echo json_encode($cities);


