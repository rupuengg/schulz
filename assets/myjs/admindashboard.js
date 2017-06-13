var app = angular.module('adminDetails', ['blockUI'])
        .controller('adminDasboardController', ['$scope', '$http', 'blockUI','$location', function ($scope, $http, blockUI,$location) {
              
                        $http({
                    method: 'POST',
                    url: 'admindashboarddetails',
                    data: 'data=' + schoolcode,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.data = jsondata;

                });
                $scope.edit = 'yes';
                $scope.type = 'no';
                $scope.canceledit = function () {
                    $scope.type = 'no';
                    $scope.edit = 'yes';
                }
                $scope.saveHoliday = function (todo1, eventdata) {
                    if (todo1 == undefined || todo1 == "") {
                        alert('Please Enter Reason');
                        return false;
                    } else {
                        $http({
                            method: 'POST',
                            url: 'updateholiday',
                            data: 'data=' + todo1 + '&date=' + eventdata.date + '&holiday=' + eventdata.is_holiday,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.todo = '';
                            $http({
                                method: 'POST',
                                url: 'loadTodayholiday',
                                data: '',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).success(function (jsondata) {
                                $scope.type = 'no';
                                $scope.edit = 'yes';
                                $scope.data = jsondata;
                            });

                        });

                    }

                }
                $scope.editHoliday = function (event) {
                    $scope.type = 'yes';
                    $scope.edit = 'no';
                }
                $scope.examSchedule = function (e, examId) {
                    $scope.examName = e;
                    $http({
                        method: 'POST',
                        url: 'examschedule',
                        data: 'data=' + encodeURIComponent(angular.toJson(examId)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.myExamSchedule = jsondata;
                    });
                }
            }
        ]);