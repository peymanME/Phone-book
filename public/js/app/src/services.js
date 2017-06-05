define(['app'], function(app) {
 'use strict';   
 var ajaxPageService = function ($http){
    var contentId = {
        Main : "MainPageContent",
        Menu : "MenuContent"
    }; 
     
    var successCallback = function (response, conf){
        if (conf.is_menu){
            conf.scope[contentId.Menu] = response.data;
        }else {
            conf.scope[contentId.Main] = response.data;
        }
    };
    var errorCallback = function (response, conf){
        conf.scope[contentId.Main] = response.data;
    };
   
    return { 
        getPage : function(conf){
            $http.get(conf.url).then(
                function(response){
                    successCallback(response, conf);
                },
                function (response){
                    errorCallback(response, conf);
                });
        },
        postPage : function(conf){
            return $http.post(conf.url, conf.data ).then(
                function(response){
                    successCallback(response, conf);
                },
                function (response){
                    errorCallback(response, conf);
                }); 
        },
        jsonData : function (conf){
           $http.get(conf.url).then(
                function(response){
                    if (typeof response.data === 'object'){
                        conf.scope[conf.param] = Object.keys(response.data).map(function(key) {
                            return response.data[key];
                        });
                    }
                    else {successCallback(response, conf.rootScope) }
                },
                function (response){
                    errorCallback(response, conf.scope);
                }); 
        }
    };      
 };  
ajaxPageService.$inject = ['$http'];
app.service('ajaxPageService', ajaxPageService);

var pagerService = function() {
        // service definition
        var service = {};

        service.GetPager = GetPager;

        return service;

        // service implementation
        function GetPager(totalItems, currentPage, pageSize) {

            // default to first page
            currentPage = currentPage || 1;
 
            // default page size is 10
            pageSize = pageSize || 10;

            // calculate total pages
            var totalPages = Math.ceil(totalItems / pageSize);

            var startPage, endPage;
            if (totalPages <= 10) {
                // less than 10 total pages so show all
                startPage = 1;
                endPage = totalPages;
            } else {
                // more than 10 total pages so calculate start and end pages
                if (currentPage <= 6) {
                    startPage = 1;
                    endPage = 10;
                } else if (currentPage + 4 >= totalPages) {
                    startPage = totalPages - 9;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - 5;
                    endPage = currentPage + 4;
                }
            }

            // calculate start and end item indexes
            var startIndex = (currentPage - 1) * pageSize;
            var endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);

            // create an array of pages to ng-repeat in the pager control
            var pages = range(startPage, endPage);
            function range(start, count) {
                return Array.apply(0, Array(count))
                .map(function (element, index) { 
                    return index + start;  
                });
            }

            // return object with all pager properties required by the view
            return {
                totalItems: totalItems,
                currentPage: currentPage,
                pageSize: pageSize,
                totalPages: totalPages,
                startPage: startPage,
                endPage: endPage,
                startIndex: startIndex,
                endIndex: endIndex,
                pages: pages
            };
        }
    };
app.factory('pagerService', pagerService);
});
