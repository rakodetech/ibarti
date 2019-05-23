<div align="center" class="etiqueta_title"> HISTORICO PRELIMINAR </div>
<br>
<div class="listar">
    <table width="100%">
        <tr class="fondo00">
            <th>Fecha</th>
            <th>Hora</th>
            <th>Documento</th>
            <th>Evaluacion</th>
            <th>Nombre</th>
            <th>Puntaje</th>
            <th><a href="inicio.php?area=packages/nov_check_trab/index&metodo=agregar&cedula=<?php echo $cedula;?>" title="Nueva Evaluacion"><img src="imagenes/nuevo.bmp" width="30px" height="30px" alt="" ></a></th>
        </tr>
        
        <?php
        $sql = "SELECT
            nov_check_list_trab.fec_us_ing fecha,
            nov_check_list_trab.hora hora,
            nov_check_list_trab.cedula documento,
            nov_tipo.descripcion tipo,
            CONCAT(preingreso.nombres,' ',preingreso.apellidos) nombres ,
            CONCAT(ROUND((SUM(nov_check_list_trab_det.valor)/SUM(nov_check_list_trab_det.valor_max))*100),'%') porcentaje
        FROM
            nov_check_list_trab,
            nov_check_list_trab_det,
            nov_tipo,
            nov_clasif,
            preingreso
        WHERE
            nov_check_list_trab.codigo = nov_check_list_trab_det.cod_check_list
        AND
            nov_clasif.codigo = nov_check_list_trab.cod_nov_clasif
        AND	
            nov_tipo.codigo = nov_check_list_trab.cod_nov_tipo
        AND
            nov_check_list_trab.cedula = '$cedula'
        AND
            preingreso.cedula = nov_check_list_trab.cedula

         GROUP BY nov_check_list_trab.codigo    
        ";
            
        $query  = $bd->consultar($sql);
        
        while ($datos = $bd->obtener_fila($query, 0)) {
            $valor=0;
            if ($valor == 0){
                $fondo = 'fondo01';
            $valor = 1;
            }else{
                $fondo = 'fondo02';
                $valor = 0;
            }

            echo '
            <tr class="'.$fondo.'">
                <td style="text-align:center;">'.$datos[0].'</td>
                <td style="text-align:center;">'.$datos[1].'</td>
                <td  style="text-align:center;">'.$datos[2].'</td>
                <td  style="text-align:center;">'.$datos[3].'</td>
                <td  style="text-align:center;">'.$datos[4].'</td>
                <td  style="text-align:center;">'.$datos[5].'</td>
            </tr>
            ';
        }
        ?>
    </table>
</div>
<br />