Date.prototype.yyyymmdd = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]); // padding
};

d = new Date();
var filsename = d.yyyymmdd();



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

    $http.get('dataService/m_pop_charts.php')
            .success(function (response) {
                $scope.chartdata = response;

                var title = $scope.chartdata[0]['name'];
                var cat = [];
                for (var i = 0; i < $scope.chartdata.length; i++) {
                    cat.push($scope.chartdata[i]['name']);
                }

                var data = [];
                for (var i = 0; i < $scope.chartdata.length; i++) {
                    data.push(parseInt($scope.chartdata[i]['y']));
                }
                //d.push(data)

                Highcharts.setOptions({
                    lang: {
                        decimalPoint: '.',
                        thousandsSep: ','
                    }
                });
                //start charts   
                $scope.highchartsNG = {
                    options: {
                        chart: {
                            type: 'column'
                        },
                        xAxis: {
                            categories: cat,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'จำนวน (คน)'
                            }

                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:14px">อำเภอ{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:,.0f} คน</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                    },
                    title: {
                        text: 'จำนวนผู้สูงอายุในจังหวัดอุทัยธานี'
                    },
                            subtitle: {
                     text: 'จำนวนผู้สูงอายุจังหวัดอุทัยธานี (เฉพาะอาศัยอยู่จริงแยกรายอำเภอ) ที่มา:ฐานข้อมูล Datacenter สสจ.อุทัยธานี'
                     },
                     
                    series: [{
                            name: 'จำนวนผู้สูงอายุ',
                            colorByPoint: true,
                            data: data
                        }],
                    loading: false

                }
                //end charts    



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

myApp.controller("gastricController", function ($scope, $http) {

    $scope.exportData = function () {
        var blob = new Blob([document.getElementById('exportable').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        saveAs(blob, "i-ltc-report-gastric.xls");
    };

    $scope.dataloaded = false;
    $http.get('dataService/m_gastric.php')
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

