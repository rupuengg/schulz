var app = angular.module('lateattendance', [ '720kb.datepicker','ngTouch', 'angucomplete-alt']);
app.controller('lateattendanceController', ['$scope', '$http', function ($scope, $http) {
        $scope.maxDate= new Date();
    $scope.lateDate = myDate;
    $scope.tempArrLate = [];
    $scope.addtable = function (temp,adm_no,studentName)
    {
        var data = {
            name: studentName,
            adm_no: adm_no,
            coming_date: $scope.lateDate,
            coming_time: temp.time,
            reason: temp.reason
        }

        $scope.tempArrLate.push(data);
    }

    $scope.removeRow = function (index) {
        $scope.tempArrLate.splice(index, 1);
    }
    $scope.savealldata = function ()
    {   
        var attndanceData = {
            alldata: $scope.tempArrLate
        }
        if (confirm('Are you sure to save attendance?'))
        {
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/saveallattendancedata',
                data: 'data=' + encodeURIComponent(angular.toJson(attndanceData)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
            });
        }
        else {
            return false;
        }
    }
}]);