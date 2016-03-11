angular
.module('app.combate').factory("combatesAPI", function($http){
	var _getCombates = function(){
		return $http.get("combates/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } });
	};
	var _saveCombate = function(combate){
		return $http.post("editarcombate.php", combate);
	}
	var _luta = function(p1,p2){

	}
	return {
		getCombates : _getCombates,
		saveCombate : _saveCombate
	};
});