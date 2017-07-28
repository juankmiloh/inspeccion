$(document).ready(function(){
	//alert("probando script");
	$('#div_ascensores').hide();
	$('#div_escaleras').hide();
	$('#div_puertas').hide();
	$('#select_inspector').prop('disabled', 'disabled');
	$('#select_inspecciones').prop('disabled', 'disabled');
	mostrarBarraHeader();
	fechaFooter();
	window.sessionStorage.removeItem("tipo_inspeccion");
	cerrarVentanaAudio();
	clickBtnF1();
	clickBtnF2_guardar();
});

/* Inicializamos la variable withClass */
var withClass = false;

/* Fecha del footer */
function fechaFooter(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	$('#fecha_footer').text(fecha);
}

/*=============================================
* Funcion que permite mostrar la barra fija al header cuando se scrollea la pagina
*==============================================*/
function mostrarBarraHeader(){
  $(document).scroll(function(e){
    if($(window).scrollTop() >= ($("#top_home").height()*1)){
      if(!withClass){
        jQuery('#header').removeClass("sombra");
        jQuery('#header').addClass("av_header_effect");
        withClass = true;
      }           
    }
    if($(window).scrollTop() < ($("#top_home").height()*1)){
      jQuery('#header').removeClass("av_header_effect");
      jQuery('#header').addClass("sombra");
      withClass = false;
    }
  });  
}

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
* Funcion que permite abrir la ventana de carga
*==============================================*/
function abrirVentanaCarga(texto){
	$('#texto_carga').text(texto);
	$('#fbdrag1').show();
	$('.fb').show();
	$('.fbback').show();
	$('body').css('overflow','hidden');
}

/*=============================================
* Funcion que permite cerrar la ventana que aparece mientras se cargan las tablas a la base de datos
*==============================================*/
function cerrarVentanaCarga(){
	$('#fbdrag1').hide();
	$('.fb').hide();
	$('.fbback').hide();
	$('body').css('overflow','auto');
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


