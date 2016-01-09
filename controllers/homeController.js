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

                var cat = [];
                var dataa = [];
                var datao = [];
                for (var i = 0; i < $scope.chartdata.length; i++) {
                    cat.push($scope.chartdata[i]['name']);
                    dataa.push(parseInt($scope.chartdata[i]['p_all']));
                    datao.push(parseInt($scope.chartdata[i]['p_old']));
                }
                //d.push(data)

                Highcharts.setOptions({
                    lang: {
                        decimalPoint: '.',
                        thousandsSep: ','
                    }
                });
                //start charts   
                $scope.popChart = {
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
                                pointPadding: 0.1,
                                borderWidth: 0
                            }
                        },
                    },
                    title: {
                        text: 'จำนวนผู้สูงอายุในจังหวัดอุทัยธานี'
                    },
                    subtitle: {
                        text: 'จำนวนผู้สูงอายุจังหวัดอุทัยธานี (เฉพาะอาศัยอยู่จริงแยกรายอำเภอ) ที่มา:ฐานข้อมูล Datacenter สสจ.อุทัยธานี'
                    },
                    series: [{
                            name: 'ประชากรทั้งหมด',
                            //colorByPoint: true,
                            color: '#2ECCFA',
                            data: dataa,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                //align: 'left',
                                format: '{point.y:,.0f}', // one decimal
                                y: 22, // 10 pixels down from the top
                                style: {
                                    fontSize: '10px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }, {
                            name: 'จำนวนผู้สูงอายุ',
                            //colorByPoint: true,
                            color: '#FA58F4',
                            data: datao,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                // align: 'left',
                                format: '{point.y:,.0f}', // one decimal
                                y: 5, // 10 pixels down from the top
                                style: {
                                    fontSize: '10px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }],
                    loading: false

                }
                //end charts    



            })
            .error(function () {
                alert(ไม่สามารถประมวลผลข้อมูลได้);
            });


    $http.get('dataService/m_pop_charts.php')
            .success(function (response) {
                $scope.chartdata = response;

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
                //d.push(data)
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
                                    '<td style="padding:0"><b>{point.percentage:,.2f} %</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                stacking: 'percent',
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
                        }, {
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
                $scope.dataloaded = true;

                var cat = [];
                var data1 = [];
                var data2 = [];
                var data3 = [];
                for (var i = 0; i < $scope.older.length; i++) {
                    cat.push($scope.older[i]['name']);
                    data1.push(parseInt($scope.older[i]['t1']));
                    data2.push(parseInt($scope.older[i]['t2']));
                    data3.push(parseInt($scope.older[i]['t3']));
                }
                //d.push(data)

                //start charts   
                $scope.olderADLChart = {
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
                        text: 'จำนวนผู้สูงอายุแบ่งตามประเภทเตียงในจังหวัดอุทัยธานี'
                    },
                    subtitle: {
                        text: 'จำนวนผู้สูงอายุแบ่งตามประเภทเตียงในจังหวัดอุทัยธานี จำแนกตามอำเภอ ที่มา:ฐานข้อมูล Datacenter สสจ.อุทัยธานี'
                    },
                    series: [{
                            name: 'เตียง 1',
                            //colorByPoint: true,
                            color: '#00af00',
                            data: data1
                        }, {
                            name: 'เตียง 2',
                            //colorByPoint: true,
                            color: '#ffcc00',
                            data: data2
                        }, {
                            name: 'เตียง 3',
                            //colorByPoint: true,
                            color: '#d20000',
                            data: data3
                        }],
                    loading: false

                }
                //end charts                   




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




TREND_LIST = [
    {drilldown: "Normal",
        name: "ปกติ",
        visible: true,
        y: 12},
    {drilldown: "Trend2",
        name: "Trend2",
        visible: true,
        y: 13},
    {drilldown: "Trend3",
        name: "Trend3",
        visible: true,
        y: 25},
    {drilldown: "Trend4",
        name: "Trend4",
        visible: true,
        y: 50}
]

NUMBER_OF_OFFERS_BY_TREND = [
    {id: "Normal",
        name: "ปกติ",
        data: [["อำเภอ ก", 50], ["อำเภอ ข", 30], ["อำเภอ ค", 20]]
    },
    {id: "Trend2", name: "Trend2",
        data: [["Offer3", 20], ["Offer4", 10], ["Offer5", 40], ["Offer6", 30]]
    },
    {id: "Trend3", name: "Trend3",
        data: [["Offer7", 70], ["Offer8", 30]]},
    {id: "Trend4", name: "Trend4",
        data: [["Offer9", 15], ["Offer10", 35], ["Offer11", 20], ["Offer12", 30]]}
]




myApp.controller("MyController", function ($scope) {
    var chartConfig = {
        title: {
            text: 'Number of offers by trend'
        },
        subtitle: {
            text: 'My company'
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        options: {
            chart: {
                type: 'column'
            },
            drilldown: {
                series: NUMBER_OF_OFFERS_BY_TREND
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }

            },
            legend: {
                align: 'right',
                x: -70,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            }
            ,
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        style: {
                            textShadow: '0 0 0px black, 0 0 0px black'
                        }
                    }
                }
            }
        },
        series: [{
                name: 'Trends',
                colorByPoint: true,
                data: TREND_LIST
            }]
    };
    $scope.chartConfig = chartConfig;
})

