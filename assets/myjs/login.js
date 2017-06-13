var app = angular.module('login', ['blockUI']);
app.controller('loginController', ['$scope', '$http', 'blockUI','$interval', function ($scope, $http, blockUI,$interval) {
        $scope.loginMe = function () {
            if ($scope.myForm.$valid) {
                var myData = {
                    username: $scope.username,
                    password: $scope.password
                }
                $scope.isAjax = false;
                $http({
                    method: "POST",
                    url: myUrl + 'index.php/login/checklogindetail',
                    data: 'data=' + JSON.stringify(myData),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).
                        success(function (data) {
                            switch (data.type) {
                                case 'TRUE':
                                    window.location = self.location;
                                    break;
                                case 'FIRSTTIMELOGIN':
                                    alert(data.message);
                                    window.location = myUrl + 'index.php/login/changeidpassword';
                                    break;
                                case 'DEACTIVATED':
                                    alert(data.message);
                                    window.location = myUrl + 'index.php/login/accountdeactivate';
                                    break;
                                case 'RESET':

                                    window.location = myUrl + 'index.php/login/resetpassword';
                                    break;
                                case 'COMPANY':
//                                    alert(data.message);
                                    window.location = myUrl;
                                    break;
                                case 'DBNOTFOUND':
                                    alert(data.message);
                                    break;
                                case 'FALSE':
                                    alert(data.message);
                                    break;
                            }

                        }).
                        error(function (data) {

                            $scope.isAjax = true;

                        });
            } else {
                toastr.options.positionClass = "toast-bottom-full-width";
                toastr.error('Please enter the valid username and password  then try to login.', '');
            }
        }

        $scope.resetPassword = function () {
            if ($scope.myForm.$valid) {
                var myDataResetPassword = {
                    oldpassword: $scope.oldpassword,
                    newpassword: $scope.newpassword,
                    reenternewpassword: $scope.reenternewpassword
                }
                if (myDataResetPassword.newpassword == myDataResetPassword.reenternewpassword) {
                    $http({
                        method: 'POST',
                        url: myUrl + 'index.php/login/checkresetpassword',
                        data: 'data=' + encodeURIComponent(angular.toJson(myDataResetPassword)),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (data) {
                        switch (data.type) {
                            case 'TRUE':
                                alert(data.message);
                                window.location = myUrl;
                                break;
                            case 'WRONG':
                                alert(data.message);
                                window.location.href = myUrl + 'index.php/login/resetpassword';
                                break;
                            case 'FALSE':
                                alert(data.message);
                                $scope.oldpassword = null;
                                break;
                        }

                    });
                } else {
                    toastr.options.positionClass = "toast-bottom-full-width";
                    toastr.error('New password and re-entered password does not match', '');
                    $scope.newpassword = null;
                    $scope.reenternewpassword = null;
                }

            } else {
                toastr.options.positionClass = "toast-bottom-full-width";
                toastr.error('Please enter the valid password then try to reset.', '');
            }
        }
        $scope.resetfirstPassword = function () {

            var method = 'POST';
            var url = myUrl + 'index.php/login/changeuserpassword';

            $http({method: method, url: url, data: 'data=' + encodeURIComponent(angular.toJson($scope.main)), headers: {'Content-Type': 'application/x-www-form-urlencoded'}})
                    .success(function (data) {
                        switch (data.type) {
                            case 'TRUE':
                                alert(data.message);
                                window.location = myUrl + 'index.php';
                                break;
                            default:
                                alert(data.message);
                                break;
                            }
                    });
        }


        $scope.getolduser = function (medValue, index) {
            if ($scope.main.newuser) {
                if ($scope.main.newuser == medValue) {
                    $scope.user = 'yes';
                }
            }
        }
        $scope.getnewuser = function (medValue, index) {
            if ($scope.main.currentuser) {
                if ($scope.main.currentuser == medValue) {
                    $scope.user = 'yes';
                } else {
                    $scope.user = 'ok';
                }
            } else {
                $scope.user = 'no';
            }
        }
        $scope.getcurrentpassword = function (medValue, index) {
            if ($scope.main.newpass) {
                if ($scope.main.newpass == medValue) {
                    $scope.oldpass = 'yes';
                    $scope.type = 'no';
                } else {
                    $scope.oldpass = '';
                    $scope.type = '';
                }
            }
        }
        $scope.getNewpass = function (medValue, index) {
            if ($scope.main.repasword) {
                if ($scope.main.repasword == medValue) {
                    $scope.types = 'yes';
                } else {
                    $scope.types = 'no';
                }
            } else {
                $scope.type = 'no';
            }
            if ($scope.main.currentpassword) {
                if ($scope.main.currentpassword == medValue) {
                    $scope.oldpass = 'yes';
                    $scope.type = 'no';
                } else {
                    $scope.oldpass = '';
                    $scope.type = '';
                }
            } else {
                $scope.oldpass = 'no';
                $scope.type = '';
            }

        }
        $scope.getrepass = function (medValue, index) {
            if ($scope.main.newpass) {
                if ($scope.main.newpass == medValue) {
                    $scope.types = 'yes';
                } else {
                    $scope.types = 'no';
                }
            } else {
                $scope.types = 'ok';
            }

        }
        

    }
]);
app.directive('ng-enter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});