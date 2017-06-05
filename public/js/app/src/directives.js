define(['app'], function(app) {
'use strict'; 
 //
 // Global directive
 var gDirective = function ($compile, directiveName){
    var link = function(scope, element, attrs) {
        scope.$watch(attrs[directiveName],
            function(value) {
                 element.html(value);
                $compile(element.contents())(scope);
            }
        );
    };
    return {
        link: link
    };
 };
//
// Menu Directive    
var menuDirective = function($compile){
    return gDirective($compile, "menuDirective");
};
menuDirective.$inject = ['$compile'];
app.directive('menuDirective', menuDirective);
//
// Main Page Directive    
var mainPageDirective = function($compile){
    return gDirective($compile, "mainPageDirective");
};
mainPageDirective.$inject = ['$compile'];
app.directive('mainPageDirective', mainPageDirective);

});