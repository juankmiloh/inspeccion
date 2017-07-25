$(document).ready(function(){
	//alert("fruta!");
	fechaFooter();
	$('.contenedor_login').hide();
	$('#div_btn_inspeccion_apk').hide();
	$('#div_btn_grabadora_apk').hide();
	$('#div_btn_regresar').hide();
	click_btn_iniciar_sesion();
	click_btn_descargas();
	click_btn_regresar();
	click_btn_descargar_inspeccion();
	click_btn_descargar_grabadora();
});

/* Fecha del footer */
function fechaFooter(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f = new Date();
	var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
	$('#fecha_footer').text(fecha);
}

/*=============================================
* Funcion que permite cerrar la ventana que aparece mientras se cargan las tablas a la base de datos
*==============================================*/
function cerrarVentanaCarga(){
  $('#fbdrag1').fadeOut().prev().fadeOut();
  $('body').css('overflow','auto');
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el boton iniciar sesion
*==============================================*/
function click_btn_iniciar_sesion(){
	$("#btn_iniciar").click(function(){
		if( $('#div_login').is(":visible") ){ //esta visible
			//si esta visible
			$('.contenedor_login').hide("fast");
		}else{
			//si no esta visible
			var focalizar = $("#div_btn_descargas").position().top;
			$('.contenedor_login').show();
			$('html,body').animate({scrollTop: focalizar}, 1000);
		}
  	});
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el boton descargas
*==============================================*/
function click_btn_descargas(){
	$("#btn_descargas").click(function(){
		mostrarDescargas();
  	});
}

/*=============================================
* Funcion que permite ocultar el btn descargas y mostrar los botones de btn_inspeccion_apk - btn_grabadora_apk - btn_regresar
*==============================================*/
function mostrarDescargas(){
	if( $('#div_btn_inspeccion_apk').is(":visible") && $('#div_btn_grabadora_apk').is(":visible") ){ //esta visible
		//si esta visible el div
	}else{
		//si no esta visible el div
		$('#div_btn_descargas').hide();
		$('#btn_iniciar').hide();
		$('#div_login').hide("fast");
		$('#div_btn_inspeccion_apk').show();
		$('#div_btn_grabadora_apk').show();
		$('#div_btn_regresar').show();
	}
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el boton descargas
*==============================================*/
function click_btn_regresar(){
	$("#btn_regresar").click(function(){
		mostrarBtnDescargas();
  	});
}

/*=============================================
* Funcion que permite mostrar el btn descargas y ocultar los botones de btn_inspeccion_apk - btn_grabadora_apk - btn_regresar
*==============================================*/
function mostrarBtnDescargas(){
	if( $('#div_btn_descargas').is(":visible") ){ //esta visible
		//si esta visible el div
	}else{
		//si no esta visible el div
		$('#div_btn_descargas').show();
		$('#btn_iniciar').show();
		$('#div_btn_inspeccion_apk').hide();
		$('#div_btn_grabadora_apk').hide();
		$('#div_btn_regresar').hide();
	}
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el boton descargar aplicacion inspeccion MP
*==============================================*/
function click_btn_descargar_inspeccion(){
	$("#btn_descargar_inspeccion").click(function(){
		descargarInspeccionMpApk();
  	});
}

/*=============================================
* Funcion que permite descargar Inspeccion_MP-debug.apk
*==============================================*/
function descargarInspeccionMpApk(){
  $('.fb').show();
  $('.fbback').show();
  $('body').css('overflow','hidden');
  location.href="http://192.168.0.26:8080/inspeccion/servidor/aplicacion/Inspeccion_MP-debug.apk";
  cerrarVentanaCarga();
}

/*=============================================
* Funcion que se ejecuta cuando clickamos en el boton descargar aplicacion grabadora
*==============================================*/
function click_btn_descargar_grabadora(){
	$("#btn_descargar_grabadora").click(function(){
		descargarGrabadoraApk();
  	});
}

/*=============================================
* Funcion que permite descargar grabadora.apk
*==============================================*/
function descargarGrabadoraApk(){
  $('.fb').show();
  $('.fbback').show();
  $('body').css('overflow','hidden');
  location.href="http://192.168.0.26:8080/inspeccion/servidor/aplicacion/grabadora.apk";
  cerrarVentanaCarga();
}