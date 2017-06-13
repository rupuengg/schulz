var app = angular.module('studentCentricReport', ['blockUI']);
app.controller('studentCentricReportController', function($scope, $http) {
    $scope.senddata = function()
    {
        var data = {
            admno: $scope.admno
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getstudentdetail',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {

            $scope.mydata = jsondata;

        });
    }



});