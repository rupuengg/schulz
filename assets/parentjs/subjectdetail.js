var app = angular.module('subjectdetail', ['blockUI']);
app.controller('subjectdetail_controller', function ($scope, $http, blockUI) {

    $scope.subjectData = data;
    $scope.dedata = $scope.subjectData.examdetail;
    $scope.upexdata = $scope.subjectData.upcomingexam;
    $scope.homework = $scope.subjectData.homework;
    $scope.subjectname = $scope.subjectData.subjectname;
    $scope.loadMarkStructure = function (obj)
    {
        var examid = {
            id: obj
        }
        $http({
            method: 'POST',
            url: myURL + 'index.php/parent/markstructure',
            data: 'data=' + encodeURIComponent(angular.toJson(examid)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.markstructuredata = jsondata;
            $scope.examshortname = obj;

        });
    }

});