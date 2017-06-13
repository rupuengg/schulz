var app = angular.module('holidayApp', ['720kb.datepicker']);
app.controller('holidayAppController', function ($scope, $http) {
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getholidaytermdetail',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.mainHoliday = jsondata.holidayterm;
    });

    $scope.UpdateTermSession = function () {

        if (confirm('Are you sure want to Update holiday detail ?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/termsession',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.mainHoliday)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                $scope.mainHoliday = null;
            });
        }

    }
    $scope.SaveLargeHoliday = function () {
        if (confirm('Are you sure want to Update holiday detail ?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/declareholiday',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.mainHL)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                $scope.mainHL = null;
                window.location = self.location;

            });

        }
    }
    $scope.cancelHoliday = function () {
        if (confirm('Are you sure want to cancel ?')) {
            $scope.mainHoliday = null;

        }
    }

});


