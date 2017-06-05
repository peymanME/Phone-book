'use strict';
requirejs.config({
    baseUrl: "js/app",    
    paths: {
        'angular': '../angular.min',
        'bootstrap':'../bootstrap.min',
        'jquery': '../jquery-3.1.0.min'
    },
    shim: {
      angular: {
          exports : 'angular'
      },
      bootstrap: {
           deps: ['jquery']
      },
      jquery: {exports: '$'}
    }
});

require(['app','./src/services','./src/controllers','./src/directives'], function (app) {
    app.init();
});
require(["jquery", "bootstrap"], function ($) {
});
