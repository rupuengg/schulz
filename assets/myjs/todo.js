var app = angular.module('todoDetails', ['blockUI'])
        .controller('todoDetailsController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {


                $http({
                    method: 'POST',
                    url: base_url + 'index.php/staff/viewalltodolist',
                    data: 'data=' + encodeURIComponent(angular.toJson($scope.todotask)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.TodoList = jsondata;
                });

                $scope.deletetodo = function (index) {
                    if (confirm('Are you sure want to delete ?')) {
                        $http({
                            method: 'POST',
                            url: base_url + 'index.php/staff/deleteTodo',
                            data: 'data=' + $scope.TodoList[index].id,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert(jsondata.message);
                            $scope.TodoList.splice(index, 1)
//                           
                        });
                    }
                }
            }]);
