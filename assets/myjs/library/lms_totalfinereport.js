var app = angular.module('totalfeereport', ['blockUI', '720kb.datepicker']);
app.controller('totalfeereportcontroller', function($scope, $http) {
    $scope.from = myDate;
    $scope.to = myDate;
    $scope.viewdata = function(){
        var data = {
            from: $scope.from,
            to: $scope.to
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getfinedetail',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {
            $scope.data = jsondata;

        });
    }

});