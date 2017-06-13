var app = angular.module('eventApp', ['blockUI']);
app.controller('eventAppController', ['$scope', '$http', 'blockUI', function ($scope, $http,blockUI) {
    $scope.base_url = myURL;
     if (team_id == -1) {
        $scope.showDivTeamMember = false;
    } else{
        $scope.showDivTeamMember = true;
    }
     $http({
        method: 'POST',
        url: myURL + 'index.php/staff/staffevent',
        data: '',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (jsondata) {
        $scope.myEvent = angular.fromJson(jsondata.eventList);
    });

    if (event_id == -1) {
        $scope.showdiv = false;
    } else {
         $scope.showdiv = true;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/loadeventdetail',
            data: 'id=' + event_id,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.myEventDetail = angular.fromJson(jsondata.eventDetail);
            $scope.myEventVolStud = angular.fromJson(jsondata.volunteerStud);
            $scope.myEventVolStaff = angular.fromJson(jsondata.volunteerStaff);
            $scope.myTeamLength = angular.fromJson(jsondata.ETeamLength);
            $scope.myTeamMemLength = angular.fromJson(jsondata.ETeamMemLength);
        
        
        });

    }

    $scope.selectEvent = function () {
               window.location.assign($scope.base_url + "index.php/staff/myevents/" + $scope.eventDetail);
    };

}]);
