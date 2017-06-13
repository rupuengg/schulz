var app = angular.module('tardy', ['blockUI']);
app.controller('tardyController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/lateattendance',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.lateData = jsondata;
            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/gettardysummary',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.summaryData = jsondata;
            });
        });
    }]);
