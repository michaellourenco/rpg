//'use strict';


angular
.module('app.char').factory("charAPI", function($http){
    var _getChar = function(){
        return $http.get("chars/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } });
    };
    var _saveChar = function(char){
        return $http.post("editarchar.php", char);
    }
    return {
        getChar : _getChar,
        saveChar : _saveChar
    };
});