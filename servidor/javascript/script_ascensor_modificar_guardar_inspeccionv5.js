jQuery(document).ready(function($){
  //alert("probando script");
});

/* Inicializamos la variable para contar los items no cumple */
var contador_items_nocumple = 0;

var contador_items_leve = 0;
var contador_items_grave = 0;
var contador_items_muygrave = 0;

/*=============================================
* Funcion que permite abrir la ventana que aparece mientras se guarda la inspeccion
*==============================================*/
function abrirVentanaCarga(){
  $('#texto_carga').text('Modificando Inspección...Espere');
  $('.fb').show();
  $('.fbback').show();
  $('body').css('overflow','hidden');
}

/*=============================================
* Funcion que permite cerrar la ventana que aparece mientras se guarda la inspeccion
* Luego de que se guarde se muestra una alerta y se redirige al index
*==============================================*/
function cerrarVentanaCarga(){
  $('.fb').hide();
  $('.fbback').hide();
  $('body').css('overflow','auto');
  var cod_inspector = getQueryVariable('id_inspector');
  var codigo_inspeccion = getQueryVariable('cod_inspeccion');
  var consecutivo_inspeccion = $("#text_consecutivo").val();
  swal({
    title: 'Todo salio bien!',
    html: 'Se modifico la inspeccion Nº. ' + consecutivo_inspeccion + '<br>¿Desea cerrar la pestaña de inspección?',
    type: 'success',
    showCancelButton: true,
    confirmButtonColor: '#428bca',
    cancelButtonColor: '#d9534f',
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: true,
    allowOutsideClick: false
  }).then(function () {
    window.close();
  }, function (dismiss) {
    // dismiss can be 'cancel', 'overlay',
    // 'close', and 'timer'
    if (dismiss === 'cancel') {
      //location.href="ascensor_modificar_lista_inspeccion.php?id_inspector="+cod_inspector+"&cod_inspeccion="+codigo_inspeccion+"";
      window.location.reload();
    }
  })
  // message = 'Todo salio bien, se modifico la inspeccion Nº. ' + consecutivo_inspeccion;
  // if(navigator.notification && navigator.notification.alert){
  //   navigator.notification.alert(message, null, "Empresa", "Aceptar");
  //   location.href="ascensor_modificar_lista_inspeccion.php?id_inspector="+cod_inspector+"&cod_inspeccion="+codigo_inspeccion+"";
  // }else{
  //   alert(message);
  //   location.href="ascensor_modificar_lista_inspeccion.php?id_inspector="+cod_inspector+"&cod_inspeccion="+codigo_inspeccion+"";
  // }
}

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
* Funcion que permite obtener la hora
*==============================================*/
function mostrarhora(){ 
  var fecha = new Date();
  var hora = fecha.getHours();
  var minutos = fecha.getMinutes();
  var segundos = fecha.getSeconds();
  if (hora < 10) {
    hora = "0" + hora;
  }
  if (minutos < 10) {
    minutos = "0" + minutos;
  }
  if (segundos < 10) {
    segundos = "0" + segundos;
  }
  hora_final = hora + ":" + minutos + ":" + segundos; 
  window.status = hora_final;
  return window.status;
}

/*=============================================
* Funcion que se ejecuta cuando se oprime el boton Guardar Inspeccion
*==============================================*/
function guardarInspeccion(){
  /* ============================
  * REDIRECCIONAMOS AL INICIO DE LA PAGINA DE INSPECCION Y ABRIMOS LA VENTANA DE CARGA
  * LA CUAL SE CIERRA EN LA FUNCION addItemConsecutivoAscensores
  * ============================= */
  location.href = "#arriba";
  ocultarDivs();
  abrirVentanaCarga();
  var hora = mostrarhora();

  var cod_inspector = getQueryVariable('id_inspector');
  var codigo_inspeccion = getQueryVariable('cod_inspeccion');
  var consecutivo_inspeccion = $("#text_consecutivo").val();

  var textCliente = $("#text_cliente").val();
  var textDireccioncliente = $("#text_dir_cliente").val();
  var textEquipo = $("#text_equipo").val();
  var textEmpresaMantenimiento = $("#text_empresaMantenimiento").val();
  var textTipoAccionamiento = $("#text_tipoAccionamiento").val();
  var textCapacidadPersonas = $("#text_capacidadPersonas").val();
  var textCapacidadPeso = $("#text_capacidadPeso").val();
  var textNumeroParadas = $("#text_numeroParadas").val();
  var textFecha = $("#text_fecha").val();
  var textCodigo = $("#text_codigo").val();
  var textUltimoMto = $("#text_ultimo_mto").val();
  var textInicioServicio = $("#text_inicio_servicio").val();
  var textUltimaInspec = $("#text_ultima_inspec").val();

  if (textFecha.length < 1) {
    textFecha = "------";
  }
  if (textUltimoMto.length < 1) {
    textUltimoMto = "------";
  }
  if (textInicioServicio.length < 1) {
    textInicioServicio = "------";
  }
  if (textUltimaInspec.length < 1) {
    textUltimaInspec = "------";
  }

  var textObserFinal = $("#text_observacion_final").val();

  /* ============================
  * Actualizar valores en las tablas
  * ============================= */
  /* Actualizar valores en la tabla ascensor_valores_iniciales */
  updateItemsAscensorValoresIniciales(textCliente,textDireccioncliente,textEquipo,textEmpresaMantenimiento,textTipoAccionamiento,textCapacidadPersonas,textCapacidadPeso,textNumeroParadas,textFecha,textUltimoMto,textInicioServicio,textUltimaInspec,hora, codigo_inspeccion,'Inicial',cod_inspector);
  /* Actualizar valores en la tabla ascensor_valores_preliminar */
  var cantidadItemsTAIPRE = 3;
  for (var i = 1; i <= cantidadItemsTAIPRE; i++) {
    updateItemsAscensorValoresPreliminar(cod_inspector,
                                         codigo_inspeccion,
                                         $('#numero_item_preliminar'+i).val(),
                                         $('input:radio[name=seleval'+i+']:checked').val(),
                                         $('#text_obser_item'+i+'_eval_prel').val());
  }
  /* Actualizar valores en la tabla ascensor_valores_proteccion */
  var cantidadItemsTAIPP = 7;
  for (var i = 1; i <= cantidadItemsTAIPP; i++) {
    updateItemsAscensorValoresProteccion(cod_inspector,
                                         codigo_inspeccion,
                                         $('#numero_item_proteccion'+i).val(),
                                         $('input:radio[name=sele_protec_person'+i+']:checked').val(),
                                         $('input:radio[name=sele_protec_person'+i+'_'+i+']:checked').val(),
                                         $('#text_obser_protec_person'+i).val());
  }
  /* Actualizar valores en la tabla ascensor_valores_elementos */
  var cantidadItemsTAIE = 6;
  for (var i = 1; i <= cantidadItemsTAIE; i++) {
    updateItemsAscensorValoresElementos(cod_inspector,
                                        codigo_inspeccion,
                                        $('#numero_item_element_inspec'+i).val(),
                                        $('#descrip_item_element_inspec'+i).val(),
                                        $('input:radio[name=sele_element_inspec'+i+']:checked').val());
  }
  /* Actualizar valores en la tabla ascensor_valores_cabina */
  var cantidadItemsTAIC = 35;
  for (var i = 1; i <= cantidadItemsTAIC; i++) {
    if ($('input:radio[name=sele_cabina'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_cabina'+i).val();
      if (calificacion == "L") {
        contador_items_leve += 1;
      }
      if (calificacion == "G") {
        contador_items_grave += 1;
      }
      if (calificacion == "MG") {
        contador_items_muygrave += 1;
      }
    }
    updateItemsAscensorValoresCabina(cod_inspector,
                                     codigo_inspeccion,
                                     $('#numero_item_cabina'+i).val(),
                                     $('#cal_item_cabina'+i).val(),
                                     $('input:radio[name=sele_cabina'+i+']:checked').val(),
                                     $('#text_lv_valor_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla ascensor_valores_maquinas */
  var cantidadItemsTAIM = 47;
  var numero_final_item = 36 + parseInt(cantidadItemsTAIM);
  for (var i = 36; i < numero_final_item; i++) {
    if ($('input:radio[name=sele_maquinas'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_maquinas'+i).val();
      if (calificacion == "L") {
        contador_items_leve += 1;
      }
      if (calificacion == "G") {
        contador_items_grave += 1;
      }
      if (calificacion == "MG") {
        contador_items_muygrave += 1;
      }
    }
    updateItemsAscensorValoresMaquinas(cod_inspector,
                                       codigo_inspeccion,
                                       $('#numero_item_maquinas'+i).val(),
                                       $('#cal_item_maquinas'+i).val(),
                                       $('input:radio[name=sele_maquinas'+i+']:checked').val(),
                                       $('#text_maquinas_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla ascensor_valores_pozo */
  var cantidadItemsTAIP = 65;
  var numero_final_item = 83 + parseInt(cantidadItemsTAIP);
  for (var i = 83; i < numero_final_item; i++) {
    if ($('input:radio[name=sele_pozo'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_pozo'+i).val();
      if (calificacion == "L") {
        contador_items_leve += 1;
      }
      if (calificacion == "G") {
        contador_items_grave += 1;
      }
      if (calificacion == "MG") {
        contador_items_muygrave += 1;
      }
    }
    updateItemsAscensorValoresPozo(cod_inspector,
                                   codigo_inspeccion,
                                   $('#numero_item_pozo'+i).val(),
                                   $('#cal_item_pozo'+i).val(),
                                   $('input:radio[name=sele_pozo'+i+']:checked').val(),
                                   $('#text_pozo_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla ascensor_valores_foso */
  var cantidadItemsTAIF = 29;
  var numero_final_item = 148 + parseInt(cantidadItemsTAIF);
  for (var i = 148; i < numero_final_item; i++) {
    if ($('input:radio[name=sele_foso'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_foso'+i).val();
      if (calificacion == "L") {
        contador_items_leve += 1;
      }
      if (calificacion == "G") {
        contador_items_grave += 1;
      }
      if (calificacion == "MG") {
        contador_items_muygrave += 1;
      }
    }
    updateItemsAscensorValoresFoso(cod_inspector,
                                   codigo_inspeccion,
                                   $('#numero_item_foso'+i).val(),
                                   $('#cal_item_foso'+i).val(),
                                   $('input:radio[name=sele_foso'+i+']:checked').val(),
                                   $('#text_foso_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla ascensor_valores_finales */
  updateItemsAscensorValoresObservacionFinal(cod_inspector,codigo_inspeccion,textObserFinal);
  /* Se actualizan la tabla de auditoria */
  updateItemsAuditoriaInspeccionesAscensores(cod_inspector,codigo_inspeccion,consecutivo_inspeccion,contador_items_nocumple,contador_items_leve,contador_items_grave,contador_items_muygrave,'Si');
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_iniciales
*==============================================*/
function updateItemsAscensorValoresIniciales(textCliente,textDireccioncliente,textEquipo,textEmpresaMantenimiento,
                                             textTipoAccionamiento,textCapacidadPersonas,textCapacidadPeso,
                                             textNumeroParadas,textFecha,textUltimoMto,textInicioServicio,
                                             textUltimaInspec,hora, k_codinspeccion,tipo_informe,cod_inspector) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cliente" : textCliente,
                    "cliente_direccion" : textDireccioncliente,
                    "equipo" : textEquipo,
                    "empresa_mto" : textEmpresaMantenimiento,
                    "accionamiento" : textTipoAccionamiento,
                    "capac_person" : textCapacidadPersonas,
                    "capac_peso" : textCapacidadPeso,
                    "num_paradas" : textNumeroParadas,
                    "fecha" : textFecha,
                    "ultimo_mto" : textUltimoMto,
                    "inicio_servicio" : textInicioServicio,
                    "ultima_inspec" : textUltimaInspec,
                    "hora" : hora,
                    "tipo_informe" : tipo_informe};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_iniciales.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_preliminar
*==============================================*/
function updateItemsAscensorValoresPreliminar(cod_inspector,k_codinspeccion,coditem_preli, calificacion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : coditem_preli,
                    "calificacion" : calificacion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_preliminar.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_proteccion
*==============================================*/
function updateItemsAscensorValoresProteccion(cod_inspector,k_codinspeccion,cod_item, sele_inspector,sele_empresa,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "sele_inspector" : sele_inspector,
                    "sele_empresa" : sele_empresa,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_proteccion.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_elementos
*==============================================*/
function updateItemsAscensorValoresElementos(cod_inspector,k_codinspeccion,cod_item, descripcion,seleccion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "descripcion" : descripcion,
                    "seleccion" : seleccion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_elementos.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_cabina
*==============================================*/
function updateItemsAscensorValoresCabina(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_cabina.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_maquinas
*==============================================*/
function updateItemsAscensorValoresMaquinas(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_maquinas.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_pozo
*==============================================*/
function updateItemsAscensorValoresPozo(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_pozo.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_foso
*==============================================*/
function updateItemsAscensorValoresFoso(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_foso.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla ascensor_valores_finales
*==============================================*/
function updateItemsAscensorValoresObservacionFinal(cod_inspector,k_codinspeccion,o_observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "observacion" : o_observacion};
  $.ajax({
    url: "../php/ascensor_actualizar_datos_valores_finales.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla auditoria_inspecciones_ascensores
*==============================================*/
function updateItemsAuditoriaInspeccionesAscensores(cod_inspector,cod_inspeccion,consecutivo_insp,cantidad_nocumple,cantidad_items_leve,cantidad_items_grave,cantidad_items_muygrave,o_actualizar_inspeccion) {
  var estado_revision;
  if (cantidad_nocumple > 0) {
    estado_revision = "Si";
  }else{
    estado_revision = "No";
  }
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : cod_inspeccion,
                    "consecutivo_insp" : consecutivo_insp,
                    "estado_revision" : estado_revision,
                    "cantidad_nocumple" : cantidad_nocumple,
                    "cantidad_items_leve" : cantidad_items_leve,
                    "cantidad_items_grave" : cantidad_items_grave,
                    "cantidad_items_muygrave" : cantidad_items_muygrave,
                    "o_actualizar_inspeccion" : o_actualizar_inspeccion};
  $.ajax({
    url: "../php/ascensor_actualizar_auditoria.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
      window.opener.location.reload(); //codigo para actualizar la ventana anterior que abre esta ultima
      cerrarVentanaCarga();
    }
  });
}