Date.prototype.yyyymmdd = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]); // padding
};

d = new Date();
var filsename = d.yyyymmdd();


function Excelexport() {
    alert('OK');
    $('#table2excel').tableExport({type: 'excel', escape: 'false'});
}



myApp.controller("homeController", function ($scope, $http) {

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "i-ltc-Report.xls");
    };

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

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "barthel-adl-older.xls");
    };

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

myApp.controller("depressionController", function ($scope, $http) {

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "depression-older.xls");
    };

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

