var app = angular.module('staffProfileDetails', ['blockUI'])
        .controller('staffProfileDetailsController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

                $http({
                    method: 'POST',
                    url: base_url + 'index.php/staff/profiledetails',
                    data: 'data=' + staff_id,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.data = jsondata;
                    $scope.profileData=jsondata.profile;

                });

            }
        ]);
var app = angular.module('staffDetails', ['blockUI', 'ngTouch', 'angucomplete-alt'])
        .controller('staffDetailsController', ['$scope', '$interval', '$http', 'blockUI', function ($scope, $interval, $http, blockUI) {
                $scope.type = '';
                $scope.bgColor = '';
                autoCallService();
                function   autoCallService() {
                    $http({
                        method: 'POST',
                        url: 'dashboarddatails',
                        data: 'data=' + staff_id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.data = jsondata;
                        $scope.cardCount = jsondata.card;
                    });

                    $http({
                        method: 'POST',
                        url: base_url + 'index.php/staff/getalltodolist',
                        data: 'data=' + encodeURIComponent(angular.toJson($scope.todotask)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.TodoList = jsondata;
                    });
                }
                $scope.addTodo = function () {
                    var data = '{"staffid": "' + staff_id + '", "todoname": "' + $scope.todotask.task_name + '"}';
                    $http({
                        method: 'POST',
                        url: base_url + 'index.php/staff/saveTodo',
                        data: 'data=' + data,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata.message);
                        $scope.todotask.task_name = '';
                        autoCallService();
                    });
                }

                $scope.todocomplete = function (index) {
                    if ($("#mycheck" + index).prop('checked')) {
                        if (confirm('Have you completed the task ?')) {
                            $http({
                                method: 'POST',
                                url: base_url + 'index.php/staff/todocomplete',
                                data: 'data=' + $scope.TodoList[index].id,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).success(function (jsondata) {
                                alert(jsondata.message);
                                $scope.TodoList.splice(index, 1)
                            });
                        }
                    }

                }

                $scope.deletetodo = function (index) {
                    if (confirm('Are you sure want to delete ?')) {
                        $http({
                            method: 'POST',
                            url: base_url + 'index.php/staff/deleteTodo',
                            data: 'data=' + $scope.TodoList[index].id,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.TodoList.splice(index, 1);
                        });
                    }
                }

                $scope.deleteCards = function (event) {
                    if (confirm('Are you sure want to delete ?')) {
                        $http({
                            method: 'POST',
                            url: 'deleteCards',
                            data: 'data=' + event.target.id,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.todo = '';
                            autoCallService();
                        });
                    }
                }



                $scope.issueBluecard = function (todo1, selectstudent, event) {
                    if (selectstudent.trim() == 'NA') {
                        alert('Please Select Student From Studentlist!');
                        return false;
                    } else if (confirm('Do you want to save this?'))
                    {
                        var data = '{"adm_no": "' + selectstudent + '", "todoname": "' + todo1 + '","card_type":"' + event.target.id + '", "entryby":"' + staff_id + '"}';
                        $http({
                            method: 'POST',
                            url: 'issuecardDetails',
                            data: 'data=' + data,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            autoCallService();
                        });
                    }
                    else {
                        return false;
                    }
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
                $scope.hideType = 'FALSE';
                $scope.uploadDikhao = function () {
                    if ($scope.hideType == 'FALSE') {
                        $scope.hideType = 'TRUE';
                    } else {
                        $scope.hideType = 'FALSE';
                    }
                }
            }]);