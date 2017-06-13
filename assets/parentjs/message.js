var app = angular.module('message', ['blockUI']);
app.controller('messageController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        if (myMessage != undefined) {
            $scope.myMessageDetail = myMessage;
        }
         GetMyMessageUpdate();
        $scope.SendMessage = function (staffId) {
            if (staffId != -1) {
                var data = {
                    staff_id: staffId,
                    message: $scope.messageContent
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/parent/sendmessage',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $http({
                        method: 'POST',
                        url: myURL + 'index.php/parent/myupdatemessage',
                        data: 'data=' + encodeURIComponent(staffId),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        $scope.myMessageDetail = jsondata;
                    });
                    GetMyMessageUpdate();
                });
            }
            else {
                alert('Please select teacher first before starting chat..');
            }
        }
        function GetMyMessageUpdate() {
            $http({
                method: 'POST',
                url: myURL + 'index.php/parent/getmessagedetail',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.messageDeatil = jsondata;
            });
        }
    }]);

