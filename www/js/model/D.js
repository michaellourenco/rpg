//'use strict';


angular
.module('app').factory("dadoAPI", function($http){
    var lado;


    var _setLado = function(lado) {
        this.lado = lado;
        return this;
    }


    var _getDado = function(lado){
        return this.lado = Math.floor((Math.random()*lado)+1);
    }

  return {
    setLado : _setLado, 
    getDado : _getDado
  };
});



