var app = angular.module('AttSum', ['blockUI','720kb.datepicker']);
app.controller('AttSumController', ['$scope', '$http','blockUI',function ($scope, $http,blockUI) {
    $scope.attendenceDate = myDate;
    $scope.myError = null;
    $scope.myStudentList = null;
    $scope.base_url = myURL;
    $scope.type = null;
    $scope.myAllStudentList = null;
    getAttendanceSummary($scope, $http);
    
    $scope.change = function () {
      
        getAttendanceSummary($scope, $http);
    }
    function getAttendanceSummary($scope, $http) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getattsummary',
            data: 'date=' + $scope.attendenceDate,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
         
        if (jsondata.result == "TRUE") {
                $scope.myAttSum = angular.fromJson(jsondata.value);
                $scope.marked = 0;
                $scope.unmarked = 0;
                $scope.status = 0;
                angular.forEach($scope.myAttSum, function (data) {
                    
                    if (data.status == 'MARKED') {
                        $scope.marked++;
                        $scope.status++;
                    } else {
                        $scope.unmarked++;
                        $scope.status++;
                    }
                });
             
                $scope.myError = null;
            } else {
                $scope.myAttSum = null;
                $scope.myError = jsondata.message;
            }
        });
    }
   




}]);
