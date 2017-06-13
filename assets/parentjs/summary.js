var app = angular.module('summary', ['blockUI']);
app.controller('summaryController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getallsummarydata',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.summaryData = jsondata;
        });

        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/cardcount',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.cardData = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/studentmark',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.marksData = jsondata;
        });
    }]);

