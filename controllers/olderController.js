    Date.prototype.yyyymmdd = function() {
        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
        var dd = this.getDate().toString();
        return yyyy + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]); // padding
    };

    d = new Date();
    var filsename = d.yyyymmdd();


    myApp.controller("olderController", function($scope, $http) {

        //alert(filsename);
        $scope.unlink = function(){
        	$http.get('dataService/clear_m_report1.php')
        	.success(function(){
        		alert('กำลังจะประมวลผลใหม่');
        		location.reload();

        	})
                        .error(function(){
                            alert('ประมวลผลไม่ได้');
                        });
        }

        $scope.dataloaded = false;

        $http.get('dataService/json/report1.json')
            .success(function(response) {

                if (response.records[0]['file'] === filsename) {

                    $scope.older = response.records;
                    $scope.dataloaded = true;

                } else {
                    //alert('Not Update');
                    $http.get('dataService/m_report1.php')
                        .success(function(response) {
                            $scope.older = response.records;
                            //กำหนดตัวแปรที่จะแสดงสถานะการ load ว่าเสร็จแล้ว
                            $scope.dataloaded = true;
                        });
                }


            })
            .error(function() {
                $http.get('dataService/m_report1.php')
                    .success(function(response) {
                        $scope.older = response.records;
                        //กำหนดตัวแปรที่จะแสดงสถานะการ load ว่าเสร็จแล้ว
                        $scope.dataloaded = true;
                    });
            });
            
            

    $http.get('dataService/m_pop_charts.php')
            .success(function (response) {
                $scope.chartdata = response;

                //start push json data
                var cat = [];
                var data1 = [];
                var data2 = [];
                var data3 = [];
                var data4 = [];
                for (var i = 0; i < $scope.chartdata.length; i++) {
                    cat.push($scope.chartdata[i]['name']);
                    data1.push(parseInt($scope.chartdata[i]['p1']));
                    data2.push(parseInt($scope.chartdata[i]['p2']));
                    data3.push(parseInt($scope.chartdata[i]['p3']));
                    data4.push(parseInt($scope.chartdata[i]['p4']));
                }
                //end push json data
                //start charts   
                $scope.popOlderChart = {
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
                            pointFormat: '<tr><td style="color:{series.color};padding:0"><b>{series.name}:</b> </td>' +
                                    '<td style="padding:0"><b>{point.y:,.0f} คน</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                //stacking: 'percent',
                                pointPadding: 0.05,
                                borderWidth: 0
                            }
                        },
                    },
                    title: {
                        text: 'จำนวนผู้สูงอายุแบ่งตามช่วงอายุในจังหวัดอุทัยธานี'
                    },
                    subtitle: {
                        text: 'ข้อมูลผู้สูงอายุแบ่งตามช่วงอายุในจังหวัดอุทัยธานี จำแนกตามอำเภอ ที่มา:ฐานข้อมูล Datacenter สสจ.อุทัยธานี'
                    },
                    series: [{
                            name: '60-69 ปี',
                            //colorByPoint: true,
                            //color: '#2ECCFA',
                            data: data1
                        }, {
                            name: '70-79 ปี',
                            //colorByPoint: true,
                            //color: '#FA58F4',
                            data: data2
                        }, {
                            name: '80-89 ปี',
                            //colorByPoint: true,
                            //color: '#FA58F4',
                            data: data3
                        },
                    , {
                            name: '90ปีขึ้นไป',
                            //colorByPoint: true,
                            //color: '#FA58F4',
                            data: data4
                        }],
                    loading: false

                }
                //end charts    



            })
            .error(function () {
                alert(ไม่สามารถประมวลผลข้อมูลได้);
            });        
            
            

    })
