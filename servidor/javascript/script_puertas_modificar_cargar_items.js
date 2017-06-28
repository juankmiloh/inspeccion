jQuery(document).ready(function($){
    //alert("probando script!");
    var cod_inspeccion = getQueryVariable('cod_inspeccion');
    var cod_inspector = getQueryVariable('id_inspector');
    /* CARGAR ITEMS EN LA LISTA DE INSPECCION */
    cargarItemsEvaluacionPreliminar();
    cargarItemsProteccionPersonal();
    cargarItemsElementosDelInspector();
    cargarItemsMecanicos(cod_inspeccion,cod_inspector);
    cargarItemsElectrica(cod_inspeccion,cod_inspector);
    cargarItemsMotorizacion(cod_inspeccion,cod_inspector);
    cargarItemsOtras(cod_inspeccion,cod_inspector);
    cargarItemsManiobras(cod_inspeccion,cod_inspector);
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
* Funcion para hacer un select a la tabla puertas_items_preliminar y cargar los items en la lista
*==============================================*/
function cargarItemsEvaluacionPreliminar() {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_preliminar.php";
    $.getJSON(url,function(puertas_items_preliminar){
        $.each(puertas_items_preliminar, function(i,items){
            var numero_item = items.k_coditem;
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
* Funcion para hacer un select a la tabla puertas_items_proteccion y cargar los items en la lista de inspeccion
*==============================================*/
function cargarItemsProteccionPersonal() {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_proteccion.php";
    $.getJSON(url,function(puertas_items_proteccion){
        $.each(puertas_items_proteccion, function(i,items){
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
* Funcion para hacer un select a la tabla puertas_items_elementos y cargar los items en la lista de inspeccion
*==============================================*/
function cargarItemsElementosDelInspector() {
    var valor_seleval = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_elementos.php";
    $.getJSON(url,function(puertas_items_elementos){
        $.each(puertas_items_elementos, function(i,items){
            //addItemspuertasItemsElementos(items.k_coditem,items.o_descripcion);
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
* Funcion para hacer un select a la tabla puertas_items_mecanicos y cargar los items en la lista
*==============================================*/
function cargarItemsMecanicos(cod_inspeccion,cod_inspector) {
    var valor_seleval = 1;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_mecanicos.php";
    $.getJSON(url,function(puertas_items_mecanicos){
        $.each(puertas_items_mecanicos, function(i,items){
            var numero_item = items.k_coditem_puertas;
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
                '<input type="hidden" id="numero_item_mecanicos'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_mecanicos'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
                        '<label>"'+clasificacion_item+'"</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label>DEFECTO</label>'+
                    '</div>'+
                '</div>';

                    if (numero_item == 1) {
                        contenidoDiv +=
                        '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                            '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                                '<ul id="lightgallery_1" class="list-unstyled row">'+
                                    '<li class="col-xs-12 col-sm-12 col-md-12" data-responsive="../figuras_puertas/figura1.png 375, ../figuras_puertas/figura1.png 480, ../figuras_puertas/figura1.png 800" data-src="../figuras_puertas/figura1.png" data-sub-html="<h4>Figura 1</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: block;">'+
                                        '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+' '+
                                            '<a href="" style="color: #d9534f;">'+
                                                '<span class="glyphicon glyphicon-picture"></span>'+
                                                '(Ver Figuras)'+
                                                '<img class="img-responsive" src="../figuras_puertas/figura1.png" alt="Thumb-1" style="width: 2em; display: none;">'+
                                            '</a>'+
                                       '</p>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura2.png 375, ../figuras_puertas/figura2.png 480, ../figuras_puertas/figura2.png 800" data-src="../figuras_puertas/figura2.png" data-sub-html="<h4>Figura 2</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura2.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura3.png 375, ../figuras_puertas/figura3.png 480, ../figuras_puertas/figura3.png 800" data-src="../figuras_puertas/figura3.png" data-sub-html="<h4>Figura 3</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura3.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura4.png 375, ../figuras_puertas/figura4.png 480, ../figuras_puertas/figura4.png 800" data-src="../figuras_puertas/figura4.png" data-sub-html="<h4>Figura 4</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura4.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura5.png 375, ../figuras_puertas/figura5.png 480, ../figuras_puertas/figura5.png 800" data-src="../figuras_puertas/figura5.png" data-sub-html="<h4>Figura 5</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura5.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura6.png 375, ../figuras_puertas/figura6.png 480, ../figuras_puertas/figura6.png 800" data-src="../figuras_puertas/figura6.png" data-sub-html="<h4>Figura 6</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura6.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura7.png 375, ../figuras_puertas/figura7.png 480, ../figuras_puertas/figura7.png 800" data-src="../figuras_puertas/figura7.png" data-sub-html="<h4>Figura 7</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura7.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura8.png 375, ../figuras_puertas/figura8.png 480, ../figuras_puertas/figura8.png 800" data-src="../figuras_puertas/figura8.png" data-sub-html="<h4>Figura 8</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura8.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura9.png 375, ../figuras_puertas/figura9.png 480, ../figuras_puertas/figura9.png 800" data-src="../figuras_puertas/figura9.png" data-sub-html="<h4>Figura 9</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura9.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura10.png 375, ../figuras_puertas/figura10.png 480, ../figuras_puertas/figura10.png 800" data-src="../figuras_puertas/figura10.png" data-sub-html="<h4>Figura 10</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura10.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                    '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="../figuras_puertas/figura11.png 375, ../figuras_puertas/figura11.png 480, ../figuras_puertas/figura11.png 800" data-src="../figuras_puertas/figura11.png" data-sub-html="<h4>Figura 11</h4>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1" style="display: none;">'+
                                        '<a href="">'+
                                            '<img class="img-responsive" src="../figuras_puertas/figura11.png" alt="Thumb-2">'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<script>'+
                            'lightGallery(document.getElementById("lightgallery_1"));'+
                        '</script>';
                    }else{
                        contenidoDiv +=
                        '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                            '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: justify;">'+
                                '<p style="margin: 14px; padding: 15px; width: 88%;">'+descripcion_item+'</p>'+
                            '</div>'+
                        '</div>';
                    }

                    contenidoDiv +=
                    '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_mecanicos'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_mecanicos'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_mecanicos'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_mecanicos'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_mecanicos'+valor_seleval+'" id="sele_lv_mecanicos'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_mecanicos'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_mecanicos'+valor_seleval+'" id="sele_lv_mecanicos'+valor_options_radio+'" value="No Cumple" required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_mecanicos'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_mecanicos'+valor_seleval+'" id="sele_lv_mecanicos'+valor_options_radio+'" value="No Aplica">'+
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
                        '<a href="./puertas_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
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
            $(contenidoDiv).appendTo("#items_mecanicos");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_items_electrica y cargar los items en la lista
*==============================================*/
function cargarItemsElectrica(cod_inspeccion,cod_inspector) {
    var valor_seleval = 38;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_electrica.php";
    $.getJSON(url,function(puertas_items_electrica){
        $.each(puertas_items_electrica, function(i,items){
            var numero_item = items.k_coditem_electrica;
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
                '<input type="hidden" id="numero_item_electrica'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_electrica'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
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
                        '<label for="sele_lv_electrica'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_electrica'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_electrica'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_electrica'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_electrica'+valor_seleval+'" id="sele_lv_electrica'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_electrica'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_electrica'+valor_seleval+'" id="sele_lv_electrica'+valor_options_radio+'" value="No Cumple"  required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_electrica'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_electrica'+valor_seleval+'" id="sele_lv_electrica'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_electrica_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_electrica_observacion_'+numero_item+'" name="text_electrica_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
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
                        '<a href="./puertas_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
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
            $(contenidoDiv).appendTo("#items_electrica");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_items_motorizacion y cargar los items en la lista
*==============================================*/
function cargarItemsMotorizacion(cod_inspeccion,cod_inspector) {
    var valor_seleval = 43;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_motorizacion.php";
    $.getJSON(url,function(puertas_items_motorizacion){
        $.each(puertas_items_motorizacion, function(i,items){
            var numero_item = items.k_coditem_motorizacion;
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
                '<input type="hidden" id="numero_item_motorizacion'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_motorizacion'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
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
                        '<label for="sele_lv_motorizacion'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_motorizacion'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_motorizacion'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_motorizacion'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_motorizacion'+valor_seleval+'" id="sele_lv_motorizacion'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_motorizacion'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_motorizacion'+valor_seleval+'" id="sele_lv_motorizacion'+valor_options_radio+'" value="No Cumple"  required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_motorizacion'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_motorizacion'+valor_seleval+'" id="sele_lv_motorizacion'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_motorizacion_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_motorizacion_observacion_'+numero_item+'" name="text_motorizacion_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
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
                        '<a href="./puertas_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
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
            $(contenidoDiv).appendTo("#items_motorizacion");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_items_otras y cargar los items en la lista
*==============================================*/
function cargarItemsOtras(cod_inspeccion,cod_inspector) {
    var valor_seleval = 55;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_otras.php";
    $.getJSON(url,function(puertas_items_otras){
        $.each(puertas_items_otras, function(i,items){
            var numero_item = items.k_coditem_otras;
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
                '<input type="hidden" id="numero_item_otras'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_otras'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">';
                    if (numero_item == 55) {
                        contenidoDiv += 
                        '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                            '<br>'+
                            '<label>'+numero_item+'</label>'+
                            '<br>'+
                        '</div>'+
                        '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
                            '<label style="display: none;">"'+clasificacion_item+'"</label>'+
                            '<br>'+
                            '<select class="form-control" id="text_calificacion55" name="text_calificacion55" onchange="actualizarCalificacion(this)" required>'+
                                '<option value="">Seleccione</option>'+
                                '<option value="L">Leve</option>'+
                                '<option value="G">Grave</option>'+
                                '<option value="MG">Muy Grave</option>'+
                            '</select>'+
                            '<br>'+
                        '</div>';
                    }else{
                        contenidoDiv += 
                        '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                            '<label>'+numero_item+'</label>'+
                        '</div>'+
                        '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
                            '<label>"'+clasificacion_item+'"</label>'+
                        '</div>';
                    }
                contenidoDiv +=
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
                        '<label for="sele_lv_otras'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_otras'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_otras'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_otras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_otras'+valor_seleval+'" id="sele_lv_otras'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_otras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_otras'+valor_seleval+'" id="sele_lv_otras'+valor_options_radio+'" value="No Cumple"  required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_otras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_otras'+valor_seleval+'" id="sele_lv_otras'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_otras_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_otras_observacion_'+numero_item+'" name="text_otras_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
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
                        '<a href="./puertas_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
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
            $(contenidoDiv).appendTo("#items_otras");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}

function actualizarCalificacion(select){
    var calificacion = $(select).val();
    $('#cal_item_otras55').val(calificacion);
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_items_maniobras y cargar los items en la lista
*==============================================*/
function cargarItemsManiobras(cod_inspeccion,cod_inspector) {
    var valor_seleval = 76;
    var valor_for_options_radio = 1;
    var valor_options_radio = 1;
    var url="../php/json_puertas_items_maniobras.php";
    $.getJSON(url,function(puertas_items_maniobras){
        $.each(puertas_items_maniobras, function(i,items){
            var numero_item = items.k_coditem_maniobras;
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
                '<input type="hidden" id="numero_item_maniobras'+numero_item+'" value="'+numero_item+'">'+
                '<input type="hidden" id="cal_item_maniobras'+numero_item+'" value="'+clasificacion_item+'">'+
                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; background-color: #5bc0de;">'+
                        '<label>ÍTEM</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de;">'+
                        '<label>CAL</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid;">'+
                        '<label>'+numero_item+'</label>'+
                    '</div>'+
                    '<div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-left:1px solid;">'+
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
                        '<label for="sele_lv_maniobras'+valor_for_options_radio+'">SI CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_maniobras'+valor_for_options_radio+'">NO CUMPLE</label>'+
                    '</div>';
                    valor_for_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #5bc0de; padding-left: 2%;">'+
                        '<label for="sele_lv_maniobras'+valor_for_options_radio+'">NO APLICA</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid; text-align: center;">'+
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maniobras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maniobras'+valor_seleval+'" id="sele_lv_maniobras'+valor_options_radio+'" value="Si Cumple">'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maniobras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maniobras'+valor_seleval+'" id="sele_lv_maniobras'+valor_options_radio+'" value="No Cumple"  required>'+
                            '</label>'+
                        '</div>'+
                    '</div>';
                    valor_options_radio += 1;
                    contenidoDiv +=
                    '<div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid;">'+
                        '<div class="radio">'+
                            '<label for="sele_lv_maniobras'+valor_options_radio+'" style="width: 100%;">'+
                                '<input type="radio" name="sele_maniobras'+valor_seleval+'" id="sele_lv_maniobras'+valor_options_radio+'" value="No Aplica" >'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">'+
                        '<label for="text_maniobras_observacion_'+numero_item+'">OBSERVACIÓN</label>'+
                    '</div>'+
                '</div>'+

                '<div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">'+
                    '<div class="col-xs-12 col-md-12">'+
                        '<br>'+
                        '<textarea class="form-control" rows="3" id="text_maniobras_observacion_'+numero_item+'" name="text_maniobras_observacion_'+numero_item+'" placeholder="Ingrese aquí la observación..."></textarea>'+
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
                        '<a href="./puertas_registros_fotograficos.php?id_inspector='+cod_inspector+'&cod_inspeccion='+cod_inspeccion+'&cod_item='+numero_item+'" target="_blank">'+
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
            $(contenidoDiv).appendTo("#items_maniobras");
            valor_for_options_radio += 1;
            valor_options_radio += 1;
            valor_seleval += 1;
        });
    });
}