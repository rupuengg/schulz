var app = angular.module('Att', ['blockUI', '720kb.datepicker']);
app.controller('AttController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.attendenceDate = myDate;
        $scope.myError = null;
        $scope.type = null;
        $scope.autoload = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getstaffattlist',
                data: 'date=' + encodeURIComponent($scope.attendenceDate),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.myAttendence = angular.fromJson(jsondata.value);
                $scope.present = 0;
                $scope.absent = 0;
                $scope.total = 0;
                angular.forEach($scope.myAttendence.staff_list, function (data) {
                    if (data.att_status == 'ABSENT') {
                        $scope.absent++;
                        $scope.total++;
                    } else {
                        $scope.present++;
                        $scope.total++;
                    }
                });
            });
        };
        $scope.autoload();
        $scope.change = function () {
            $scope.autoload();
        }
        $scope.switchv = function (staff_id, index, currstatus, date) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var today1 = dd + '-' + mm + '-' + yyyy;
            var newdate = today1.toString();
            if (newdate != date) {
                alert("You can not mark past date's Attendance!!!");
            } else {
                if (currstatus == 'ABSENT') {
                    if (confirm('Do you really want to mark absent??') == true) {
                        var data = {
                            staff_id: staff_id,
                            date: $scope.attendenceDate,
                            status: 'ABSENT',
                            reason: $scope.myAttendence.staff_list[index].reason
                        };
                        $http({
                            method: 'POST',
                            url: myURL + 'index.php/staff/saveattdata',
                            data: 'data=' + encodeURIComponent(angular.toJson(data)),
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.myAttendence.staff_list[index].att_status = 'ABSENT';
                            $scope.myAttendence.status.status = 'Marked';
                            $scope.autoload();
                        });
                    } else {
                        $scope.myAttendence.staff_list[index].att_status = 'PRESENT';
                    }
                } else {
                    var data1 = {
                        staff_id: staff_id,
                        status: 'PRESENT',
                        date: $scope.attendenceDate
                    };
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/staff/saveattdata',
                        data: 'data=' + encodeURIComponent(angular.toJson(data1)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        $scope.myAttendence.staff_list[index].att_status = 'PRESENT';
                        $scope.myAttendence.status.status = 'Marked';
                        $scope.autoload();
                    });
                }
            }

        }
        $scope.markAttendence = function () {
            if (confirm('Do you want to save the attendance as all present on date ' + $scope.attendenceDate)) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/markallstaff',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.myAttendence)) + '&date=' + $scope.attendenceDate,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        };
    }]);
