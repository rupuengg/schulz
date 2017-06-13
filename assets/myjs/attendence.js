var app = angular.module('Att', ['blockUI', '720kb.datepicker']);
app.controller('AttController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.attendenceDate = myDate;
        $scope.section_id = null;
        $scope.myLoginType = loginType;
        $scope.myError = null;
        $scope.myStudentList = null;
        $scope.base_url = myURL;
        $scope.type = null;
        $scope.myAllStudentList = null;
        if ($scope.myLoginType == 'FACULTY' || $scope.myLoginType == 'DEO') {
            getAttendanceValue($scope, $http);
        }
        $scope.change = function () {
            //alert(id); return false;
            getAttendanceValue($scope, $http);
        }

        function getAttendanceValue($scope, $http) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getattendencelist',
                data: 'date=' + encodeURIComponent($scope.attendenceDate) + '&section_id=' + encodeURIComponent($scope.section_id),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                if (jsondata.result == "TRUE") {
                    $scope.myAttendenceData = jsondata.value;
                    $scope.myAttendence = $scope.myAttendenceData.att;
                    $scope.classTeacher = $scope.myAttendenceData.ctName;
                    $scope.present = 0;
                    $scope.absent = 0;
                    $scope.exempt = 0;
                    $scope.total = 0;
                    $scope.status = $scope.myAttendenceData.attStatus;

                    angular.forEach($scope.myAttendence, function (data) {
                        if (data.att_status == 'ABSENT') {
                            $scope.absent++;
                            $scope.total++;
                        } else if (data.att_status == 'EXEMPT') {
                            $scope.exempt++;
                            $scope.total++;
                        } else if (data.att_status == 'PRESENT') {
                            $scope.present++;
                            $scope.total++;
                        }
                    });
                    $scope.myError = null;
                } else {
                    $scope.myAttendence = null;
                    toastr.options.positionClass = "toast-bottom-full-width";
                    toastr.error(jsondata.message);
                }
            });
        }

        $scope.saveAttendence = function () {
            if (confirm('Do you want to save the attendance on date ' + $scope.attendenceDate)) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveattendence',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.myAttendence)) + '&date=' + encodeURIComponent($scope.attendenceDate) + '&section_id=' + encodeURIComponent($scope.section_id),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });

            }
        };
        $scope.markAttendence = function () {
            if (confirm('Do you want to save the attendance as all present on date ' + $scope.attendenceDate)) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/markallattendence',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.myAttendence)) + '&date=' + $scope.attendenceDate + '&section_id=' + encodeURIComponent($scope.section_id),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                    window.location = self.location;
                });
            }
        };

        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallsectionlist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySections = jsondata.section;
        });


    }]);
