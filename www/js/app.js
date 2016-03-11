// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('app', ['ionic', 
  'app.controllers',
  'app.novochar',
  'app.skill',
  'app.novaskillnpc',
  'app.novonpc',
  'app.editarchar',
  'app.editarskillnpc',
  'app.editarnpc',
  'app.luta',
  'app.combate',
  'app.combates',
  'app.char',
  'app.game',  
  'app.npc', 
  'app.npcs', 
  'app.quest'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {

    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider

  .state('app', {
    cache: false,
    url: "/app",
    abstract: true,
    templateUrl: "templates/menu.html",
    controller: 'AppCtrl'
  })


  .state('app.search', {
    cache: false,
    url: "/search",
    views: {
      'menuContent': {
        templateUrl: "templates/search.html"
      }
    }
  })

  .state('app.browse', {
    cache: false,
    url: "/browse",
    views: {
      'menuContent': {
        templateUrl: "templates/browse.html",
        controller: 'BrowseCtrl'
      }
    }
  })
   .state('app.game', {
    cache: false,
    url: "/game",
    views: {
      'menuContent': {
        templateUrl: "templates/game.html",
        controller: 'GameCtrl'
      }
    }
  })
   .state('app.luta', {
    cache: false,
    url: "/luta/:namespace/:id/:idinimigo",
    views: {
      'menuContent': {
        templateUrl: "templates/luta.html",
        controller: 'LutaCtrl'
      }
    }
  }) 
    .state('app.combates', {
      cache: false,
      url: "/combates",
      views: {
        'menuContent': {
          templateUrl: "templates/combates.html",
          controller: 'CombatesCtrl'
        }
      }
    })

    .state('app.novocombate', {
      cache: false,
      url: "/novocombate",
      views: {
        'menuContent': {
          templateUrl: "templates/novoCombate.html",
          controller: 'NovoCombateCtrl'
        }
      }
    })

  .state('app.combate', {
    cache: false,
    url: "/combate/:namespace",
    views: {
      'menuContent': {
        templateUrl: "templates/combate.html",
        controller: 'CombateCtrl'
      }
    }
  })
  .state('app.editarcombate', {
    cache: false,
    url: "/editarcombate/:namespace",
    views: {
      'menuContent': {
        templateUrl: "templates/editarCombate.html",
        controller: 'CombateCtrl'
      }
    }
  })
    .state('app.chars', {
      cache: false,
      url: "/chars",
      views: {
        'menuContent': {
          templateUrl: "templates/chars.html",
          controller: 'CharsCtrl'
        }
      }
    })

    .state('app.novochar', {
      cache: false,
      url: "/novochar/:namespace",
      views: {
        'menuContent': {
          templateUrl: "templates/novoChar.html",
          controller: 'NovoCharCtrl'
        }
      }
    })

  .state('app.char', {
    cache: false,
    url: "/char/:namespace",
    views: {
      'menuContent': {
        templateUrl: "templates/char.html",
        controller: 'CharCtrl'
      }
    }
  })
  .state('app.editarchar', {
    cache: false,
    url: "/editarchar/:namespace/:id",
    views: {
      'menuContent': {
        templateUrl: "templates/editarChar.html",
        controller: 'EditarCharCtrl'
      }
    }
  })

  .state('app.novaskill', {
    cache: false,
      url: "/novaskill/:namespace/:id",
      views: {
        'menuContent': {
          templateUrl: "templates/novaSkill.html",
          controller: 'SkillCtrl'
        }
      }
    })
  .state('app.editarskill', {
    cache: false,
      url: "/editarskill/:namespace/:id/:idskill",
      views: {
        'menuContent': {
          templateUrl: "templates/editarSkill.html",
          controller: 'SkillCtrl'
        }
      }
    })
    .state('app.npcs', {
      cache: false,
      url: "/npcs/:namespace",
      views: {
        'menuContent': {
          templateUrl: "templates/npcs.html",
          controller: 'NpcsCtrl'
        }
      }
    })

    .state('app.novonpc', {
      cache: false,
      url: "/novonpc/:namespace",
      views: {
        'menuContent': {
          templateUrl: "templates/novoNpc.html",
          controller: 'NovoNpcCtrl'
        }
      }
    })

  .state('app.npc', {
    cache: false,
    url: "/npc/:namespace",
    views: {
      'menuContent': {
        templateUrl: "templates/npc.html",
        controller: 'NpcCtrl'
      }
    }
  })
  .state('app.editarnpc', {
    cache: false,
    url: "/editarnpc/:namespace/:id",
    views: {
      'menuContent': {
        templateUrl: "templates/editarNpc.html",
        controller: 'EditarNpcCtrl'
      }
    }
  })

  .state('app.novaskillnpc', {
    cache: false,
      url: "/novaskillnpc/:namespace/:id",
      views: {
        'menuContent': {
          templateUrl: "templates/novaSkillNpc.html",
          controller: 'NovaSkillNpcCtrl'
        }
      }
    })
  .state('app.editarskillnpc', {
    cache: false,
      url: "/editarskillnpc/:namespace/:id/:idskillnpc",
      views: {
        'menuContent': {
          templateUrl: "templates/editarSkillNpc.html",
          controller: 'EditarSkillNpcCtrl'
        }
      }
    })
    .state('app.quests', {
      cache: false,
      url: "/quests",
      views: {
        'menuContent': {
          templateUrl: "templates/quests.html",
          controller: 'QuestCtrl'
        }
      }
    })

    .state('app.novaquest', {
      cache: false,
      url: "/novaquest/:namespace",
      views: {
        'menuContent': {
          templateUrl: "templates/novaQuest.html",
          controller: 'QuestCtrl'
        }
      }
    })

  .state('app.quest', {
    cache: false,
    url: "/quest/:namespace",
    views: {
      'menuContent': {
        templateUrl: "templates/quest.html",
        controller: 'QuestCtrl'
      }
    }
  })
  .state('app.editarquest', {
    cache: false,
    url: "/editarquest/:namespace/:id",
    views: {
      'menuContent': {
        templateUrl: "templates/editarQuest.html",
        controller: 'QuestCtrl'
      }
    }
  });
  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/combates');
});
