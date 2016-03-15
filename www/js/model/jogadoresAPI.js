angular
.module('app.jogador').factory("jogadoresAPI", function($http){
	var _getJogadors = function(){
		return $http.get("jogadores/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } });
	};
	var _saveJogador = function(jogador){
		return $http.post("editarjogador.php", jogador);
	}
	var _luta = function(p1,p2){

	}
	return {
		getJogadores : _getJogadores,
		saveJogador : _saveJogador
	};
});