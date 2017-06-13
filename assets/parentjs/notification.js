
var app = angular.module('notification', ['blockUI']);
app.controller('notificationcontroller', ['$scope', '$http', 'blockUI', function($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/notificationdata',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {
            $scope.notificationdata = jsondata.notification;
             $scope.stats = jsondata.stats;
             $scope.cardStats=jsondata.cardStats;
           
        });

    }]);

