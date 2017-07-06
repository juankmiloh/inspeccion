$(document).ready(function($){
  /* CARGAR FUNCIONES INICIALES */
  //alert("probando script");
  /* FUNCIONES QUE PERMITEN OPTIMIZAR EL RENDIMIENTO DEL FORMULARIO HTML */
  ocultarDivs();
  clickDivPreliminar();
  clickDivProteccion();
  clickDivElementos();
  clickDivListaVerificacion();
  clickDivDefectos_1();
  clickDivDefectos_2();
  clickDivDefectos_3();
  /* FUNCIONES PARA MODIFICAR LA INSPECCION */
  modificarInspeccion();
  cerrarVentanaAudio();
  $('#botonIniciar0').attr("disabled", true);
  $("#link_botonIniciar0").attr("href", "./escaleras_registros_fotograficos.php?id_inspector="+cod_usuario+"&cod_inspeccion="+cod_inspeccion+"&cod_item=0");
  clickBtnF1();
  clickBtnF2_guardar();
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
* Funcion que se ejecuta cuando se presiona el boton (+) de la lista de inspeccion
* Se verifica si el boton tiene la clase de girar y dependiendo se activa la clase 'animacionVer' la cual permite mostrar los btns flotantes
* y se muestra el 'fbback_1' que es el div verde clarito que permite ocultar los controles
*==============================================*/
function clickBtnF1() {
  $('.botonF1').click(function(){
    if ($('.botonF1').hasClass('botonF1_girar')){
      $('.botonF1').removeClass('botonF1_girar');
      $('.btn_flotante').removeClass('animacionVer');
      $('.fbback_1').hide();
    }else{
      $('.botonF1').addClass('botonF1_girar');
      $('.btn_flotante').addClass('animacionVer');
      $('.texto_boton_flotante').addClass('animacionVer');
      $('.fbback_1').show();
    }
  })
}

/*=============================================
* Funcion que se ejecuta cuando se presiona el boton guardar de la lista de inspeccion
* Se quita la clase 'botonF1_girar' del btn (+) y se ocultan los btns flotantes al igual que el 'fbback_1'
*==============================================*/
function clickBtnF2_guardar() {
  $('.botonF2').click(function(){
    $('.botonF1').removeClass('botonF1_girar');
    $('.btn_flotante').removeClass('animacionVer');
    $('.fbback_1').hide();
  })
}

/*=============================================
* Funcion que se ejecuta cuando se deja de pasar el mouse por encima del btn (+)
* Se quita la clase 'botonF1_girar' del btn (+) y se ocultan los btns flotantes al igual que el 'fbback_1'
* En la aplicacion funciona es pinchando en el div verde 'fbback_1'
*==============================================*/
function dejarContenerdorBtnsFLot() {
  $('.contenedor_btns_flotantes').mouseleave(function(){
    $('.botonF1').removeClass('botonF1_girar');
    $('.btn_flotante').removeClass('animacionVer');
    $('.fbback_1').hide();
  })
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
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('hide');
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
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('hide');
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
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('hide');
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
  $('#items_lista_verificacion').show('fast');
  location.href = "#campo_focus_4";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de DEFECTOS - LISTA # 1
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivDefectos_1(){
  $(".div_5").click(function(){
    mostrarDivDefectos_1();
  });
}

function mostrarDivDefectos_1(){
  location.href = "#campo_focus_4";
  $('#items_lista_verificacion').show();
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_defectos_1').collapse('show');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de DEFECTOS - LISTA # 2
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivDefectos_2(){
  $(".div_6").click(function(){
    mostrarDivDefectos_2();
  });
}

function mostrarDivDefectos_2(){
  location.href = "#campo_focus_5";
  $('#items_lista_verificacion').show();
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('show');
  $('#collapse_defectos_3').collapse('hide');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el div de DEFECTOS - LISTA # 3
* Permite mostrar u ocultar los conrtoles para un mejor rendimiento del app
*==============================================*/
function clickDivDefectos_3(){
  $(".div_7").click(function(){
    mostrarDivDefectos_3();
  });
}

function mostrarDivDefectos_3(){
  $('#items_lista_verificacion').show();
  location.href = "#campo_focus_6";
  $('#collapse_evaluacion_preliminar').collapse('hide');
  $('#collapse_elementos_proteccion_personal').collapse('hide');
  $('#collapse_elementos_del_inspector').collapse('hide');
  $('#collapse_defectos_1').collapse('hide');
  $('#collapse_defectos_2').collapse('hide');
  $('#collapse_defectos_3').collapse('show');
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
  Concurrent.Thread.create(obtenerValoresDefectos);
  Concurrent.Thread.create(obtenerValoresObservacionFinal);
  Concurrent.Thread.create(obtenerValoresAudios);
  Concurrent.Thread.create(obtenerValoresFotografias);
}

/*=============================================
* Funcion para hacer un select a la tabla escaleras_valores_iniciales
*==============================================*/
function obtenerValoresIniciales(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/escaleras_json_valores_iniciales.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      $.each(response, function(i,items){
        var textCliente = items.n_cliente;
        var cliente_direccion = items.o_direccion_cliente;
        var textEquipo = items.n_equipo;
        var textEmpresaMantenimiento = items.n_empresamto;
        var text_velocidad = items.v_velocidad;
        var text_tipoEquipo = items.o_tipo_equipo;
        var text_inclinacion = items.v_inclinacion;
        var text_ancho_paso = items.v_ancho_paso;
        var textFecha = items.f_fecha;
        var text_ultimo_mto = items.ultimo_mto;
        var text_inicio_servicio = items.inicio_servicio;
        var text_ultima_inspec = items.ultima_inspeccion;
        var consecutivo = items.o_consecutivoinsp;

        cargarValoresIniciales(textCliente,cliente_direccion,textEquipo,textEmpresaMantenimiento,text_velocidad,
                             text_tipoEquipo,text_inclinacion,text_ancho_paso,textFecha,
                             text_ultimo_mto,text_inicio_servicio,text_ultima_inspec,consecutivo);
      });
    }
  });
}

/*=============================================
* Funcion para mostrar los valores obtenidos de la consulta en los respectivos campos del formulario
*==============================================*/
function cargarValoresIniciales(textCliente,cliente_direccion,textEquipo,textEmpresaMantenimiento,text_velocidad,
                                text_tipoEquipo,text_inclinacion,text_ancho_paso,textFecha,
                                text_ultimo_mto,text_inicio_servicio,text_ultima_inspec,consecutivo){
  $("#text_cliente").val(textCliente);
  $("#text_dir_cliente").val(cliente_direccion);
  $("#text_equipo").val(textEquipo);
  $("#text_empresaMantenimiento").val(textEmpresaMantenimiento);
  $("#text_velocidad").val(text_velocidad);
  $("#text_tipoEquipo").val(text_tipoEquipo);
  $("#text_inclinacion").val(text_inclinacion);
  $("#text_ancho_paso").val(text_ancho_paso);
  $("#text_fecha").val(textFecha);
  $("#text_ultimo_mto").val(text_ultimo_mto);
  $("#text_inicio_servicio").val(text_inicio_servicio);
  $("#text_ultima_inspec").val(text_ultima_inspec);
  $("#text_consecutivo").val(consecutivo);
}

/*=============================================
* Funcion para hacer un select a la tabla ascensor_valores_preliminar que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresPreliminar(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/escaleras_json_valores_preliminar.php",
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
    url: "../php/escaleras_json_valores_proteccion.php",
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
    url: "../php/escaleras_json_valores_elementos.php",
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
* Funcion para hacer un select a la tabla escaleras_valores_defectos
*==============================================*/
function obtenerValoresDefectos(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/escaleras_json_valores_defectos.php",
    data: parametros,
    type: "POST",
    dataType : "JSON",
    success: function(response){
      //alert(response);
      var contador = 1;
      $.each(response, function(i,items){
        $("input[name=sele_defectos"+contador+"][value='"+items.v_calificacion+"']").prop("checked",true);
        $('#text_lv_valor_observacion_'+contador).val(items.o_observacion);
        if (contador == 77) {
          $('#text_calificacion77').val(items.n_calificacion);
          $('#cal_item_defectos77').val(items.n_calificacion);
        }
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
    url: "../php/escaleras_json_valores_finales.php",
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
* Funcion para hacer un select a la tabla escaleras_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresAudios(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/escaleras_json_valores_audios.php",
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
* Funcion para hacer un select a la tabla escaleras_valores_audios que recibe por parametro el codigo de la inspeccion
*==============================================*/
function obtenerValoresFotografias(){
  var parametros = {"inspector" : cod_usuario, "inspeccion" : cod_inspeccion};
  $.ajax({
    url: "../php/escaleras_json_valores_fotografias.php",
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
          '<source src="../escaleras/inspector_'+codigo_inspector+'/audios/'+cod_inspeccion+'/'+nombre_audio+'" type="audio/ogg">'+
          'Your browser does not support the audio element.'+
      '</audio>';
      $('#nombre_audio').text(nombre_audio);
      $(contenidoDiv).appendTo("#div_audio");
    $("#gridSystemModal").modal();
  }
}