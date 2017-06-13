var app = angular.module('clubmgnt', ['blockUI']);
app.controller('clubmgntController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.meetingId = null;
        $scope.GetAttDetail = function (meetingId, clubid) {
            var data = {
                club_id: clubid,
                meetingId: meetingId
            }
            $scope.meetingId = meetingId;
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getmemberdetail',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.getmemberData = jsondata;
            });

        }
        $scope.saveAttDetails = function () {
            var data = {
                details: $scope.getmemberData,
                meetingId: $scope.meetingId
            }
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/saveattdetail',
                data: 'data=' + encodeURIComponent(angular.toJson(data)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                alert(jsondata.message);
            });
        }
    }
]);
