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
  message = 'Todo salio bien, se modifico la inspeccion Nº. ' + consecutivo_inspeccion;
  if(navigator.notification && navigator.notification.alert){
    navigator.notification.alert(message, null, "Empresa", "Aceptar");
    location.href="puertas_modificar_lista_inspeccion.php?id_inspector="+cod_inspector+"&cod_inspeccion="+codigo_inspeccion+"";
  }else{
    alert(message);
    location.href="puertas_modificar_lista_inspeccion.php?id_inspector="+cod_inspector+"&cod_inspeccion="+codigo_inspeccion+"";
  }
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
  * LA CUAL SE CIERRA EN LA FUNCION addItemConsecutivoPuertas
  * ============================= */
  $('#texto_carga').text('Verificando items...Espere');
  location.href = "#arriba";
  /* Funcion creada en el script de mostrar consecutivo - se llama para ocultar de nuevo todos los div´s de los items */
  ocultarDivs();
  abrirVentanaCarga();
  var hora = mostrarhora();

  var codigo_inspeccion = getQueryVariable('cod_inspeccion');
  var cod_usuario = getQueryVariable('id_inspector');
  var consecutivo_inspeccion = $("#text_consecutivo").val();

  var textCliente = $("#text_cliente").val();
  var textDireccioncliente = $("#text_dir_cliente").val();
  var textEquipo = $("#text_equipo").val();
  var textEmpresaMantenimiento = $("#text_empresaMantenimiento").val();
  var text_desc_puerta = $("#text_desc_puerta").val();
  var text_tipoPuerta = $("#text_tipoPuerta").val();
  var text_motorizacion = $("#text_motorizacion").val();
  var text_acceso = $("#text_acceso").val();
  var text_accionamiento = $("#text_accionamiento").val();
  var text_operador = $("#text_operador").val();
  var text_hoja = $("#text_hoja").val();
  var text_transmision = $("#text_transmision").val();
  var text_identificacion = $("#text_identificacion").val();
  var textFecha = $("#text_fecha").val();
  var text_ultimo_mto = $("#text_ultimo_mto").val();
  var text_inicio_servicio = $("#text_inicio_servicio").val();
  var text_ultima_inspec = $("#text_ultima_inspec").val();
  var text_ancho = $("#text_ancho").val();
  var text_alto = $("#text_alto").val();
  var text_codigo = $("#text_codigo").val();

  /* ============================
  * Si los campos de fecha quedan vacios se les coloca una linea ya que estos no son obligatorios
  * ============================= */
  if (textFecha.length < 1) {
    textFecha = "------";
  }
  if (text_ultimo_mto.length < 1) {
    text_ultimo_mto = "------";
  }
  if (text_inicio_servicio.length < 1) {
    text_inicio_servicio = "------";
  }
  if (text_ultima_inspec.length < 1) {
    text_ultima_inspec = "------";
  }

  var textObserFinal = $("#text_observacion_final").val();

  /* ============================
  * Actualizar valores en las tablas
  * ============================= */
  /* Actualizar valores en la tabla puertas_valores_iniciales */
  updateItemsPuertasValoresIniciales(textCliente,
                                    textDireccioncliente,
                                    textEquipo,
                                    textEmpresaMantenimiento,
                                    text_desc_puerta,
                                    text_tipoPuerta,
                                    text_motorizacion,
                                    text_acceso,
                                    text_accionamiento,
                                    text_operador,
                                    text_hoja,
                                    text_transmision,
                                    text_identificacion,
                                    textFecha,
                                    text_ancho,
                                    text_alto,
                                    text_codigo,
                                    consecutivo_inspeccion,
                                    text_ultimo_mto,
                                    text_inicio_servicio,
                                    text_ultima_inspec,
                                    hora,
                                    "Inicial",
                                    cod_usuario,
                                    codigo_inspeccion);
  /* Actualizar valores en la tabla puertas_valores_preliminar */
  for (var i = 1; i <= 3; i++) {
    updateItemsPuertasValoresPreliminar(cod_usuario,
                                        codigo_inspeccion,
                                        $('#numero_item_preliminar'+i).val(),
                                        $('input:radio[name=seleval'+i+']:checked').val(),
                                        $('#text_obser_item'+i+'_eval_prel').val());
  }
  /* Actualizar valores en la tabla puertas_valores_proteccion */
  for (var i = 1; i <= 7; i++) {
    updateItemsPuertasValoresProteccion(cod_usuario,
                                        codigo_inspeccion,
                                        $('#numero_item_proteccion'+i).val(),
                                        $('input:radio[name=sele_protec_person'+i+']:checked').val(),
                                        $('input:radio[name=sele_protec_person'+i+'_'+i+']:checked').val(),
                                        $('#text_obser_protec_person'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_elementos */
  for (var i = 1; i <= 6; i++) {
    updateItemsPuertasValoresElementos(cod_usuario,
                                       codigo_inspeccion,
                                       $('#numero_item_element_inspec'+i).val(),
                                       $('#descrip_item_element_inspec'+i).val(),
                                       $('input:radio[name=sele_element_inspec'+i+']:checked').val());
  }
  /* Actualizar valores en la tabla puertas_valores_mecanicos */
  for (var i = 1; i <= 37; i++) {
    if ($('input:radio[name=sele_mecanicos'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_mecanicos'+i).val();
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
    updateItemsPuertasValoresMecanicos(cod_usuario,
                                       codigo_inspeccion,
                                       $('#numero_item_mecanicos'+i).val(),
                                       $('#cal_item_mecanicos'+i).val(),
                                       $('input:radio[name=sele_mecanicos'+i+']:checked').val(),
                                       $('#text_lv_valor_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_electrica */
  for (var i = 38; i <= 42; i++) {
    if ($('input:radio[name=sele_electrica'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_electrica'+i).val();
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
    updateItemsPuertasValoresElectrica(cod_usuario,
                                       codigo_inspeccion,
                                       $('#numero_item_electrica'+i).val(),
                                       $('#cal_item_electrica'+i).val(),
                                       $('input:radio[name=sele_electrica'+i+']:checked').val(),
                                       $('#text_electrica_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_motorizacion */
  for (var i = 43; i <= 54; i++) {
    if ($('input:radio[name=sele_motorizacion'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_motorizacion'+i).val();
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
    updateItemsPuertasValoresMotorizacion(cod_usuario,
                                          codigo_inspeccion,
                                          $('#numero_item_motorizacion'+i).val(),
                                          $('#cal_item_motorizacion'+i).val(),
                                          $('input:radio[name=sele_motorizacion'+i+']:checked').val(),
                                          $('#text_motorizacion_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_otras */
  for (var i = 55; i <= 75; i++) {
    if ($('input:radio[name=sele_otras'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_otras'+i).val();
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
    updateItemsPuertasValoresOtras(cod_usuario,
                                   codigo_inspeccion,
                                   $('#numero_item_otras'+i).val(),
                                   $('#cal_item_otras'+i).val(),
                                   $('input:radio[name=sele_otras'+i+']:checked').val(),
                                   $('#text_otras_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_maniobras */
  for (var i = 76; i <= 86; i++) {
    if ($('input:radio[name=sele_maniobras'+i+']:checked').val() == "No Cumple") {
      contador_items_nocumple += 1;
      var calificacion = $('#cal_item_maniobras'+i).val();
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
    updateItemsPuertasValoresManiobras(cod_usuario,
                                       codigo_inspeccion,
                                       $('#numero_item_maniobras'+i).val(),
                                       $('#cal_item_maniobras'+i).val(),
                                       $('input:radio[name=sele_maniobras'+i+']:checked').val(),
                                       $('#text_maniobras_observacion_'+i).val());
  }
  /* Actualizar valores en la tabla puertas_valores_finales */
  updateItemsPuertasValoresObservacionFinal(cod_usuario,codigo_inspeccion,textObserFinal);

  /* Se actualizan las respectivas tablas  de auditoria y la tabla que maneja el consecutivo */
  updateItemsAuditoriaInspeccionesPuertas(cod_usuario,codigo_inspeccion,consecutivo_inspeccion,contador_items_nocumple,contador_items_leve,contador_items_grave,contador_items_muygrave,'Si');
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_iniciales
*==============================================*/
function updateItemsPuertasValoresIniciales(n_cliente,textDireccioncliente,n_equipo,n_empresamto,o_desc_puerta,
                                            o_tipo_puerta,o_motorizacion,o_acceso,o_accionamiento,
                                            o_operador,o_hoja,o_transmision,o_identificacion,
                                            f_fecha,v_ancho,v_alto,v_codigo,o_consecutivoinsp,
                                            ultimo_mto,inicio_servicio,ultima_inspeccion,
                                            h_hora,o_tipo_informe, k_codusuario,k_codinspeccion) {
  var parametros = {"inspector" : k_codusuario,
                    "inspeccion" : k_codinspeccion,
                    "n_cliente" : n_cliente,
                    "cliente_direccion" : textDireccioncliente,
                    "n_equipo" : n_equipo,
                    "n_empresamto" : n_empresamto,
                    "o_desc_puerta" : o_desc_puerta,
                    "o_tipo_puerta" : o_tipo_puerta,
                    "o_motorizacion" : o_motorizacion,
                    "o_acceso" : o_acceso,
                    "o_accionamiento" : o_accionamiento,
                    "o_operador" : o_operador,
                    "o_hoja" : o_hoja,
                    "o_transmision" : o_transmision,
                    "o_identificacion" : o_identificacion,
                    "f_fecha" : f_fecha,
                    "v_ancho" : v_ancho,
                    "v_alto" : v_alto,
                    "v_codigo" : v_codigo,
                    "o_consecutivoinsp" : o_consecutivoinsp,
                    "ultimo_mto" : ultimo_mto,
                    "inicio_servicio" : inicio_servicio,
                    "ultima_inspeccion" : ultima_inspeccion,
                    "h_hora" : h_hora,
                    "o_tipo_informe" : o_tipo_informe};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_iniciales.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_preliminar
*==============================================*/
function updateItemsPuertasValoresPreliminar(cod_inspector,k_codinspeccion,coditem_preli, calificacion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : coditem_preli,
                    "calificacion" : calificacion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_preliminar.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_proteccion
*==============================================*/
function updateItemsPuertasValoresProteccion(cod_inspector,k_codinspeccion,cod_item, sele_inspector,sele_empresa,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "sele_inspector" : sele_inspector,
                    "sele_empresa" : sele_empresa,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_proteccion.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_elementos
*==============================================*/
function updateItemsPuertasValoresElementos(cod_inspector,k_codinspeccion,cod_item, descripcion,seleccion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "descripcion" : descripcion,
                    "seleccion" : seleccion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_elementos.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_mecanicos
*==============================================*/
function updateItemsPuertasValoresMecanicos(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_mecanicos.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_electrica
*==============================================*/
function updateItemsPuertasValoresElectrica(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_electrica.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_motorizacion
*==============================================*/
function updateItemsPuertasValoresMotorizacion(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_motorizacion.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_otras
*==============================================*/
function updateItemsPuertasValoresOtras(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_otras.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_maniobras
*==============================================*/
function updateItemsPuertasValoresManiobras(cod_inspector,k_codinspeccion,cod_item, calificacion,seleccion,observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "cod_item" : cod_item,
                    "calificacion" : calificacion,
                    "seleccion" : seleccion,
                    "observacion" : observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_maniobras.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla puertas_valores_finales
*==============================================*/
function updateItemsPuertasValoresObservacionFinal(cod_inspector,k_codinspeccion,o_observacion) {
  var parametros = {"inspector" : cod_inspector,
                    "inspeccion" : k_codinspeccion,
                    "observacion" : o_observacion};
  $.ajax({
    url: "../php/puertas_actualizar_datos_valores_finales.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
    }
  });
}

/*=============================================
* Funcion para actualizar una fila en la tabla auditoria_inspecciones_puertas
*==============================================*/
function updateItemsAuditoriaInspeccionesPuertas(cod_inspector,cod_inspeccion,consecutivo_insp,cantidad_nocumple,cantidad_items_leve,cantidad_items_grave,cantidad_items_muygrave,o_actualizar_inspeccion) {
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
    url: "../php/puertas_actualizar_auditoria.php",
    data: parametros,
    type: "POST",
    success: function(response){
      //alert(response);
      window.opener.location.reload(); //codigo para actualizar la ventana anterior que abre esta ultima
      cerrarVentanaCarga();
    }
  });
}