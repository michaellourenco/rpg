//'use strict';


angular


  .module('app.novaskillnpc', ['angularFileUpload'])

  .controller('NovaSkillNpcCtrl',  ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location) {
   

  console.log($stateParams.namespace);
console.log($stateParams.id);

  namespace = $stateParams.namespace;
  id = $stateParams.id;

      carregarCombate = function (namespace){
        $http.get("combates/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } }).success(function (data) {
          console.log(data);
          $scope.combate = data; 
                    $scope.npc = data.npcs[$stateParams.id];    
                console.log($scope.npc.titulo);
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });

      };

      carregarCombate(namespace);


      $scope.adicionarSkillNpc = function (skillnpc){
        console.log($scope.combate.npcs[$stateParams.id].skillnpcs != null);
        console.log($stateParams.id);
        if($scope.combate.npcs[$stateParams.id].skillnpcs != null){
          $scope.combate.npcs[$stateParams.id].skillnpcs.push(skillnpc);
        }else{
          $scope.combate.npcs[$stateParams.id].skillnpcs = [];
          $scope.combate.npcs[$stateParams.id].skillnpcs.push(skillnpc);
        };
        $http.post("editarcombate.php", $scope.combate).success(function (data) {
          /*delete $scope.combate;*/
          /*$scope.npcForm.$setPristine();*/
          $location.path("/app/npcs/"+namespace);
          console.log($location.path());
        });


      };


      $scope.novoNpc = function (npc){
        $scope.combate.npcs.push(npc);
        $http.post("editarcombate.php", $scope.combate).success(function (data) {
          /*delete $scope.combate;
          $scope.npcForm.$setPristine();*/
                    $location.path("#/app/combates");
        });
      };

      carregarCombate(namespace);
      $scope.adicionarCombate = function (combate) {
        console.log("antes:"+combate);

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
            fn: function(skillnpc /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(skillnpc /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', skillnpc, filter, options);
        };
        uploader.onAfterAddingFile = function(fileSkillNpc) {
            console.info('onAfterAddingFile', fileSkillNpc);
        };
        uploader.onAfterAddingAll = function(addedFileSkillNpcs) {
            console.info('onAfterAddingAll', addedFileSkillNpcs);
        };
        uploader.onBeforeUploadSkillNpc = function(skillnpc) {
            console.info('onBeforeUploadSkillNpc', skillnpc);
        };
        uploader.onProgressSkillNpc = function(fileSkillNpc, progress) {
            console.info('onProgressSkillNpc', fileSkillNpc, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessSkillNpc = function(fileSkillNpc, response, status, headers) {
            console.info('onSuccessSkillNpc', fileSkillNpc, response, status, headers);
        };
        uploader.onErrorSkillNpc = function(fileSkillNpc, response, status, headers) {
            console.info('onErrorSkillNpc', fileSkillNpc, response, status, headers);
        };
        uploader.onCancelSkillNpc = function(fileSkillNpc, response, status, headers) {
            console.info('onCancelSkillNpc', fileSkillNpc, response, status, headers);
        };
        uploader.onCompleteSkillNpc = function(fileSkillNpc, response, status, headers) {
            console.info('onCompleteSkillNpc', fileSkillNpc, response, status, headers);
            console.info('onCompleteITem',fileSkillNpc.file.name);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);


        // -------------------------------


        var controller = $scope.controller = {
            isImage: function(skillnpc) {
                var type = '|' + skillnpc.type.slice(skillnpc.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };
    }]);