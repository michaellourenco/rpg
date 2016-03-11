//'use strict';


angular


    .module('app.npc', ['angularFileUpload'])


    .controller('NpcCtrl', ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location','$log','$templateCache','combatesAPI','dadoAPI','npcAPI', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location,$log,$templateCache,combatesAPI,dadoAPI,npcAPI) {
     $templateCache.removeAll();
     
      namespace = $stateParams.namespace;
      
     carregarCombate = function (namespace){
        combatesAPI.getCombates().success(function (data) {
          $scope.combate = data; 
          var npcs = $scope.combate.npcs;     
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      dado = dadoAPI.getDado(20);
      console.log(dado);
      };
     carregarNpc = function (namespace){
        npcAPI.getNpc().success(function (data) {
          $scope.personagem = data; 
          var npcs2 = $scope.personagem.npcs;     
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });

      };
      carregarNpc(namespace);
      carregarCombate(namespace);

        var carregarCombates = function () {
            $http.get("templates/home.phtml", { headers: { 'Cache-Control' : 'no-cache' } }).success(function (data) {
            $scope.combates = data;
            }).error(function (data, status) {
            $scope.message = "Aconteceu um problema: " + data;
            });
        };
        carregarCombates();
     /* $scope.combater= function (){
        var p = new Personagem();
        var pMapper = new PersonagemMapper();
        pMapper.find(1,p);
    
        var px = new Personagem();
        var pxMapper = new PersonagemMapper();
        pxMapper.find(2,px);   
        
        var combate = new Combate();
 
        combate->iniciativa(p,px);
      };*/  
      
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