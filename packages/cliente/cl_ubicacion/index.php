<link rel="stylesheet" type="text/css" href="latest/stylesheets/autocomplete.css" />
<style>
    /* Google Maps */

    .label {
        box-sizing: border-box;
        background: #05F24C;
        box-shadow: 2px 2px 4px #333;
        border: 5px solid #346FF7;
        height: 20px;
        width: 20px;
        border-radius: 10px;
        -webkit-animation: pulse 1s ease 1s 3;
        -moz-animation: pulse 1s ease 1s 3;
        animation: pulse 1s ease 1s 3;
    }

    .autocomplete-input-container {
        position: absolute;
        z-index: 1;
        width: 100%;
    }

    .autocomplete-input {
        text-align: center;
    }

    #my-input-autocomplete-ubic {
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
        font-size: 15px;
        border-radius: 3px;
        border: 0;
        margin-top: 10px;
        width: 290px;
        height: 40px;
        text-overflow: ellipsis;
        padding: 0 1em;
    }

    #my-input-autocomplete-ubic:focus {
        outline: none;
    }

    .autocomplete-results-ubic {
        margin: 0 auto;
        right: 0;
        left: 0;
        position: absolute;
        display: none;
        background-color: white;
        width: 80%;
        padding: 0;
        list-style-type: none;
        margin: 0 auto;
        border: 1px solid #d2d2d2;
        border-top: 0;
        box-sizing: border-box;
    }

    .autocomplete-item {
        padding: 5px 5px 5px 35px;
        height: 26px;
        line-height: 26px;
        border-top: 1px solid #d9d9d9;
        position: relative;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .autocomplete-icon {
        display: block;
        position: absolute;
        top: 7px;
        bottom: 0;
        left: 8px;
        width: 20px;
        height: 20px;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .autocomplete-icon.icon-localities {
        background-image: url(https://images.woosmap.com/icons/locality.svg);
    }

    .autocomplete-item:hover .autocomplete-icon.icon-localities {
        background-image: url(https://images.woosmap.com/icons/locality-selected.svg);
    }

    .autocomplete-item:hover {
        background-color: #f2f2f2;
        cursor: pointer;
    }

    .autocomplete-results-ubic::after {
        content: "";
        padding: 1px 1px 1px 0;
        height: 18px;
        box-sizing: border-box;
        text-align: right;
        display: block;
        background-image: url(https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white3_hdpi.png);
        background-position: right;
        background-repeat: no-repeat;
        background-size: 120px 14px
    }
</style>
<div id="Cont_ubicacion"></div>
<script type="text/javascript" src="packages/cliente/cl_ubicacion/controllers/ubicacionCtrl.js"></script>
<script type="text/javascript" src="latest/scripts/autoComplete.min.js"></script>

<div id="myModalMapUbic" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeModalMap()">&times;</span>
            <span>Mapa de Dirección</span>
        </div>
        <div class="modal-body">
            <div id="modal_contenido" style="height: 600px;">
                <!-- Search input -->
                <div class="autocomplete-input-container">
                    <div class="autocomplete-input">
                        <textarea cols="100" rows="4" id="my-input-autocomplete-ubic" placeholder="Busca una dirección" autocomplete="off" role="combobox"></textarea>
                    </div>
                    <ul class="autocomplete-results-ubic">
                    </ul>
                </div>
                <!-- Google map -->
                <div id="mapUbic" style="height: 90%;"></div>
                <span class="art-button-wrapper" id="buttonSave" style="margin-bottom: 20px; height: 40px !important;">
                    <span class="art-button-l"> </span>
                    <span class="art-button-r"> </span>
                    <input type="button" id="volver" value="Guardar" class="readon art-button" onclick="saveLatLng()" />
                </span>
            </div>
        </div>
    </div>
</div>