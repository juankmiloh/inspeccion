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
* Funcion que permite mostrar la tabla respectiva dependiendo el tipo de inspeccion seleccionada
*==============================================*/
function enviarTipoInspeccion(select){
	var tipo_inspeccion = $(select).val();
	window.sessionStorage.setItem("tipo_inspeccion", tipo_inspeccion); //Enviamos por sesion el id del inspector
	cargarInspectores();
	$('#select_inspecciones').prop('disabled', 'disabled');
	$('#select_inspector').prop('selectedIndex','n/a'); //reiniciamos el select
	$('#select_inspecciones').prop('selectedIndex','n/a'); //reiniciamos el select
	$('#div_ascensores').hide();
	$('#div_escaleras').hide();
	$('#div_puertas').hide();
}

/*=============================================
* Funcion que hace una consulta ajax a la base de datos y carga en el select los inspectores
*==============================================*/
function cargarInspectores(){
	$.ajax({
        type: "POST",
        url: "admin_cargar_inspector.php",
        success: function(response){
            $('#select_inspector').html(response).fadeIn();
        }
	});
	$('#select_inspector').prop('disabled', false);
}

/*=============================================
* Funcion que se ejecuta al seleccionar un inspector del select de inspectores
* Se hace una consulta ajax a la bd y se cargan las inspecciones relacionadas al inspector
*==============================================*/
function cargarInspecciones(select){
	/* Limpiamos la tabla */
	$('#div_ascensores').hide();
	$('#div_escaleras').hide();
	$('#div_puertas').hide();
	$("#tabla_ascensores tbody tr").remove();
	$("#tabla_puertas tbody tr").remove();
	$("#tabla_escaleras tbody tr").remove();

	var codigo_inspector = $(select).val();
	window.sessionStorage.setItem("codigo_inspector", codigo_inspector); //Enviamos por sesion el id del inspector
	var tipo_inspeccion = window.sessionStorage.getItem("tipo_inspeccion");

	var parametros = {"inspector" : codigo_inspector};
	/* TIPO INSPECCION ASCENSORES */
	if (tipo_inspeccion == 1) {
		$.ajax({
			url: "admin_cargar_inspecciones_ascensores.php",
			data: parametros,
	        type: "POST",
	        success: function(response){
	            $('#select_inspecciones').html(response).fadeIn(); //response recibe cada echo que devuelve el script php
	        }
		});
		$('#select_inspecciones').prop('disabled', false);
	}
	/* TIPO INSPECCION PUERTAS */
	if (tipo_inspeccion == 2) {
		$.ajax({
			url: "admin_cargar_inspecciones_puertas.php",
			data: parametros,
	        type: "POST",
	        success: function(response){
	            $('#select_inspecciones').html(response).fadeIn(); //response recibe cada echo que devuelve el script php
	        }
		});
		$('#select_inspecciones').prop('disabled', false);
	}
	/* TIPO INSPECCION ESCALERAS */
	if (tipo_inspeccion == 3) {
		$.ajax({
			url: "admin_cargar_inspecciones_escaleras.php",
			data: parametros,
	        type: "POST",
	        success: function(response){
	            $('#select_inspecciones').html(response).fadeIn(); //response recibe cada echo que devuelve el script php
	        }
		});
		$('#select_inspecciones').prop('disabled', false);
	}
}

/*=============================================
* Funcion que se ejecuta al seleccionar un inspeccion del select de inspecciones
* Hace una consulta ajax que recibe una respuesta en formato JSON
* Se recorre el JSON y se muestran los datos en una tabla html
*==============================================*/
function cargarDatos(select){
	var codigo_inspeccion = $(select).val();
	window.sessionStorage.setItem("codigo_inspeccion", codigo_inspeccion); //Enviamos por sesion el id de la inspeccion
	var codigo_inspector = window.sessionStorage.getItem("codigo_inspector");
	var tipo_inspeccion = window.sessionStorage.getItem("tipo_inspeccion");

	var parametros = {"inspector" : codigo_inspector, "inspeccion" : codigo_inspeccion};
	/* TIPO INSPECCION ASCENSORES */
	if (tipo_inspeccion == 1) {
		$('#div_ascensores').show('fast');
		$('#div_escaleras').hide('fast');
		$('#div_puertas').hide('fast');
		$.ajax({
			url: "admin_obtener_datos_inspeccion_ascensor.php",
			data: parametros,
	        type: "POST",
	        dataType : "JSON",
	        success: function(response){ //response recibe los datos en formato JSON
	        	//alert(response);
	            $.each(response, function(i,items){
	            	//alert(items.cantidad_fotos);
				  	var contenidoTabla = 
				  		'<tr id="fila'+items.k_codinspeccion+'">'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.k_codusuario+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_consecutivoinsp+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_revision+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.v_item_nocumple+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.fecha_inspeccion+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 21px;">'+
	                            '<select class="form-control" id="select_audio'+items.k_codinspeccion+'" onchange="escucharAudio(this)">'+
                                    '<option value="n/a">Seleccione un audio</option>'+
                                '</select>'+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 15px;">'+
	                            '<a href="../php/ascensor_modificar_lista_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
	                                '<img src="../images/lupa.png" style="width: 3em;">'+
	                            '</a>'+
	                        '</td>';
	                        if (items.cantidad_fotos > 0) {
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="">'+
		                            '<a href="../php/ascensor_fotografias_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
		                                '<img src="../images/camera.png" style="width: 3em;">'+
		                            '</a>'+
		                        '</td>';
	                        }else{
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="padding: 15px;">'+
	                        		'<img src="../images/camera_1.png" style="width: 3em; cursor:not-allowed;">'+
		                        '</td>';
	                        }
	               	contenidoTabla += 
	               			'<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_password_pdf+
	                        '</td>'+
	                    '</tr>';
	                //alert(items.cantidad_inspecciones);
				    $("#tabla_ascensores tbody").append(contenidoTabla);
				    $("#select_inspecciones").find("option[value='"+items.k_codinspeccion+"']").remove();

				    if (items.archivos_audio != "") {
				    	$.each(items.archivos_audio, function (i, item) {
				    		$('#select_audio'+items.k_codinspeccion).append($('<option>', { 
						        value: item.valor,
						        text : item.texto
						    }));
						});
				    }else{
				    	$('#select_audio'+items.k_codinspeccion).prop('disabled', 'disabled');
				    }
				    
				    var focalizar = $("#div_focalizar").position().top; //div a donde se quiere scrollear la pagina
					$('html,body').animate({scrollTop: focalizar}, 1000);
				});
	        }
		});
	}

	/* TIPO INSPECCION PUERTAS */
	if (tipo_inspeccion == 2) {
		//alert("puertas");
		$('#div_ascensores').hide('fast');
		$('#div_puertas').show('fast');
		$('#div_escaleras').hide('fast');
		$.ajax({
			url: "admin_obtener_datos_inspeccion_puertas.php",
			data: parametros,
	        type: "POST",
	        dataType : "JSON",
	        success: function(response){ //response recibe los datos en formato JSON
	            $.each(response, function(i,items){
				  	var contenidoTabla = 
				  		'<tr id="fila'+items.k_codinspeccion+'">'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.k_codusuario+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_consecutivoinsp+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_revision+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.v_item_nocumple+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.fecha_inspeccion+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 21px;">'+
	                            '<select class="form-control" id="select_audio'+items.k_codinspeccion+'" onchange="escucharAudio(this)">'+
                                    '<option value="n/a">Seleccione un audio</option>'+
                                '</select>'+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 15px;">'+
	                            '<a href="../php/puertas_modificar_lista_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
	                                '<img src="../images/lupa.png" style="width: 3em;">'+
	                            '</a>'+
	                        '</td>';
	                        if (items.cantidad_fotos > 0) {
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="">'+
		                            '<a href="../php/puertas_fotografias_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
		                                '<img src="../images/camera.png" style="width: 3em;">'+
		                            '</a>'+
		                        '</td>';
	                        }else{
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="padding: 15px;">'+
	                        		'<img src="../images/camera_1.png" style="width: 3em; cursor:not-allowed;">'+
		                        '</td>';
	                        }
	               	contenidoTabla += 
	               			'<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_password_pdf+
	                        '</td>'+
	                    '</tr>';
	                //alert(items.cantidad_inspecciones);
				    $("#tabla_puertas tbody").append(contenidoTabla);
				    $("#select_inspecciones").find("option[value='"+items.k_codinspeccion+"']").remove();

				    if (items.archivos_audio != "") {
				    	$.each(items.archivos_audio, function (i, item) {
				    		$('#select_audio'+items.k_codinspeccion).append($('<option>', { 
						        value: item.valor,
						        text : item.texto
						    }));
						});
				    }else{
				    	$('#select_audio'+items.k_codinspeccion).prop('disabled', 'disabled');
				    }
				    
				    var focalizar = $("#div_focalizar").position().top; //div a donde se quiere scrollear la pagina
					$('html,body').animate({scrollTop: focalizar}, 1000);
				});
	        }
		});
	}

	/* TIPO INSPECCION ESCALERAS */
	if (tipo_inspeccion == 3) {
		//alert("escaleras");
		$('#div_ascensores').hide('fast');
		$('#div_escaleras').hide('fast');
		$('#div_escaleras').show('fast');
		$.ajax({
			url: "admin_obtener_datos_inspeccion_escaleras.php",
			data: parametros,
	        type: "POST",
	        dataType : "JSON",
	        success: function(response){ //response recibe los datos en formato JSON
	            $.each(response, function(i,items){
				  	var contenidoTabla = 
				  		'<tr id="fila'+items.k_codinspeccion+'">'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.k_codusuario+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_consecutivoinsp+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_revision+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.v_item_nocumple+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 25px;">'+
	                            items.fecha_inspeccion+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 21px;">'+
	                            '<select class="form-control" id="select_audio'+items.k_codinspeccion+'" onchange="escucharAudio(this)">'+
                                    '<option value="n/a">Seleccione un audio</option>'+
                                '</select>'+
	                        '</td>'+
	                        '<td class="centrar_texto" style="padding: 15px;">'+
	                            '<a href="../php/escaleras_modificar_lista_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
	                                '<img src="../images/lupa.png" style="width: 3em;">'+
	                            '</a>'+
	                        '</td>';
	                        if (items.cantidad_fotos > 0) {
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="">'+
		                            '<a href="../php/escaleras_fotografias_inspeccion.php?id_inspector='+items.k_codusuario+'&cod_inspeccion='+items.k_codinspeccion+'" target="_blank">'+
		                                '<img src="../images/camera.png" style="width: 3em;">'+
		                            '</a>'+
		                        '</td>';
	                        }else{
	                        	contenidoTabla += 
	                        	'<td class="centrar_texto" style="padding: 15px;">'+
	                        		'<img src="../images/camera_1.png" style="width: 3em; cursor:not-allowed;">'+
		                        '</td>';
	                        }
	               	contenidoTabla += 
	               			'<td class="centrar_texto" style="padding: 25px;">'+
	                            items.o_password_pdf+
	                        '</td>'+
	                    '</tr>';
	                //alert(items.cantidad_inspecciones);
				    $("#tabla_escaleras tbody").append(contenidoTabla);
				    $("#select_inspecciones").find("option[value='"+items.k_codinspeccion+"']").remove();

				    if (items.archivos_audio != "") {
				    	$.each(items.archivos_audio, function (i, item) {
				    		$('#select_audio'+items.k_codinspeccion).append($('<option>', { 
						        value: item.valor,
						        text : item.texto
						    }));
						});
				    }else{
				    	$('#select_audio'+items.k_codinspeccion).prop('disabled', 'disabled');
				    }
				    
				    var focalizar = $("#div_focalizar").position().top; //div a donde se quiere scrollear la pagina
					$('html,body').animate({scrollTop: focalizar}, 1000);
				});
	        }
		});
	}
}

/*=============================================
* Funcion que se ejecuta al seleccionar un audio del select
* Nos muestra una ventana modal donde se reproduce el audio
*==============================================*/
function escucharAudio(select){
	var id_select = $(select).attr("id");
	var codigo_inspector = $(select).val();
	var codigo_inspeccion = window.sessionStorage.getItem("codigo_inspeccion");
	var nombre_audio = $('#'+id_select+' option:selected').text(); //tomamos el texto seleccionado
	$("#audio").remove(); //se elimina el div por si hay algun audio cargado
	if (nombre_audio != "Seleccione un audio") {
		var contenidoDiv = 
		'<audio id="audio" controls autoplay preload>'+
	        '<source src="../informes/inspector_'+codigo_inspector+'/audios/'+nombre_audio+'" type="audio/ogg">'+
	        'Your browser does not support the audio element.'+
	    '</audio>';
	    $('#nombre_audio').text(nombre_audio);
	    $(contenidoDiv).appendTo("#div_audio");
	 	$("#gridSystemModal").modal();
	}
}
