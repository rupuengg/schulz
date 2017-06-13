var app = angular.module('StudsummaryApp', ['blockUI']);
app.controller('StudsummaryController', function ($scope, $http, blockUI) {
    var lastid = 0;
    $scope.loadStudent = function () {
        var data = {sectionId: sec_id, lastId: lastid};
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getstudentdetail',
            data: 'data=' + encodeURIComponent(angular.toJson(data)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            if (jsondata.length > 0) {
                if ($scope.mystudents) {
                    angular.forEach(jsondata, function (value, key) {
                        $scope.mystudents.push(value);
                    });
                } else {
                    $scope.mystudents = jsondata;
                }
                lastid = jsondata[jsondata.length - 1].adm_no;
                $scope.showLoad = true;
            } else {
                $scope.showLoad = false;
            }

        });
    }
    if (sec_id != "FALSE") {
        $scope.loadStudent();
    }

});
