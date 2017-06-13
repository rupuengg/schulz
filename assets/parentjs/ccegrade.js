var app = angular.module('ccegrade', ['blockUI']);
app.controller('ccegradeController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.term = '';
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getccegrade',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.gradeData = jsondata;
        });

        $scope.myClick = function () {
            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/getrightccegrade',
                data: 'data=' + encodeURIComponent($scope.term),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.rightGradeData = jsondata;
            });
        };

    }]);
