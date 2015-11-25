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
        //$scope.controllerName = "Hello Home";
        //$scope.url = 'dataService/json/report1.json';

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

    })
