var app = angular.module('card', ['blockUI']);
app.controller('cardController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/carddetail',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.cardData = jsondata;

            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/cardcountdeatils',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.cardCountData = jsondata;

            });
        });
    }]);


