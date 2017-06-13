var app = angular.module('staffDetails', [])
        .controller('staffDetailsController', function($scope, $http) {
            $http({
                method: 'POST',
                url: 'dashboarddatails',
                data: 'data=' + staff_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(jsondata) {
                $scope.data = jsondata;
            });
            $scope.addTodo = function(todo1) {
                var data = '{"staffid": "' + staff_id + '", "todoname": "' + todo1.task_name + '"}';
                $http({
                    method: 'POST',
                    url: 'saveTodo',
                    data: 'data=' + data,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function(jsondata) {
                    $scope.data.todo.push(jsondata);
                    alert(jsondata.message);
                    $scope.todo = '';
                    $http({
                        method: 'POST',
                        url: 'dashboarddatails',
                        data: 'data=' + staff_id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(jsondata) {
                        $scope.data = jsondata;
                    });
                });
            }
            $scope.deletetodo = function(event) {
                if (confirm('Are you sure want to delete ?')) {
                    $http({
                        method: 'POST',
                        url: 'deleteTodo',
                        data: 'data=' + event.target.id,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(jsondata) {
                        $scope.data.todo.push(jsondata);
                        alert(jsondata.message);
                        $http({
                            method: 'POST',
                            url: 'dashboarddatails',
                            data: 'data=' + staff_id,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function(jsondata) {
                            $scope.data = jsondata;
                        });
                    });
                }
            }
            $scope.issueBluecard = function(todo1, selectstudent, event) {
                if (selectstudent.trim() == 'NA') {
                    alert('Please Select Student From Studentlist!');
                    return false;
                } else {
                    var data = '{"adm_no": "' + selectstudent + '", "todoname": "' + todo1 + '","card_type":"' + event.target.id + '", "entryby":"' + staff_id + '"}';
                    $http({
                        method: 'POST',
                        url: 'issuecardDetails',
                        data: 'data=' + data,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function(jsondata) {
                        alert(jsondata.message);
                        window.location = base_url + 'index.php/staff/staffdashboard';
                    });
                }
            }
            $scope.examSchedule = function (e,examId) {
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

        });
        