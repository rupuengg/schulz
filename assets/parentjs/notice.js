var app = angular.module('notice', ['blockUI']);
app.controller('noticeController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
       
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/noticedetail',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.noticeData = jsondata;
            $scope.noticeDetail = data;
        });
    }]);




