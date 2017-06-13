var app = angular.module('examdatesheet', ['blockUI']);
app.controller('examdatesheetController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getexamdatesheet',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.datesheetData = jsondata;
            $scope.dateSheetNew = data;
        });
    }]);
