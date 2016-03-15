//'use strict';


angular
.module('app.card').factory("cardAPI", function($http){
    var _getCard = function(){
        return $http.get("combates/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } });
    };
    var _saveCard = function(card){
        return $http.post("editarcombate.php", card);
    }
    return {
        getCard : _getCard,
        saveCard : _saveCard
    };
});