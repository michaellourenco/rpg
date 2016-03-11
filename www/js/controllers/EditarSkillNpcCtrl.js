//'use strict';


angular


    .module('app.editarskillnpc', ['angularFileUpload'])


    .controller('EditarSkillNpcCtrl', ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location) {
 
      namespace = $stateParams.namespace;
      id = $stateParams.id;
      idskillnpc = $stateParams.idskillnpc;

    carregarCombate = function (namespace){
      $http.get("combates/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } }).success(function (data) {
        $scope.combate = data;     
        $scope.skillnpc = data.npcs[$stateParams.id].skillnpcs[$stateParams.idskillnpc];  
      }).error(function (data, status) {
        $scope.message = "Aconteceu um problema: " + data;
      });

    };

    carregarCombate(namespace); 

     $scope.editarSkillNpc = function (skillnpc){
        $scope.combate != $scope.combate.npcs[$stateParams.id].skillnpcs.splice($stateParams.idskillnpc,1,skillnpc);      
        $http.post("editarcombate.php", $scope.combate).success(function (data) {
          /*delete $scope.combate;*/
          $location.path("/app/npcs/"+namespace);
        });
      };

      $scope.editarNpc = function (combate){
        $http.post("editarcombate.php", combate).success(function (data) {
          delete $scope.combates;
          $scope.combateEdit.$setPristine();
          $location.path("#/app/combates");
        });
      };

      $scope.adicionarCombate = function (combate) {

        $http.post("novocombate.php", combate).success(function (data) {
          console.log("depois:"+combate);
         /* delete $scope.combates;
          $scope.combateForm.$setPristine();*/
          $location.path("#/app/combates");
        });
      };

          var uploader = $scope.uploader = new FileUploader({
          url: 'upload.php'
      });
      
      // FILTERS
      uploader.filters.push({
          name: 'customFilter',
          fn: function(item /*{File|FileLikeObject}*/, options) {
              return this.queue.length < 10;
          }
      });

      // CALLBACKS
      uploader.onBeforeUploadItem = function(item) {
        $http.get("combates/"+namespace+".phtml").success(function (data) {
          mudado = {logo:"2.jpg"};      
          item.formData.push(mudado);
          item.formData.push(data);
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      };

      uploader.onCompleteItem = function(fileItem, response, status, headers) {
        $http.get("cardapios/"+namespace+".phtml").success(function (data) {  

        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });      
        fileItem.formData[1].npcs[$stateParams.id].skillnpcs[$stateParams.idskillnpc].imagem = fileItem.file.name;
        informacao = fileItem.formData[1];
        $http.post("editarcombate.php", informacao).success(function (data) {
          /*delete $scope.cardapio;
          $scope.categoriaForm.$setPristine();*/
           $location.path("/app/npcs/"+namespace);
        });
      };

      uploader.onCompleteAll = function() {
          console.info('onCompleteAll');
      };

      console.info('uploader', uploader);

        // -------------------------------

        var controller = $scope.controller = {
            isImage: function(item) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };
    }]);