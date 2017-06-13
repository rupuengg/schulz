var app = angular.module('bookCentricReport', ['blockUI', '720kb.datepicker']);
app.controller('bookCentricReportController', function($scope, $http) {
    $scope.senddata = function()
    {
        var data = {
            bookid: $scope.bookid
        };
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getbookissuedetail',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(jsondata) {
              $scope.data = jsondata;
        });
    }

});
