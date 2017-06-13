var app = angular.module('events', ['blockUI']);
app.controller('eventsController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.type = 'TRUE';
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/eventdetail',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.eventData = jsondata;
            $scope.eventDetails = data;
        });
    }]);




