var app = angular.module('homepage', ['blockUI']);
app.controller('homepageController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/upcomingnews',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.newsData = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getholidays',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.holidayData = jsondata;
        });
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getnotification',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.notificationData = jsondata;
        });

    }]);