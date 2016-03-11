//'use strict';


angular


    .module('app.char', ['angularFileUpload'])


    .controller('CharCtrl', ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location','$log','$templateCache','combatesAPI','dadoAPI','charAPI', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location,$log,$templateCache,combatesAPI,dadoAPI,charAPI) {
      $templateCache.removeAll();
     
      namespace = $stateParams.namespace;
      
      carregarCombate = function (namespace){
        combatesAPI.getCombates().success(function (data) {
          $scope.combate = data; 
          var chars = $scope.combate.chars;     
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      };

      carregarChar = function (namespace){
        charAPI.getChar().success(function (data) {
          $scope.personagem = data; 
          var chars2 = $scope.personagem.chars;     
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      };

      carregarChar(namespace);
      carregarCombate(namespace);

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