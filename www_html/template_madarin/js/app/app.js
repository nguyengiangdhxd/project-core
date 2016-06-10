var mardarinApp = angular.module('mardarinApp', [
    'ngRoute'
]);
mardarinApp.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
            when('/home',{
            title :'madarin',
            templateUrl : '',
            controller :''
        }).
            when('/chi-tiet',{
            title :'madarin',
            templateUrl:'',
            controller :''
        })
    }
]);
