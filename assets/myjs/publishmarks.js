var app = angular.module('publishmarks', ['blockUI', 'ui.bootstrap','720kb.datepicker']);
app.controller('publishMarksController', function ($scope, $http, blockUI) {
    $scope.term = '';
    $scope.myClassId = 0;
    $scope.lockClassId = 0;
    $scope.myPublishList = publishList;
    $scope.myLockList = lockList;
    
    $http({
        method: 'POST',
        url: myURL + 'index.php/staff/getmyclass',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myclassList = jsondata.classList;
    });
    $scope.publishMarksDetail = function ($tabname) {
        
         window.location = myURL + 'index.php/staff/publishmarks/' + $tabname + '/' + $scope.myClassId;
     }
    
    $scope.savePublishMarks = function (myData) {
        console.log(myData);
        return false;
        if (confirm('Are you sure,you want to save this?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savepublishmarks',
                data: 'data=' + encodeURIComponent(angular.toJson(myData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                window.location = self.location;
                
            });
        } else {
            return false;
        }
    }

    $scope.lockMarksDetail = function ($name) {
        window.location = myURL + 'index.php/staff/publishmarks/'+ $name  + '/' + $scope.lockClassId;
     }

    $scope.saveLockMarks = function (myData) {
        if (confirm('Are you sure,you want to save this?')) {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/savelockmarks',
                data: 'data=' + encodeURIComponent(angular.toJson(myData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
                window.location = self.location;
                
            });
        }
    }
    $scope.hstep = 1;
    $scope.mstep = 15;
    $scope.showMeridian = false;
});