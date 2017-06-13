var app = angular.module('grade', ['blockUI']);
app.controller('gradeController', ['$scope', '$http','blockUI',function ($scope, $http,blockUI) {
    $scope.studentAll=0;
        $scope.term = '';
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getallccenamelist',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myCceNameList = jsondata.ccegradename;
    });
    $scope.getStudentList = function () {
        if ($scope.term == '') {
            alert("Please select term first then try again..");
        }
        else {
            var data = {
                detail: $scope.studentAll,
                term: $scope.term
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getmystudent',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.myStudentList = jsondata.nameList;
                $scope.myGradeList = jsondata.gradeList;
                $scope.classTeacher=jsondata.classTeacher;
                
            });
        }
    }
    $scope.saveGradeDiDetails = function (myData) {
        myData.term = $scope.term;
        myData.cce_id=$scope.studentAll;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/savegradedetail',
            data: 'data=' + encodeURIComponent(angular.toJson(myData)),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            alert(jsondata.message);
            //window.location = self.location;
        });
    }
}
]);