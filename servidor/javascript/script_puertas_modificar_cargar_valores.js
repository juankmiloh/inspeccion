$(document).ready(function($){
  /* CARGAR FUNCIONES INICIALES */
  //alert("probando script");
  /* FUNCIONES QUE PERMITEN OPTIMIZAR EL RENDIMIENTO DEL FORMULARIO HTML */
  ocultarDivs();
  clickDivPreliminar();
  clickDivProteccion();
  clickDivElementos();
  clickDivListaVerificacion();
  clickDivMecanicos();
  clickDivElectrica();
  clickDivMotorizacion();
  clickDivOtras();
  clickDivManiobras();
  /* FUNCIONES PARA MODIFICAR LA INSPECCION */
  modificarInspeccion();
  cerrarVentanaAudio();
  $('#botonIniciar0').attr("disabled", true);
  $("#link_botonIniciar0").attr("href", "./puertas_registros_fotograficos.php?id_inspector="+cod_usuario+"&cod_inspeccion="+cod_inspeccion+"&cod_item=0");
});

var cod_usuario = getQueryVariable('id_inspector');
var cod_inspeccion = getQueryVariable('cod_inspeccion');

/*=============================================
* Funcion que se permite comprobar si hace click en los botones cerrar de la vantana modal donde se carga el audio
* Si se hace click se elimina el div donde se carga el audio
*==============================================*/
function cerrarVentanaAudio(){
  $("#btn_small_cerrar_modal").click(function(){
    $("#audio").remove(); //se elimina el div por si hay algun audio cargado
  });
  $("#btn_cerrar_modal").click(function(){
    $("#audio").remove(); //se elimina el div por si hay algun audio cargado
  });
}

/*=============================================
* Funcion que permite esconder los div´s de todos los items de la inspeccion
*==============================================*/
function ocultarDivs(){
  $('#items_lista_verificacion').hide();
}

/*=============================================
* Funcion que permite mostrar los div´s de todos los items de la inspeccion
* Se activa cuando es presionado el boton guardar inspeccion, para permitir comprobar que no hay ningun campo sin vacio ni sin seleccionar
*==============================================*/
function mostrarDivs(){
  $('#items_lista_verificacion').show();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de EVALUACIÓN PRELIMINAR DE INSPECCIÓN
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivPreliminar(){
  $(".div_1").click(function(){
    mostrarDivPreliminar();
  });
}

function mostrarDivPreliminar(){
  $('#collapse_evaluacion_preliminar').collapse('show');
  location.href = "#campo_focus_2";
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
  $('#items_lista_verificacion').hide();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de ELEMENTOS DE PROTECCIÓN PERSONAL
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivProteccion(){
  $(".div_2").click(function(){
    mostrarDivProteccion();
  });
}

function mostrarDivProteccion(){
  $('#collapse_evaluacion_preliminar').collapse('hide');
  location.href = "#campo_focus_2";
  $('#collapse_elementos_proteccion_personal').collapse('show');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
  $('#items_lista_verificacion').hide();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de ELEMENTOS DEl INSPECTOR
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivElementos(){
  $(".div_3").click(function(){
    mostrarDivElementos();
  });
}

function mostrarDivElementos(){
  $('#collapse_evaluacion_preliminar').collapse('hide');
  location.href = "#campo_focus_3";
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('show');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
  $('#items_lista_verificacion').hide();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de LISTA DE DEFECTOS
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivListaVerificacion(){
  $("#div_4").click(function(){
    if( $('#items_lista_verificacion').is(":visible") ){
      $('#items_lista_verificacion').hide('fast');
    }else{
      mostrarDivListaVerificacion();
    }
  });
}

function mostrarDivListaVerificacion(){
  $('#items_lista_verificacion').show('fast');
  location.href = "#campo_focus_4";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de ELEMENTOS MECANICOS
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivMecanicos(){
  $(".div_5").click(function(){
    mostrarDivMecanicos();
  });
}

function mostrarDivMecanicos(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_4";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('show');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de INSTALACION ELECTRICA
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivElectrica(){
  $(".div_6").click(function(){
    mostrarDivElectrica();
  });
}

function mostrarDivElectrica(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_5";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('show');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de MOTORIZACION
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivMotorizacion(){
  $(".div_7").click(function(){
    mostrarDivMotorizacion();
  });
}

function mostrarDivMotorizacion(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_6";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('show');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de OTRAS COMPROBACIONES
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivOtras(){
  $(".div_8").click(function(){
    mostrarDivOtras();
  });
}

function mostrarDivOtras(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_7";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('show');
  $('#collapse_maniobras').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de MANIOBRAS DE SEGURIDAD
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivManiobras(){
  $(".div_9").click(function(){
    mostrarDivManiobras();
  });
}

function mostrarDivManiobras(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_8";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_mecanicos').collapse('hide');
  $('#collapse_electrica').collapse('hide');
  $('#collapse_motorizacion').collapse('hide');
  $('#collapse_otras').collapse('hide');
  $('#collapse_maniobras').collapse('show');
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
* Funcion que recibe y envia por parametro el codigo de la inspeccion a modificar y permite llamar varias funciones que cargan los valores en la lista
*==============================================*/
function modificarInspeccion(){
  Concurrent.Thread.create(obtenerValoresIniciales);
  Concurrent.Thread.create(obtenerValoresPreliminar);
  Concurrent.Thread.create(obtenerValoresProteccion);
  Concurrent.Thread.create(obtenerValoresElementos);
  Concurrent.Thread.create(obtenerValoresMecanicos);
  Concurrent.Thread.create(obtenerValoresElectrica);
  Concurrent.Thread.create(obtenerValoresMotorizacion);
  Concurrent.Thread.create(obtenerValoresOtras);
  Concurrent.Thread.create(obtenerValoresManiobras);
  Concurrent.Thread.create(obtenerValoresObservacionFinal);
  Concurrent.Thread.create(obtenerValoresAudios);
  Concurrent.Thread.create(obtenerValoresFotografias);
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_iniciales que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresIniciales(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_iniciales.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      $.each(response, function(i,items){
        var textCliente = items.n_cliente;
        var textEquipo = items.n_equipo;
        var textEmpresaMantenimiento = items.n_empresamto;
        var text_desc_puerta = items.o_desc_puerta;
        var text_tipoPuerta = items.o_tipo_puerta;
        var text_motorizacion = items.o_motorizacion;
        var text_acceso = items.o_acceso;
        var text_accionamiento = items.o_accionamiento;
        var text_operador = items.o_operador;
        var text_hoja = items.o_hoja;
        var text_transmision = items.o_transmision;
        var text_identificacion = items.o_identificacion;
        var textFecha = items.f_fecha;
        var text_ultimo_mto = items.ultimo_mto;
        var text_inicio_servicio = items.inicio_servicio;
        var text_ultima_inspec = items.ultima_inspeccion;
        var text_ancho = items.v_ancho;
        var text_alto = items.v_alto;
        var consecutivo = items.o_consecutivoinsp;

        cargarValoresIniciales(textCliente,textEquipo,textEmpresaMantenimiento,text_desc_puerta,
                             text_tipoPuerta,text_motorizacion,text_acceso,text_accionamiento,
                             text_operador,text_hoja,text_transmision,text_identificacion,
                             textFecha,text_ultimo_mto,text_inicio_servicio,text_ultima_inspec,text_ancho,text_alto,consecutivo);
      });
    }
  });
}

/*=============================================
* Funcion para mostrar los valores obtenidos de la consulta en los respectivos campos del formulario
*==============================================*/
function cargarValoresIniciales(textCliente,textEquipo,textEmpresaMantenimiento,text_desc_puerta,
                                text_tipoPuerta,text_motorizacion,text_acceso,text_accionamiento,
                                text_operador,text_hoja,text_transmision,text_identificacion,
                                textFecha,text_ultimo_mto,text_inicio_servicio,text_ultima_inspec,text_ancho,text_alto,consecutivo){
  $("#text_cliente").val(textCliente);
  $("#text_equipo").val(textEquipo);
  $("#text_empresaMantenimiento").val(textEmpresaMantenimiento);
  $("#text_desc_puerta").val(text_desc_puerta);
  $("#text_tipoPuerta").val(text_tipoPuerta);
  $("#text_motorizacion").val(text_motorizacion);
  $("#text_acceso").val(text_acceso);
  $("#text_accionamiento").val(text_accionamiento);
  $("#text_operador").val(text_operador);
  $("#text_hoja").val(text_hoja);
  $("#text_transmision").val(text_transmision);
  $("#text_identificacion").val(text_identificacion);
  $("#text_fecha").val(textFecha);
  $("#text_ultimo_mto").val(text_ultimo_mto);
  $("#text_inicio_servicio").val(text_inicio_servicio);
  $("#text_ultima_inspec").val(text_ultima_inspec);
  $("#text_ancho").val(text_ancho);
  $("#text_alto").val(text_alto);
  $("#text_consecutivo").val(consecutivo);
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_preliminar que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresPreliminar(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_preliminar.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      //alert(response);
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=seleval"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $("#text_obser_item"+contador+"_eval_prel").val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_proteccion que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresProteccion(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_proteccion.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=sele_protec_person"+contador+"][value='"+items.v_sele_inspector+"']").prop("checked",true);
        $("input[name=sele_protec_person"+contador+"_"+contador+"][value='"+items.v_sele_empresa+"']").prop("checked",true);
        $('#text_obser_protec_person'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_elementos que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresElementos(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_elementos.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=sele_element_inspec"+contador+"][value='"+items.v_seleccion+"']").prop("checked",true);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_mecanicos que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresMecanicos(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_mecanicos.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=sele_mecanicos"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_lv_valor_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_electrica que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresElectrica(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_electrica.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 38;
      $.each(response, function(i,items){
        $("input[name=sele_electrica"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_electrica_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_motorizacion que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresMotorizacion(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_motorizacion.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 43;
      $.each(response, function(i,items){
        $("input[name=sele_motorizacion"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_motorizacion_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_otras que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresOtras(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_otras.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 55;
      $.each(response, function(i,items){
        $("input[name=sele_otras"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_otras_observacion_'+contador).val(items.o_observacion);
        if (contador == 55) {
          $('#text_calificacion55').val(items.n_calificacion);
          $('#cal_item_otras55').val(items.n_calificacion);
        }
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_maniobras que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresManiobras(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_maniobras.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 76;
      $.each(response, function(i,items){
        $("input[name=sele_maniobras"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_maniobras_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_finales que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresObservacionFinal(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_finales.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      $.each(response, function(i,items){
        $("#text_observacion_final").val(items.o_observacion);
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresAudios(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_audios.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      if (response != "") {
        $.each(response, function (i, item) {
          $('#select_audio_inspeccion').append($('<option>', { 
            value: item.valor,
            text : item.texto
          }));
        });
      }else{
        $('#select_audio_inspeccion').prop('disabled', 'disabled');
      }
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla puertas_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresFotografias(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/puertas_json_valores_fotografias.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      $.each(response, function (i, item) {
        $('#botonIniciar'+item.codigo_item).attr("disabled", false);
        $('#botonIniciar'+item.codigo_item).removeClass("btn-default");
        $('#botonIniciar'+item.codigo_item).addClass("btn-success");
      });
    }
  });
}

/*=============================================
* Funcion que se ejecuta al seleccionar un audio del select
* Nos muestra una ventana modal donde se reproduce el audio
*==============================================*/
function escucharAudio(select){
  var id_select = $(select).attr("id");
  var codigo_inspector = $(select).val();
  var nombre_audio = $('#'+id_select+' option:selected').text(); //tomamos el texto seleccionado
  $("#audio").remove(); //se elimina el div por si hay algun audio cargado
  if (nombre_audio != "Seleccione un audio") {
    var contenidoDiv = 
    '<audio id="audio" controls autoplay preload>'+
          '<source src="../puertas/inspector_'+codigo_inspector+'/audios/'+cod_inspeccion+'/'+nombre_audio+'" type="audio/ogg">'+
          'Your browser does not support the audio element.'+
      '</audio>';
      $('#nombre_audio').text(nombre_audio);
      $(contenidoDiv).appendTo("#div_audio");
    $("#gridSystemModal").modal();
  }
}

