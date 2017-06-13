var app = angular.module('ComboDetails', ['blockUI'])
        .controller('ComboDetailsController', function ($scope, $http, blockUI) {
            blockUI.start();
            $http({
                method: 'POST',
                url: 'combodetails',
                data: '',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                $scope.data = jsondata;

            });

            $scope.getScoreData = function () {
                $scope.type = 'yes';
                $http({
                    method: 'POST',
                    url: 'sectiondetails',
                    data: 'data=' + $scope.score,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.studentlist = jsondata;
                });
            }
            blockUI.stop();
            $scope.deleteCombo = function (studentlistOb) {
                if (confirm('Are you sure want to delete ?')) {
                    $http({
                        method: 'POST',
                        url: 'deleteCombo',
                        data: 'data=' + studentlistOb.adm_no,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    }).success(function (jsondata) {
                        alert(jsondata);
                        $http({
                            method: 'POST',
                            url: 'sectiondetails',
                            data: 'data=' + $scope.score,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            $scope.studentlist = jsondata;
                        });
                    });
                }
            }
            $scope.assignCombo = function (selectcombo) {
                if (selectcombo == 'NA') {
                    alert('Please select Combo !');
                    return false;
                } else {
                    if (confirm('Are you sure want to assign combo ?')) {
                        $http({
                            method: 'POST',
                            url: 'assigncombotostudent',
                            data: 'data=' + angular.toJson($scope.studentlist.student) + '&comboid=' + selectcombo + '&entry_by=' + login,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        }).success(function (jsondata) {
                            alert('Save Successfully');
                            $http({
                                method: 'POST',
                                url: 'sectiondetails',
                                data: 'data=' + $scope.score,
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                            }).success(function (jsondata) {
                                $scope.studentlist = jsondata;
                            });
                        });
                    } else {
                        return false;
                    }
                }
            }
        }
        );