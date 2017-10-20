'use strict';
angular.module('cardDemo', [
  'ngAnimate',
  'ngCookies',
  'ngResource',
  'ngRoute',
  'ngSanitize',
  'ngTouch',
  'ngMaterial'
])

.controller('AppCtrl', function($scope,$http,$mdDialog) {
	//CARGAR OPCIONES DE LAS NOTIFICACIONES DE ASCENSORES
  $http.get("./admin_notificaciones_ascensor.php")
	.then(function(result) {
    // console.log(result);
    $scope.options_ascensores = result.data;﻿
  }, function(result) {
    //some error
    console.log(result);
  });

  //CARGAR OPCIONES DE LAS NOTIFICACIONES DE PUERTAS
  $http.get("./admin_notificaciones_puertas.php")
	.then(function(result) {
    console.log(result);
    $scope.options_puertas = result.data;﻿
  }, function(result) {
    //some error
    console.log(result);
  });

  //CARGAR OPCIONES DE LAS NOTIFICACIONES DE escaleras
  $http.get("./admin_notificaciones_escaleras.php")
	.then(function(result) {
    //console.log(result);
    $scope.options_escaleras = result.data;﻿
  }, function(result) {
    //some error
    console.log(result);
  });

  $scope.navigateTo = function(to, event, option) {
  	console.log(option);
    $scope.activeOption = option; //DEJAR SOMBREADA LA VISTA
    if (option.id == "ascensor_cantidad_items_nocumple" && option.cantidad != 0) {
    	window.location = "./admin_notificaciones_ascensor_items_nocumple.php";
    }else if(option.id == "puertas_cantidad_items_nocumple" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_puertas_items_nocumple.php";
    }else if(option.id == "escaleras_cantidad_items_nocumple" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_escaleras_items_nocumple.php";

    }else if(option.id == "ascensor_cantidad_items_nocumple_vencidos" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_ascensor_items_nocumple_vencidos.php";
    }else if(option.id == "puertas_cantidad_items_nocumple_vencidos" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_puertas_items_nocumple_vencidos.php";
    }else if(option.id == "escaleras_cantidad_items_nocumple_vencidos" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_escaleras_items_nocumple_vencidos.php";

    }else if(option.id == "ascensor_cantidad_certificados_x_vencer" && option.cantidad != 0){
      window.location = "./admin_notificaciones_ascensor_cerificados_a_vencer.php";
    }else if(option.id == "puertas_cantidad_certificados_x_vencer" && option.cantidad != 0){
      window.location = "./admin_notificaciones_puertas_cerificados_a_vencer.php";
    }else if(option.id == "escaleras_cantidad_certificados_x_vencer" && option.cantidad != 0){
      window.location = "./admin_notificaciones_escaleras_cerificados_a_vencer.php";

    }else if(option.id == "ascensor_cantidad_certificados_vencidos" && option.cantidad != 0){
      window.location = "./admin_notificaciones_ascensor_cerificados_vencidos.php";
    }else if(option.id == "puertas_cantidad_certificados_vencidos" && option.cantidad != 0){
      window.location = "./admin_notificaciones_puertas_cerificados_vencidos.php";
    }else if(option.id == "escaleras_cantidad_certificados_vencidos" && option.cantidad != 0){
      window.location = "./admin_notificaciones_escaleras_cerificados_vencidos.php";
    }

    else{
    	$mdDialog.show(
	      $mdDialog.alert()
	        .title(to)
	        .textContent('Enhorabuena, no hay inspecciones que cumplan esta condición!')
	        .ariaLabel('Navigation demo')
	        .ok('Aceptar')
	        .targetEvent(event)
	    );
    }
  };
})