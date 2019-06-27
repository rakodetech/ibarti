<?php
session_start();
$usuario = $_SESSION['usuario_cod'];
$vista = (isset($_POST['view'])) ? $_POST['view'] : '';
$metodo = (isset($_POST['metodo'])) ? $_POST['metodo'] : 'agregar';
?>
<form id="form_lote" onsubmit="accionar_consulta(this.id)" method="post">

    <br />
    <label id="titulo_accion" style="text-align:center;">LISTADO DE DOTACIONES SIN PROCESAR</label>
    <img src="imagenes/buscar.bmp" style="float:right;cursor:pointer;" title="Buscar " onclick="cons_inicio('','')"></img>
    <br /><br />
    <div id="contenedor_carga">

        <div id="contendor_filtro">
            <table width="100%">
                <tr>
                    <td width="10%">Fecha Desde:</td>
                    <td width="10%"><input type="date" name="fec_d" id="fec_d"></td>
                    <td width="10%">Fecha Hasta</td>
                    <td width="10%"><input type="date" name="fec_h" id="fec_h"></td>
                    <td width="55%"></td>
                    <td width="5%" rowspan="2"><a href="javascript:consultar_listado()"><img src="imagenes/actualizar.png" width="20px" alt=""></a></td>

                </tr>

            </table>
        </div>
        <div id="listado_dotacion">
            <div class="tabla_completa">
                <table id="dotacion_in" class="tabla_sistema" border="1" width="100%">
                    <thead>
                        <tr>
                            <td colspan="5">LISTADO DE BUSQUEDA</td>
                        </tr>
                        <tr style="border:1px solid;">
                            <th>Filtro Trab.</th>
                            <th>
                                <select name="" id="filtro_in">
                                    <option value="TODOS">TODOS</option>
                                    <option value="cod_dotacion">Codigo</option>
                                    <option value="cod_ficha">Ficha</option>
                                    <option value="nombres">Trabajador</option>
                                </select></th>
                            <th>Trabajador.</th>
                            <th colspan="2"><input type="text" id="buscar_in" readonly="readonly" onkeyup="filtrado(this.value,'in')"></th>

                        </tr>

                        <tr>
                            <th>Codigo</th>
                            <th>Fecha</th>
                            <th>Ficha</th>
                            <th>Trabajador</th>
                            <th>Check</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>

            <div class="tabla_completa">

                <table id="dotacion_out" class="tabla_sistema" border="1" width="100%">
                    <thead>
                        <tr>
                            <td colspan="5">LISTADO DE SELECCION</td>
                        </tr>
                        <tr style="border:1px solid;">
                            <th>Filtro Trab.</th>
                            <th>
                                <select name="" id="filtro_out">
                                    <option value="TODOS">TODOS</option>
                                    <option value="cod_dotacion">Codigo</option>
                                    <option value="cod_ficha">Ficha</option>
                                    <option value="nombres">Trabajador</option>
                                </select></th>
                            <th>Trabajador.</th>
                            <th colspan="2"><input type="text" id="buscar_out" readonly="readonly" onkeyup="filtrado(this.value,'out')"></th>

                        </tr>
                        <tr>
                            <th>Codigo</th>
                            <th>Fecha</th>
                            <th>Ficha</th>
                            <th>Trabajador</th>
                            <th>Check</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="listado_consulta"></div>
    <div align="center"><span class="art-button-wrapper">
            <span class="art-button-l"> </span>
            <span class="art-button-r"> </span>
            <input type="submit" name="salvar" id="salvar_dotacion" value="Procesar" class="readon art-button" />
        </span>&nbsp;
        <input type="hidden" name="cod" id="cod" value="">
        <input type="hidden" name="us" id="us" value="<?php echo $usuario; ?>">
        <input type="hidden" name="vista" id="vista" value="<?php echo $vista; ?>">
        <input type="hidden" name="metodo" id="metodo" value="<?php echo $metodo; ?>">
    </div>
</form>
<style>
    .tabla_completa {
        max-height: 400px;
        max-width: 500px;
        text-align: center;
        width: 500px;
        height: 400px;
        overflow: scroll;
        overflow-y: scroll;
        overflow-x: hidden;
        margin: auto;

    }

    .tabla_completa tbody {
        border: 1px solid black;
        text-align: center;
    }


    #listado_dotacion {
        width: 100%;
        display: flex;

    }
</style>