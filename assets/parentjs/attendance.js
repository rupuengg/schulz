var app = angular.module('parent_attendance_app', ['blockUI']);
app.controller('attendance_angularjs_controller', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.term = '';
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/getabsentattendance',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.absentData = jsondata;

            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/getattendancesummary',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.summaryData = jsondata;
            });
        });

    }
]);
