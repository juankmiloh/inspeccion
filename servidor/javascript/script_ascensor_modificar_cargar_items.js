jQuery(document).ready(function($){
    //alert("probando script!");
    var cod_inspeccion = getQueryVariable('cod_inspeccion');
    var cod_inspector = getQueryVariable('id_inspector');
    /* CARGAR ITEMS EN LA LISTA DE INSPECCION */
    cargarItemsEvaluacionPreliminar();
    cargarItemsProteccionPersonal();
    cargarItemsElementosDelInspector();
    cargarItemsCabina(cod_inspeccion,cod_inspector);
    cargarItemsMaquinas(cod_inspeccion,cod_inspector);
    cargarItemsPozo(cod_inspeccion,cod_inspector);
    cargarItemsFoso(cod_inspeccion,cod_inspector);
    //alert("probando script");
});

/*=============================================
* Funcion que permite capturar el valor de la variable enviada por URL
*==============================================*/
function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable) {
            return pair[1];
        }
    }
    return false;
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_preliminar y cargar los items en la lista
*==============================================*/
function cargarItemsEvaluacionPreliminar() {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_preliminar.php";
    $.getJSON(url,function(ascensor_items_preliminar){
        $.each(ascensor_items_preliminar, function(i,items){
            var numero_item = items.k_coditem_preli;
            var descripcion_item = items.o_descripcion;
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<input type="hidden" id="numero_item_preliminar'+numero_item+'" value="'+numero_item+'">'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="optionsRadiosPreliminar'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="optionsRadiosPreliminar'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="optionsRadiosPreliminar'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="optionsRadiosPreliminar'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="seleval'+valor_seleval+'" id="optionsRadiosPreliminar'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="optionsRadiosPreliminar'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="seleval'+valor_seleval+'" id="optionsRadiosPreliminar'+valor_options_radio+'" value="No Cumple" required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="optionsRadiosPreliminar'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="seleval'+valor_seleval+'" id="optionsRadiosPreliminar'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<br>'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_obser_item'+numero_item+'_eval_prel">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_obser_item'+numero_item+'_eval_prel" name="text_obser_item'+numero_item+'_eval_prel" placeholder="Ingrese aquí la observación..."></textarea>'+
                        '<br>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_evaluacion_preliminar");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_proteccion y cargar los items en la lista de inspeccion
*==============================================*/
function cargarItemsProteccionPersonal() {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_proteccion.php";
    $.getJSON(url,function(ascensor_items_proteccion){
        $.each(ascensor_items_proteccion, function(i,items){
            var numero_item = items.k_coditem;
            var descripcion_item = items.o_descripcion;
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<div class="row" style="border:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #5bc0de;">'+
                        '<input type="hidden" id="numero_item_proteccion'+numero_item+'" value="'+numero_item+'">'+
                        '<center><label>ÍTEM</label></center>'+
                    '</div>'+

                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center;">'+
                        '<br><label>'+descripcion_item+'</label><br><br>'+
                    '</div>'+

                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-right:1px solid; border-bottom:1px solid;">'+
                        '<center>'+                            
                            '<div class="row">'+
                                '<div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #5bc0de;">'+
                                    '<label>INSPECTOR</label>'+
                                '</div>'+
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">C</label>'+
                                '</div>';
                                valor_for_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">NC</label>'+
                                '</div>';
                                valor_for_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">N/A</label>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row">'+
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="Si Cumple" required>'+
                                    '</label>'+
                                '</div>';
                                valor_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="No Cumple" required>'+
                                    '</label>'+
                                '</div>';
                                valor_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="No Aplica"  required>'+
                                    '</label>'+
                                '</div>'+
                            '</div>'+
                        '</center>'+
                    '</div>'+

                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">'+
                        '<center>'+                           
                            '<div class="row">'+
                                '<div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #5bc0de;">'+
                                    '<label>EMPRESA MANTO</label>'+
                                '</div>';
                                valor_for_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">C</label>'+
                                '</div>';
                                valor_for_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">NC</label>'+
                                '</div>';
                                valor_for_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">'+
                                    '<label for="options_protec_person'+valor_for_options_radio+'">N/A</label>'+
                                '</div>'+
                            '</div>'+

                            '<div class="row">';
                                valor_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'_'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="Si Cumple" required>'+
                                    '</label>'+
                                '</div>';
                                valor_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'_'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="No Cumple"  required>'+
                                    '</label>'+
                                '</div>';
                                valor_options_radio += 1;
                                contenidoDiv +=
                                '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                                    '<label>'+
                                        '<input type="radio" name="sele_protec_person'+numero_item+'_'+numero_item+'" id="options_protec_person'+valor_options_radio+'" value="No Aplica" required>'+
                                    '</label>'+
                                '</div>'+
                            '</div>'+
                        '</center>'+
                    '</div>'+

                    '<div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">'+
                        '<hr>'+
                        '<center><label for="text_obser_protec_person'+numero_item+'">OBSERVACIONES</label></center>'+
                        '<center><textarea class="form-control" rows="3" id="text_obser_protec_person'+numero_item+'" name="text_obser_protec_person'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea></center>'+
                        '<br>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_elementos_proteccion_personal");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_elementos y cargar los items en la lista de inspeccion
*==============================================*/
function cargarItemsElementosDelInspector() {
    var valor_seleval = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_elementos.php";
    $.getJSON(url,function(ascensor_items_elementos){
        $.each(ascensor_items_elementos, function(i,items){
            //addItemsAscensorItemsElementos(items.k_coditem,items.o_descripcion);
            var numero_item = items.k_coditem;
            var descripcion_item = items.o_descripcion;
            var contenidoDiv = 
            '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; height: 7em;">'+
                '<input type="hidden" id="numero_item_element_inspec'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="descrip_item_element_inspec'+numero_item+'" value="'+descripcion_item+'">'+
                '<label style="margin: 3%; padding: 3%;">'+descripcion_item+'</label>'+
            '</div>';
            $(contenidoDiv).appendTo("#items_elementos_del_inspector");

            var contenidoDiv_1 =
            '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; height: 7em;">'+
                '<label for="options_element_inpec'+valor_options_radio+'" style="margin-top: 2.5em; width: 100%; height: 50%;">'+
                    '<input type="radio" name="sele_element_inspec'+valor_seleval+'" id="options_element_inpec'+valor_options_radio+'" value="Si Cumple"  required>'+
                '</label>'+
            '</div>';
            valor_options_radio += 1;
            contenidoDiv_1 +=
            '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; height: 7em;">'+
                '<label for="options_element_inpec'+valor_options_radio+'" style="margin-top: 2.5em; width: 100%; height: 50%;">'+
                    '<input type="radio" name="sele_element_inspec'+valor_seleval+'" id="options_element_inpec'+valor_options_radio+'" value="No Cumple" required>'+
                '</label>'+
            '</div>';
            valor_options_radio += 1;
            contenidoDiv_1 +=
            '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; height: 7em;">'+
                '<label for="options_element_inpec'+valor_options_radio+'" style="margin-top: 2.5em; width: 100%; height: 50%;">'+
                    '<input type="radio" name="sele_element_inspec'+valor_seleval+'" id="options_element_inpec'+valor_options_radio+'" value="No Aplica" required>'+
                '</label>'+
            '</div>';
            $(contenidoDiv_1).appendTo("#items_elementos_del_inspector_1");
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_cabina y cargar los items en la lista
*==============================================*/
function cargarItemsCabina(cod_inspeccion,cod_inspector) {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_cabina.php";
    $.getJSON(url,function(ascensor_items_cabina){
        $.each(ascensor_items_cabina, function(i,items){
            var numero_item = items.k_coditem_cabina;
            var valor_Item = items.v_item;
            var descripcion_item = items.o_descripcion;
            var clasificacion_item = items.v_clasificacion;
            if (clasificacion_item == "Leve") {
                clasificacion_item = "L";
            }
            if (clasificacion_item == "Grave") {
                clasificacion_item = "G";
            }
            if (clasificacion_item == "Muy Grave") {
                clasificacion_item = "MG";
            }
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<input type="hidden" id="numero_item_cabina'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_cabina'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>#</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>'+valor_Item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>"'+clasificacion_item+'"</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>DEFECTO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_cabina'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_cabina'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_cabina'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_cabina'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_cabina'+valor_seleval+'" id="sele_lv_cabina'+valor_options_radio+'" value="Si Cumple" >'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_cabina'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_cabina'+valor_seleval+'" id="sele_lv_cabina'+valor_options_radio+'" value="No Cumple"  required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_cabina'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_cabina'+valor_seleval+'" id="sele_lv_cabina'+valor_options_radio+'" value="No Aplica">'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_lv_valor_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_lv_valor_observacion_'+numero_item+'" name="text_lv_valor_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
                        '<br>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="botonIniciar'+numero_item+'">REGISTRO FOTOGRÁFICO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<a href="./ascensor_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
                            '<button type="button" id="botonIniciar'+numero_item+'" class="btn btn-default sombra" disabled>'+
                                '<span class="glyphicon glyphicon-camera"></span>'+
                                ' Ver Fotografías'+
                            '</button>'+
                        '</a>'+
                        '<br><br>'+                 
                    '</div>'+
                '</div>'+
            '</div>'+
            
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_cabina");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_maquinas y cargar los items en la lista
*==============================================*/
function cargarItemsMaquinas(cod_inspeccion,cod_inspector) {
    var valor_seleval = 36;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_maquinas.php";
    $.getJSON(url,function(ascensor_items_maquinas){
        $.each(ascensor_items_maquinas, function(i,items){
            //addItemsAscensorItemsMaquinas(items.k_coditem_maquinas,items.v_item,items.o_descripcion,items.v_clasificacion);
            var numero_item = items.k_coditem_maquinas;
            var valor_Item = items.v_item;
            var descripcion_item = items.o_descripcion;
            var clasificacion_item = items.v_clasificacion;
            if (clasificacion_item == "Leve") {
                clasificacion_item = "L";
            }
            if (clasificacion_item == "Grave") {
                clasificacion_item = "G";
            }
            if (clasificacion_item == "Muy Grave") {
                clasificacion_item = "MG";
            }
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<input type="hidden" id="numero_item_maquinas'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_maquinas'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>#</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>'+valor_Item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>"'+clasificacion_item+'"</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>DEFECTO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_maquinas'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_maquinas'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_maquinas'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maquinas'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maquinas'+valor_seleval+'" id="sele_lv_maquinas'+valor_options_radio+'" value="Si Cumple" >'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maquinas'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maquinas'+valor_seleval+'" id="sele_lv_maquinas'+valor_options_radio+'" value="No Cumple" required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maquinas'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maquinas'+valor_seleval+'" id="sele_lv_maquinas'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_maquinas_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_maquinas_observacion_'+numero_item+'" name="text_maquinas_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
                        '<br>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="botonIniciar'+numero_item+'">REGISTRO FOTOGRÁFICO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<a href="./ascensor_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
                            '<button type="button" id="botonIniciar'+numero_item+'" class="btn btn-default sombra" disabled>'+
                                '<span class="glyphicon glyphicon-camera"></span>'+
                                ' Ver Fotografías'+
                            '</button>'+
                        '</a>'+
                        '<br><br>'+                 
                    '</div>'+
                '</div>'+
            '</div>'+
            
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_maquinas");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_pozo y cargar los items en la lista
*==============================================*/
function cargarItemsPozo(cod_inspeccion,cod_inspector) {
    var valor_seleval = 83;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_pozo.php";
    $.getJSON(url,function(ascensor_items_pozo){
        $.each(ascensor_items_pozo, function(i,items){
            var numero_item = items.k_coditem_pozo;
            var valor_Item = items.v_item;
            var descripcion_item = items.o_descripcion;
            var clasificacion_item = items.v_clasificacion;
            if (clasificacion_item == "Leve") {
                clasificacion_item = "L";
            }
            if (clasificacion_item == "Grave") {
                clasificacion_item = "G";
            }
            if (clasificacion_item == "Muy Grave") {
                clasificacion_item = "MG";
            }
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<input type="hidden" id="numero_item_pozo'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_pozo'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>#</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>'+valor_Item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>"'+clasificacion_item+'"</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>DEFECTO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_pozo'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_pozo'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_pozo'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_pozo'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_pozo'+valor_seleval+'" id="sele_lv_pozo'+valor_options_radio+'" value="Si Cumple" >'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_pozo'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_pozo'+valor_seleval+'" id="sele_lv_pozo'+valor_options_radio+'" value="No Cumple" required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_pozo'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_pozo'+valor_seleval+'" id="sele_lv_pozo'+valor_options_radio+'" value="No Aplica">'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_pozo_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_pozo_observacion_'+numero_item+'" name="text_pozo_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
                        '<br>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="botonIniciar'+numero_item+'">REGISTRO FOTOGRÁFICO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<a href="./ascensor_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
                            '<button type="button" id="botonIniciar'+numero_item+'" class="btn btn-default sombra" disabled>'+
                                '<span class="glyphicon glyphicon-camera"></span>'+
                                ' Ver Fotografías'+
                            '</button>'+
                        '</a>'+
                        '<br><br>'+                 
                    '</div>'+
                '</div>'+
            '</div>'+
            
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_pozo");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_items_foso y cargar los items en la lista
*==============================================*/
function cargarItemsFoso(cod_inspeccion,cod_inspector) {
    var valor_seleval = 148;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_ascensor_items_foso.php";
    $.getJSON(url,function(ascensor_items_foso){
        $.each(ascensor_items_foso, function(i,items){
            var numero_item = items.k_coditem_foso;
            var valor_Item = items.v_item;
            var descripcion_item = items.o_descripcion;
            var clasificacion_item = items.v_clasificacion;
            if (clasificacion_item == "Leve") {
                clasificacion_item = "L";
            }
            if (clasificacion_item == "Grave") {
                clasificacion_item = "G";
            }
            if (clasificacion_item == "Muy Grave") {
                clasificacion_item = "MG";
            }
            var contenidoDiv = 
            '<div class="container-fluid">'+
                '<input type="hidden" id="numero_item_foso'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_foso'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>#</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>'+valor_Item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>"'+clasificacion_item+'"</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>DEFECTO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_foso'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_foso'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_foso'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_foso'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_foso'+valor_seleval+'" id="sele_lv_foso'+valor_options_radio+'" value="Si Cumple" >'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_foso'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_foso'+valor_seleval+'" id="sele_lv_foso'+valor_options_radio+'" value="No Cumple" required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_foso'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_foso'+valor_seleval+'" id="sele_lv_foso'+valor_options_radio+'" value="No Aplica">'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_foso_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_foso_observacion_'+numero_item+'" name="text_foso_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
                        '<br>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="botonIniciar'+numero_item+'">REGISTRO FOTOGRÁFICO</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<a href="./ascensor_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
                            '<button type="button" id="botonIniciar'+numero_item+'" class="btn btn-default sombra" disabled>'+
                                '<span class="glyphicon glyphicon-camera"></span>'+
                                ' Ver Fotografías'+
                            '</button>'+
                        '</a>'+
                        '<br><br>'+                 
                    '</div>'+
                '</div>'+
            '</div>'+
            
            '<br>'+
            '<div class="divisionItems sombra"></div>'+
            '<br>';
            $(contenidoDiv).appendTo("#items_foso");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}