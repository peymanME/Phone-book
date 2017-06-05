define(['angular'], function (angular) {
  'use strict';
  var app = angular.module('DocSoft',[]);

  app.init = function () {
    angular.bootstrap(document, ['DocSoft']);
  };
  return app;
});


