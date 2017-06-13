var app = angular.module('homework', ['blockUI']);
app.controller('homeworkController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {

        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/gethomework',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.homeworkData = jsondata;
        });
        $scope.FullDeatil = Fulldata;
    }]);




