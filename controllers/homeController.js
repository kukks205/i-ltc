Date.prototype.yyyymmdd = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]); // padding
};

d = new Date();
var filsename = d.yyyymmdd();




myApp.controller("homeController", function ($scope, $http) {

    $scope.dataloaded = false;

    $scope.controllerName = "ข้อมูลประชากรผู้สูงอายุ";
    $http.get('dataService/m_home.php')
            .success(function (response) {
                $scope.older = response.records;
                //กำหนดตัวแปรที่จะแสดงสถานะการ load ว่าเสร็จแล้ว
                $scope.dataloaded = true;

            })
            .error(function () {
                alert(ไม่สามารถประมวลผลข้อมูลได้);
            });
})


myApp.controller("olderController", function ($scope, $http) {
    $scope.dataloaded = false;
    //$scope.controllerName = "Hello Home";
    $http.get('dataService/m_report1.php')
            .success(function (response) {
                    $scope.older = response.records;
                    $scope.dataloaded = true;
            })
            .error(function () {
               alert(ไม่สามารถประมวลผลข้อมูลได้);

            });

})

myApp.controller("depressionController", function ($scope, $http) {
    $scope.dataloaded = false;
    $http.get('dataService/m_depression.php')
            .success(function (response) {
                    $scope.data = response.records;
                    $scope.dataloaded = true;
            })
            .error(function () {
               alert(ไม่สามารถประมวลผลข้อมูลได้);

            });

})

/*myApp.controller("olderDController", function ($stateParams,$scope,$http) {
    $scope.dataloaded = false;
    $scope.cupcode=$stateParams.cupcode;
    $http.get('dataService/m_pop_older_d.php?cupcode='+$scope.cupcode)
            .success(function (response) {
                    $scope.older = response.records;
                    $scope.dataloaded = true;
            })
            .error(function () {
               alert(ไม่สามารถประมวลผลข้อมูลได้);

            });

})*/

/*myApp.controller('olderDController', ['$scope','$stateParams','$http', function($stateParams,$scope,$http) {
    $scope.dataloaded = false;
    $scope.cupcode=$stateParams.cupcode;
    $http.get('dataService/m_pop_older_d.php?cupcode='+$scope.cupcode)
            .success(function (response) {
                    $scope.older = response.records;
                    $scope.dataloaded = true;
            })
            .error(function () {
               alert(ไม่สามารถประมวลผลข้อมูลได้);

            });
}])*/

