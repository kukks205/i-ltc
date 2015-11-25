myApp.controller("amplistController", function ($scope, $http) {
    $scope.dataloaded = false;
    $http.get('dataService/m_amp_list.php')
            .success(function (response) {
                $scope.amp = response.records;
                //กำหนดตัวแปรที่จะแสดงสถานะการ load ว่าเสร็จแล้ว
                $scope.dataloaded = true;
            })
            .error(function () {
                $http.get('dataService/m_amp_list.php')
                        .success(function (response) {
                            alert('ไม่สามารถแสดงข้อมูลได้');
                        });
            });

})

