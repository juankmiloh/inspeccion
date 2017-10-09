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
  $http.get("./admin_notificaciones_ascensores.php")
	.then(function(result) {
    //console.log(result);
    $scope.options_ascensores = result.data;﻿
  }, function(result) {
    //some error
    console.log(result);
  });

  //CARGAR OPCIONES DE LAS NOTIFICACIONES DE PUERTAS
  $http.get("./admin_notificaciones_puertas.php")
	.then(function(result) {
    //console.log(result);
    $scope.options_puertas = result.data;﻿
  }, function(result) {
    //some error
    console.log(result);
  });

  //CARGAR OPCIONES DE LAS NOTIFICACIONES DE ESCALERAS
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
    if (option.id == "ascensor_cantidad_inspecciones_graves" && option.cantidad != 0) {
    	window.location = "./admin_notificaciones_asc_items_graves.php";
    }else if(option.id == "puertas_cantidad_inspecciones_graves" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_put_items_graves.php";
    }else if(option.id == "escaleras_cantidad_inspecciones_graves" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_esc_items_graves.php";

    }else if(option.id == "ascensor_cantidad_inspecciones_leves" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_asc_items_leves.php";
    }else if(option.id == "puertas_cantidad_inspecciones_leves" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_put_items_leves.php";
    }else if(option.id == "escaleras_cantidad_inspecciones_leves" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_esc_items_leves.php";

    }else if(option.id == "ascensor_cantidad_inspecciones_vencidas" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_asc_items_vencidos.php";
    }else if(option.id == "puertas_cantidad_inspecciones_vencidas" && option.cantidad != 0){
    	window.location = "./admin_notificaciones_put_items_vencidos.php";
    }else if(option.id == "escaleras_cantidad_inspecciones_vencidas" && option.cantidad != 0){
    	window.location = "./escaleras_notificaciones_esc_items_vencidos.php";
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