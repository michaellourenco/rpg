//'use strict';


angular


    .module('app.card', ['angularFileUpload'])


    .controller('CardCtrl', ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location','$log','$templateCache','combatesAPI','dadoAPI','cardAPI', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location,$log,$templateCache,combatesAPI,dadoAPI,cardAPI) {
      $templateCache.removeAll();
     
      namespace = $stateParams.namespace;
      if($stateParams.id != null){
        id = $stateParams.id;
        console.info('id do card', $stateParams.id)
      }
      carregarCombate = function (namespace){
        combatesAPI.getCombates().success(function (data) {
          $scope.combate = data; 
  
          $scope.card = data.cards[$stateParams.id];    
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      };



      carregarCombate(namespace);

      $scope.editarCard = function (card){
        console.log($scope.combate.cards[$stateParams.id] != null);
        console.log($stateParams.id);
        $scope.combate != $scope.combate.cards.splice($stateParams.id,1,card);      
        $http.post("editarcombate.php", $scope.combate).success(function (data) {
          /*delete $scope.combate;*/
          console.log("/app/combate/"+namespace);
          $location.path("/app/combate/"+namespace);
        });
      };
  
      var uploader = $scope.uploader = new FileUploader({
          url: 'upload.php'
          //formData:$scope.cardapio
      });

      // FILTERS
        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS
        uploader.onAfterAddingFile = function(item) {
          var fileExtension = '.' + item.file.name.split('.').pop();

          item.file.name = Math.random().toString(36).substring(7) + new Date().getTime() + fileExtension;
        };
        uploader.onBeforeUploadItem = function(item) {
          cardapiosAPI.getCardapios().success(function (data) {
             item.formData.push(data);
          }).error(function (data, status) {
            $scope.message = "Aconteceu um problema: " + data;
          });
        };

        uploader.onCompleteItem = function(fileItem, response, status, headers) {
          cardapiosAPI.getCardapios().success(function (data) {

          }).error(function (data, status) {
            $scope.message = "Aconteceu um problema: " + data;
          });
          
          fileItem.formData[0].logo = fileItem.file.name;

          informacao = fileItem.formData[0];
          cardapiosAPI.saveCardapio(informacao).success(function (data) {
            /*delete $scope.cardapio;
            $scope.categoriaForm.$setPristine();*/
             $location.path("/app/cardapio/"+namespace);
          });
        };

        uploader.onCompleteAll = function() {
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