define(['app'], function(app) {
'use strict';
//
//Main Controller
function MainController($scope, ajaxPageService){
}
MainController.$inject = ['$scope', 'ajaxPageService'];
app.controller('MainController', MainController);    
//
//Menu Controller
function MenuController($rootScope, $scope, ajaxPageService){
    $scope.getForm = function (url){
        get(url, ajaxPageService, $rootScope);
    };
    $scope.getMenu = function (url){
        get (url, ajaxPageService, $scope, true);
    };
    $rootScope.$on('refreshMenu', function (event, url){
        $scope.getMenu (url.url);
    });
};
MenuController.$inject = ['$rootScope', '$scope', 'ajaxPageService'];
app.controller('MenuController', MenuController);    
//
//Register Controller
function RegisterController($rootScope, $scope, ajaxPageService){
    $scope.User = {};
    $scope.submit = function (url){
        post(url, ajaxPageService,$scope.User, $rootScope);
    };  
}
RegisterController.$inject = ['$rootScope', '$scope','ajaxPageService'];
app.controller('RegisterController', RegisterController);
//
//... Register Controller
function LoginController($rootScope, $scope, ajaxPageService){
    $scope.getMenu = function(url) {
        $rootScope.$emit("refreshMenu", {url});
    };
    $scope.User = {};
    $scope.submit = function (url){
        post(url, ajaxPageService,$scope.User, $rootScope);
    };
    $scope.redirect = function (url){
         get(url, ajaxPageService, $rootScope);
    };
}
LoginController.$inject = ['$rootScope', '$scope','ajaxPageService'];
app.controller('LoginController', LoginController);    
//
//... ListPhoneBook Controller
function ListPhoneBookController($rootScope, $scope, $parse, ajaxPageService, pagerService){
    $scope.getMenu = function(url) {
        $rootScope.$emit("refreshMenu", {url});
    };
    
    $scope.getData = function (url){
        getJson(url, ajaxPageService, $rootScope, $scope, "users");
     };
     
    $scope.manage = function (url){
        get(url, ajaxPageService, $rootScope);
    };
    $scope.delete = function (url){
        if (confirm("Are you sure? ")) {
            $scope.getData(url);
        } 
        
    };
    $scope.propertyName = 'FirstName';
    $scope.reverse = true;

    $scope.sortBy = function(propertyName) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };
    //
    // pagination 
    $scope.vm = {};
    var vm = $scope.vm;
    $scope.$watch('users',function (){
        if (typeof $scope.users ==='object'){
            vm.dummyItems = $scope.users;        
            vm.pager = {};
            vm.setPage = setPage;
            initController();
        }
    });
    function initController() {
        // initialize to page 1
        vm.setPage(1);
    }

    function setPage(page) {
        if (page < 1 || page > vm.pager.totalPages) {
            return;
        }

        // get pager object from service
        vm.pager = pagerService.GetPager(vm.dummyItems.length, page);

        // get current page of items
        vm.items = vm.dummyItems.slice(vm.pager.startIndex, vm.pager.endIndex + 1);
    }
}
ListPhoneBookController.$inject = ['$rootScope', '$scope', '$parse','ajaxPageService', 'pagerService'];
app.controller('ListPhoneBookController', ListPhoneBookController);    

//
//... ManagePhoneBook Controller
function ManagePhoneBookController($rootScope, $scope, ajaxPageService){
    $scope.PhoneBook = {};
    $scope.submit = function (url){
        post(url, ajaxPageService, $scope.PhoneBook, $rootScope);
    };
    
}
ManagePhoneBookController.$inject = ['$rootScope', '$scope','ajaxPageService'];
app.controller('ManagePhoneBookController', ManagePhoneBookController);    

//
//... functions
var get = function (url, ajaxPageService, scope, is_menu=false){
    var conf = {
        url: url,
        scope: scope,
        is_menu : is_menu
    };
    ajaxPageService.getPage(conf);
};

var getJson = function (url, ajaxPageService, rootScope, scope, param){
    var conf = {
        url: url,           
        scope: scope,
        rootScope: rootScope,
        param: param       
    };
    ajaxPageService.jsonData(conf);
};

var post = function (url, ajaxPageService, data, scope){   
    var conf = {
        url: url,
        data: data,
        scope: scope
    };
    ajaxPageService.postPage(conf);
};
});
