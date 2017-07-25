jQuery(document).ready(function($){
  //alert("probando script");
});

var myWindow;

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
* Funcion que permite abrir la ventana que aparece mientras se guarda la inspeccion
*==============================================*/
function abrir_Ventana_Carga(){
  $('.fb').show();
  $('.fbback').show();
  $('body').css('overflow','hidden');
}

/*=============================================
* Funcion que permite cerrar la ventana que aparece mientras se guarda la inspeccion
* Luego de que se guarde se muestra una alerta y se redirige al index
*==============================================*/
function cerrar_Ventana_Carga(message){
  $('.fb').hide();
  $('.fbback').hide();
  $('body').css('overflow','auto');
  if (message != "mensaje_no") {
    if(navigator.notification && navigator.notification.alert){
      navigator.notification.alert(message, null, "Montajes & Procesos M.P SAS", "Aceptar");
    }else{
      alert(message);
    }
  }
}

/*=============================================
* Funcion que permite mostrar la fecha
*==============================================*/
function mostrarFecha(){
  var fecha = new Date();
  var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  var numero_meses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
  var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  var dia = 0;   
  
  if (fecha.getDate() < 10) {
    dia = "0"+fecha.getDate();
  } else {
    dia = fecha.getDate();
  }

  fecha = dia+"/"+numero_meses[fecha.getMonth()]+"/"+fecha.getFullYear();
  return fecha;
}

function mostrarDetalleFoto(nombre_foto){
    var codigo_inspector = getQueryVariable('id_inspector');
    var codigo_inspeccion = getQueryVariable('cod_inspeccion');
    var largeImage = document.getElementById('imagen_modal');
    largeImage.src="../escaleras/inspector_"+codigo_inspector+"/fotografias/"+codigo_inspeccion+"/"+nombre_foto+"";
    $('#nombre_foto').text(nombre_foto);
}

function eliminarFotografia(btn){
    var nombre_foto = $(btn).attr("id");
    var codigo_inspeccion = getQueryVariable('cod_inspeccion');
    var codigo_inspector = getQueryVariable('id_inspector');
    var cod_item = getQueryVariable('cod_item');

    var parametros = {"inspector" : codigo_inspector, "inspeccion" : codigo_inspeccion, "item" : cod_item, "foto" : nombre_foto};
    $.ajax({
        url: "escaleras_eliminar_valores_fotografias.php",
        data: parametros,
        type: "POST",
        dataType : "JSON",
        success: function(response){
            //alert(response);
            if (response == 0) {
                window.opener.location.reload(); //codigo para actualizar la pagina web anterior que abre esta ultima
                location.href="escaleras_registros_fotograficos.php?id_inspector="+codigo_inspector+"&cod_inspeccion="+codigo_inspeccion+"&cod_item="+cod_item+"";
            }else{
                alert("Ocurrio un error al eliminar la fotografía :(");
            }
        }
    });
}

/*=============================================
* Funcion que permite crear en el servidor el PDF de la inspeccion y mostrarlo en una nueva pestaña
* el codigo de inspeccion se obtiene de la URL
* el consecutivo se obtiene de una consulta SQL y se guarda en un campo oculto para poder pasar este valor a la ruta del servidor y poder mostrar el PDF generado
*==============================================*/
function crearPDF(){
  location.href = "#arriba";
  abrir_Ventana_Carga();
  var codigo_inspector = getQueryVariable('id_inspector');
  var codigo_inspeccion = getQueryVariable('cod_inspeccion');
  var consecutivo_inspeccion = $('#consecutivo_inspeccion').val();
  $('#texto_carga').text('Creando PDF...Espere');
  $.post('escaleras_crear_pdf_inspeccion.php',{
    codigo_inspector: codigo_inspector,
    codigo_inspeccion: codigo_inspeccion,
    fecha_emision: mostrarFecha(),
    servidor: "si"
  },function(e){
    //alert("crearPDF-> "+e);
    if (e == 0) {
      $('#texto_carga').text('PDF de inspección Saved...OK');
      myWindow = window.open('http://192.168.0.26:8080/inspeccion/servidor/escaleras/servidor/inspector_'
                  +codigo_inspector
                  +'/registros_pdf/'
                  +consecutivo_inspeccion
                  +'.pdf','_blank');// <- This is what makes it open in a new window. //linea para descargar el PDF
      
      setTimeout(function(){ myWindow.location.reload(); }, 1000); //Se actualiza la nueva pagina que se abre para poder mostrar los cambios del pdf
      cerrar_Ventana_Carga("mensaje_no");
    }else{
      cerrar_Ventana_Carga("Ocurrio un error al enviar los datos al servidor! crearPDF\n\nCódigo de error: "+e);
    }
  });
}

/*=============================================
* Funcion que permite crear en el servidor el PDF de la inspeccion
*==============================================*/
function crear_pdf_correo(){
  var text_correo = prompt("INGRESE EL CORREO ELECTRÓNICO:");
  if(text_correo == undefined){
    //alert("Ha pulsado cancelar");
  }else if(text_correo == ""){
    //alert("Ha pulsado aceptar con el campo vacio");
  }else{
    if (!(/^([a-z0-9])([\w\.\-\+])+([a-z0-9])\@(([\w\-]?)+\.)+([a-z]{2,4})$/i.test(text_correo))) { //validamos si es un correo electronico
      alert("Debe ingresar un correo electrónico válido!");
    }else{
      location.href = "#arriba";
      abrir_Ventana_Carga();
      var codigo_inspector = getQueryVariable('id_inspector');
      var codigo_inspeccion = getQueryVariable('cod_inspeccion');
      $('#texto_carga').text('Creando PDF...Espere');
      $.post('escaleras_crear_pdf_inspeccion.php',{
        codigo_inspector: codigo_inspector,
        codigo_inspeccion: codigo_inspeccion,
        fecha_emision: mostrarFecha(),
        servidor: "si"
      },function(e){
        //alert("crearPDF-> "+e);
        if (e == 0) {
          $('#texto_carga').text('PDF de inspección Saved...OK');
          enviar_email(text_correo);
        }else{
          cerrar_Ventana_Carga("Ocurrio un error al enviar los datos al servidor! crearPDF\n\nCódigo de error: "+e);
        }
      });
    }
  }
}

function enviar_email(text_correo){
  $('#texto_carga').text('Enviando correo...Espere');
  var codigo_inspector = getQueryVariable('id_inspector');
  var correo_electronico = text_correo;
  var nombre_empresa = $('#text_cliente').val();
  $.post('../php/email/escaleras_servidor_enviar_correo.php',{
    codigo_inspector: codigo_inspector,
    correo: correo_electronico,
    nombre_empresa: nombre_empresa
  },function(e){
    //alert("enviarCorreoElectronico-> "+e);
    if (e == 0) {
      cerrar_Ventana_Carga("Envío de email exitoso!");
    }else{
      cerrar_Ventana_Carga("Ocurrio un error al enviar el correo electrónico! enviarCorreoElectronico\n\nCódigo de error: "+e);
    }
  });
}