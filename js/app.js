var myApp = angular.module("myApp", ["ngRoute","highcharts-ng"])

myApp.config(function ($routeProvider) {
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
            "/adl_amp", {
                //controller: "olderController",
                templateUrl: "views/data_adl_older.html"
            }
    ).when(
            "/blader_amp", {
                //controller: "olderController",
                templateUrl: "views/data_blader_older.html"
            }                    
    ).when(
            "/depress_amp", {
                //controller: "olderController",
                templateUrl: "views/data_depression_older.html"
            }
    ).when(
            "/pop_older1", {
                //controller: "olderController",
                templateUrl: "views/data_pop_older.html"
            }
    ).when(
            "/pop_older_d/:id", {
                templateUrl: "views/amplist/pop_older_d.html",
                controller: function ($scope, $http, cupcode) {


                    $scope.aaaa = function () {
                        alert('OK');
                    };
                    $scope.dataloaded = false;
                    $scope.cupcode = cupcode;
                    $http.get('dataService/m_pop_older_d.php?cupcode=' + $scope.cupcode)
                            .success(function (response) {
                                $scope.older = response.records;
                                $scope.dataloaded = true;
                            })
                            .error(function () {
                                alert(ไม่สามารถประมวลผลข้อมูลได้);

                            });
                    $scope.exportData = function () {
                        var blob = new Blob([document.getElementById('exportable').innerHTML], {
                            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
                        });
                        saveAs(blob, "pop-older-amp.xls");
                    };
                },
                resolve: {
                    cupcode: function ($route) {
                        return $route.current.params.id;
                    }
                }

            }
    ).when(
            "/blader_d/:id", {
                templateUrl: "views/amplist/blader_older_d.html",
                controller: function ($scope, $http, cupcode) {


                    $scope.aaaa = function () {
                        alert('OK');
                    };
                    $scope.dataloaded = false;
                    $scope.cupcode = cupcode;
                    $http.get('dataService/m_gastric_d.php?cupcode=' + $scope.cupcode)
                            .success(function (response) {
                                $scope.data = response.records;
                                $scope.dataloaded = true;
                            })
                            .error(function () {
                                alert(ไม่สามารถประมวลผลข้อมูลได้);

                            });
                    $scope.exportData = function () {
                        var blob = new Blob([document.getElementById('exportable').innerHTML], {
                            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
                        });
                        saveAs(blob, "i-ltc-report-amp.xls");
                    };
                },
                resolve: {
                    cupcode: function ($route) {
                        return $route.current.params.id;
                    }
                }

            }
    ).when(
            "/depress_older_d/:id", {
                templateUrl: "views/amplist/depression_older_d.html",
                controller: function ($scope, $http, cupcode) {
                    $scope.exportData = function () {
                        var blob = new Blob([document.getElementById('exportable').innerHTML], {
                            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
                        });
                        saveAs(blob, "depression-older-amp.xls");
                    };

                    $scope.dataloaded = false;
                    $scope.cupcode = cupcode;
                    $http.get('dataService/m_depression_d.php?cupcode=' + $scope.cupcode)
                            .success(function (response) {
                                $scope.data = response.records;
                                $scope.dataloaded = true;
                            })
                            .error(function () {
                                alert(ไม่สามารถประมวลผลข้อมูลได้);

                            });
                },
                resolve: {
                    cupcode: function ($route) {
                        return $route.current.params.id;
                    }
                }

            }

    ).when(
            "/adl_older_d/:id", {
                templateUrl: "views/amplist/adl_older_d.html",
                controller: function ($scope, $http, cupcode) {
                    $scope.exportData = function () {
                        var blob = new Blob([document.getElementById('exportable').innerHTML], {
                            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
                        });
                        saveAs(blob, "barthel-adl-older-amp.xls");
                    };

                    $scope.dataloaded = false;
                    $scope.cupcode = cupcode;
                    $http.get('dataService/m_pop_older_d.php?cupcode=' + $scope.cupcode)
                            .success(function (response) {
                                $scope.older = response.records;
                                $scope.dataloaded = true;
                            })
                            .error(function () {
                                alert(ไม่สามารถประมวลผลข้อมูลได้);

                            });
                },
                resolve: {
                    cupcode: function ($route) {
                        return $route.current.params.id;
                    }
                }

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


myApp.controller("customerController", function ($scope) {
    $scope.controllerName = "Hello Customer";
})
myApp.controller("aboutController", function ($scope) {
    $scope.controllerName = "Hello About";
})
/*myApp.controller("homeController", function($scope) {
 $scope.controllerName = "Hello Home";
 })
 */