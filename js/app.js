var myApp = angular.module("myApp", ["ngRoute"])

myApp.config(function($routeProvider) {
    $routeProvider.when(
        "/home", {
            //controller: "homeController",
            templateUrl: "views/home.html"
        }
    ).when(
        "/amp", {
            controller: "amplistController",
            templateUrl: "views/amplist/amplist.html"
        }
    ).when(
        "/report1", {
            //controller: "olderController",
            templateUrl: "views/report1.html"
        }
    ).when(
        "/pop_older1", {
            //controller: "olderController",
            templateUrl: "views/data_pop_older.html"
        }        
    ).when(
        "/about", {
            controller: "aboutController",
            templateUrl: "views/about.html"
        }
    ).otherwise({
        redirectTo: '/home'
    });
})


myApp.controller("customerController", function($scope) {
    $scope.controllerName = "Hello Customer";
})
myApp.controller("aboutController", function($scope) {
    $scope.controllerName = "Hello About";
})
/*myApp.controller("homeController", function($scope) {
    $scope.controllerName = "Hello Home";
})
*/