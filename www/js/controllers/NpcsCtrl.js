//'use strict';


angular


    .module('app.npcs', ['angularFileUpload'])


    .controller('NpcsCtrl', ['$scope', 'FileUploader','$http','$ionicModal', '$timeout', '$stateParams','$location','$log','$templateCache','combatesAPI','dadoAPI','charAPI', function($scope, FileUploader,$http, $ionicModal, $timeout, $stateParams,$location,$log,$templateCache,combatesAPI,dadoAPI,charAPI) {
     $templateCache.removeAll();
     
      namespace = $stateParams.namespace;
      
     carregarCombate = function (namespace){
        combatesAPI.getCombates().success(function (data) {
          $scope.combate = data; 
          var chars = $scope.combate.chars; 
          per1 = chars[0];    
          per2 = chars[2];   
          console.log(per2);
  iniciativa =function(p1,p2){
      var p1ini = Math.floor(Math.random(p1.iniciativa)*20);
      var p2ini = Math.floor(Math.random(p2.iniciativa)*20);
    if(p1ini  > p2ini){
      $scope.message ="Iniciativa vencida por <strong>" + p1.titulo +"</strong> que tem "+p1ini+" enquanto "+p2.titulo+" tem "+p2ini;
      console.info('msg1', $scope.message);
      return turno(0,p1,p2);
    }else{
      $scope.message="Iniciativa vencida por <strong>"+ p2.titulo +"</strong> que tem "+p2ini+" enquanto "+p1.titulo+" tem "+p1ini;
            console.info('msg2', $scope.message);
      return turno(0,p2,p1);       
    }           

  } 

  turno =function(i,p1,p2){
  pv=p2.hp;
  pa=p2.hp; 
      var p1fa = Math.floor(Math.random(p1.fa)*20);
      var p2fd = Math.floor(Math.random(p2.fd)*20);
    if(p1fa>p2fd){  
      dano=p1fa;
      def=p2fd;
      danoTotal=dano-def;
      if(danoTotal > 0){
        danoI = danoTotal;
        pv -=danoI;
      }
      else{
        danoI=1;
        pv -=danoI;
      }
      if(pv <= 0){
          p2.hp = pv;
        
        $scope.message += "<p><img src='uploads/"+p1.imagem+"' width=150 height=150 />TURNO "+ i++ +" | ";
        console.info('msg3', $scope.message);
        $scope.message += "ATK "+dano;
        console.info('msg4', $scope.message);
        $scope.message += " | DEF "+def;
        console.info('msg5', $scope.message);
        $scope.message += " =  "+danoTotal+" de dano<br/>";       
        console.info('msg6', $scope.message);
        $scope.message += "<strong>"+p1.titulo+"</strong> atacou e inflingiu <strong>"+danoI+"</strong> de dano em <strong>"+ p2.titulo +"</strong> que tinha <strong>"+ pa +"</strong><br/>";
        console.info('msg7', $scope.message);
        $scope.message += "<strong>"+ p2.titulo+"</strong> perdeu pois ficou com <strong>"+ p2.hp +"</strong> pontos de vida <br/>";  
        console.info('msg8', $scope.message);
        $scope.message += "PARABENS <strong>"+ p1.titulo +"</strong> VOCE VENCEU!</p>";
        console.info('msg4', $scope.message);
      }else if(pv > 0){
       p2.hp = pv;
        $scope.message += "<p><img src='uploads/"+p1.imagem+"' width=80 height=80 />TURNO "+ i++ +" | ";
        $scope.message += "ATK "+ dano;
        $scope.message += " | DEF "+ def;
        $scope.message += " =  "+ danoTotal +" de dano<br/>";       

        $scope.message += "<strong>"+ p1.titulo +"</strong> atacou e inflingiu <strong>"+ danoI +"</strong> de dano em <strong>"+ p2.titulo +"</strong> que tinha <strong>"+ pa +"</strong><br/>";
        $scope.message += "Agora <strong>"+p2.titulo+"</strong> tem <strong>"+p2.hp+"</strong> pontos de vida restantes</p><br/>";
        return turno(i,p2,p1);
      }

    }
    else{
      $scope.message += "<p><img src='uploads/"+p1.imagem+"' width=80 height=80 />TURNO "+ i++ +" | ";
      $scope.message += "<strong>"+ p1.titulo +"</strong> errou o ataque</p>";
      return turno(i,p2,p1);
      
    }
    
  } 
  iniciativa(per2,per1);
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
        dado = dadoAPI.getDado(20);
        console.log(dado);
      };


      carregarCombate(namespace);




      $scope.editarCombate = function (combate,skill){
        if(skill!= null){

            }else{
            combatesAPI.saveCombate(combate).success(function (data) {
              $location.path("/app/combate/"+namespace);
            });
        }
      };

      $scope.adicionarSkill = function (combate){
        combatesAPI.saveCombate($scope.combate).success(function (data) {
          delete $scope.combates;
          $scope.combateEdit.$setPristine();
          $location.path("#/app/combate/"+namespace);
        });
      };

      $scope.apagarSkill = function (indiceSkill,indiceChar){
        $scope.combate != $scope.combate.chars[indiceChar].itens.splice(indiceSkill,1);      
        combatesAPI.saveCombate($scope.combate).success(function (data) {
          /*delete $scope.combate;*/
          $location.path("/app/combate/"+namespace);
        });
      };

      $scope.apagarChar = function (indiceChar){
        $scope.combate != $scope.combate.chars.splice(indiceChar,1);      
        combatesAPI.saveCombate($scope.combate).success(function (data) {
          /*delete $scope.combate;*/
          $location.path("/app/combate/"+namespace);
        });
      };
 
  
   
      



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
        $http.get("cardapios/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } }).success(function (data) {
          mudado = {logo:"2.jpg"};      
          item.formData.push(mudado);
          item.formData.push(data);
        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });
      };

      uploader.onCompleteItem = function(fileItem, response, status, headers) {
        $http.get("cardapios/"+namespace+".phtml", { headers: { 'Cache-Control' : 'no-cache' } }).success(function (data) {  

        }).error(function (data, status) {
          $scope.message = "Aconteceu um problema: " + data;
        });      
        console.info('response'+response);
        fileItem.formData[1].categorias[$stateParams.id].itens[$stateParams.iditem].imagem = fileItem.file.name;
        informacao = fileItem.formData[1];
        $http.post("editarcardapio.php", informacao).success(function (data) {
          /*delete $scope.cardapio;
          $scope.categoriaForm.$setPristine();*/
           $location.path("/app/cardapio/"+namespace);
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