$(document).ready(function($){
  //alert("probando script!");
  /* FUNCIONES QUE PERMITEN OPTIMIZAR EL RENDIMIENTO DEL FORMULARIO HTML */
  ocultarDivs();
  clickDivPreliminar();
  clickDivProteccion();
  clickDivElementos();
  clickDivListaVerificacion();
  clickDivCabina();
  clickDivMaquinas();
  clickDivPozo();
  clickDivFoso();
  /* FUNCIONES PARA MODIFICAR LA INSPECCION */
	modificarInspeccion();
  cerrarVentanaAudio();
  $('#botonIniciar0').attr("disabled", true);
  $("#link_botonIniciar0").attr("href", "./ascensor_registros_fotograficos.php?id_inspector="+cod_inspector+"&cod_inspeccion="+cod_inspeccion+"&cod_item=0");
});

var cod_inspeccion = getQueryVariable('cod_inspeccion');
var cod_inspector = getQueryVariable('id_inspector');

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
  location.href = "#campo_focus_2";
  $('#collapse_evaluacion_preliminar').collapse('show');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
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
  location.href = "#campo_focus_2";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('show');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
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
  location.href = "#campo_focus_3";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('show');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
  $('#items_lista_verificacion').hide();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de LISTA DE VERIFICACIÓN 5926-1
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
  location.href = "#campo_focus_4";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
  $('#items_lista_verificacion').show('fast');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de CABINA
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivCabina(){
  $(".div_5").click(function(){
    mostrarDivCabina();
  });
}

function mostrarDivCabina(){
  location.href = "#campo_focus_4";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('show');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
  $('#items_lista_verificacion').show('fast');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de CUARTO DE MAQUINAS Y POLEAS
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivMaquinas(){
  $(".div_6").click(function(){
    mostrarDivMaquinas();
  });
}

function mostrarDivMaquinas(){
  location.href = "#campo_focus_5";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('show');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('hide');
  $('#items_lista_verificacion').show('fast');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de REVISIÓN DE POZO
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivPozo(){
  $(".div_7").click(function(){
    mostrarDivPozo();
  });
}

function mostrarDivPozo(){
  location.href = "#campo_focus_6";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('show');
  $('#collapse_foso').collapse('hide');
  $('#items_lista_verificacion').show('fast');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de REVISIÓN DE FOSO
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivFoso(){
  $(".div_8").click(function(){
    mostrarDivFoso();
  });
}

function mostrarDivFoso(){
  location.href = "#campo_focus_7";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_cabina').collapse('hide');
  $('#collapse_maquinas').collapse('hide');
  $('#collapse_pozo').collapse('hide');
  $('#collapse_foso').collapse('show');
  $('#items_lista_verificacion').show('fast');
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
  Concurrent.Thread.create(obtenerValoresCabina);
  Concurrent.Thread.create(obtenerValoresMaquinas);
  Concurrent.Thread.create(obtenerValoresPozo);
  Concurrent.Thread.create(obtenerValoresFoso); 
  Concurrent.Thread.create(obtenerValoresObservacionFinal);
  Concurrent.Thread.create(obtenerValoresAudios);
  Concurrent.Thread.create(obtenerValoresFotografias);
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_iniciales que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresIniciales(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_iniciales.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      $.each(response, function(i,items){
        var cliente = items.n_cliente;
        var nombre_equipo = items.n_equipo;
        var empresa_mto = items.n_empresamto;
        var accionamiento = items.o_tipoaccion;
        var capac_person = items.v_capacperson;
        var capac_peso = items.v_capacpeso;
        var fecha = items.f_fecha;
        var num_paradas = items.v_paradas;
        var consecutivo = items.o_consecutivoinsp;
        var ultimo_mto = items.ultimo_mto;
        var inicio_servicio = items.inicio_servicio;
        var ultima_inspeccion = items.ultima_inspeccion;

        cargarValoresIniciales(cliente,nombre_equipo,empresa_mto,accionamiento,capac_person,capac_peso,num_paradas,fecha,consecutivo,ultimo_mto,inicio_servicio,ultima_inspeccion);
        obtenerValoresPreliminar(cod_inspector,cod_inspeccion);
      });
    }
  });
}

/*=============================================
* Funcion para mostrar los valores obtenidos de la consulta en los respectivos campos del formulario
*==============================================*/
function cargarValoresIniciales(cliente,nombre_equipo,empresa_mto,accionamiento,capac_person,capac_peso,num_paradas,fecha,consecutivo,ultimo_mto,inicio_servicio,ultima_inspeccion){
  $("#text_cliente").val(cliente);
	$("#text_equipo").val(nombre_equipo);
	$("#text_empresaMantenimiento").val(empresa_mto);
	$("#text_tipoAccionamiento").val(accionamiento);
	$("#text_capacidadPersonas").val(capac_person);
	$("#text_capacidadPeso").val(capac_peso);
	$("#text_numeroParadas").val(num_paradas);
	$("#text_fecha").val(fecha);
	$("#text_consecutivo").val(consecutivo);
	$("#text_ultimo_mto").val(ultimo_mto);
	$("#text_inicio_servicio").val(inicio_servicio);
	$("#text_ultima_inspec").val(ultima_inspeccion);
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_preliminar que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresPreliminar(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_preliminar.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
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
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_proteccion.php",
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
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_elementos.php",
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
* Funcion para hacer un select a la tabla ascensor_valores_cabina que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresCabina(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_cabina.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=sele_cabina"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_lv_valor_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_maquinas que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresMaquinas(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_maquinas.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 36;
      $.each(response, function(i,items){
        $("input[name=sele_maquinas"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_maquinas_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_pozo que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresPozo(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_pozo.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 83;
      $.each(response, function(i,items){
        $("input[name=sele_pozo"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_pozo_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_foso que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresFoso(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_foso.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      var contador = 148;
      $.each(response, function(i,items){
        $("input[name=sele_foso"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_foso_observacion_'+contador).val(items.o_observacion);
        contador += 1;
      });
    }
  });
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_finales que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresObservacionFinal(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_finales.php",
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
* Funcion para hacer un select a la tabla ascensor_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresAudios(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_audios.php",
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
* Funcion para hacer un select a la tabla ascensor_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresFotografias(){
  var parametros = {"inspector" : cod_inspector, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/ascensor_json_valores_fotografias.php",
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
          '<source src="../ascensores/inspector_'+codigo_inspector+'/audios/'+cod_inspeccion+'/'+nombre_audio+'" type="audio/ogg">'+
          'Your browser does not support the audio element.'+
      '</audio>';
      $('#nombre_audio').text(nombre_audio);
      $(contenidoDiv).appendTo("#div_audio");
    $("#gridSystemModal").modal();
  }
}

