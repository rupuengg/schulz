var app = angular.module('schoolsetting', ['blockUI', 'ImageCropper']);
app.controller('schoolsettingController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/schoolDeatil',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.schooldata = jsondata;
            if($scope.schooldata.school_logo_path == ''){
                $scope.schooldata.school_logo_path = myURL + 'assets/img/noimage.png';
            }
        });
        $scope.SaveDetail = function (mydata) {
            if (confirm('Are you sure to make changes?')) {
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/saveschoolDeatil',
                    data: 'data=' + encodeURIComponent(angular.toJson(mydata)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    alert(jsondata.message);
                });
            }
        }
        $scope.Cancle = function (mydata)
        {
            if (confirm('Are you sure to clear ?'))
            {
            }
        }


        $scope.imageCropResult = null;
        $scope.showImageCropper = false;

        $scope.$watch('imageCropResult', function (newVal) {
            if (newVal) {
                var data = {
                    image: newVal,
                    skul_affl_no: $scope.schooldata.school_affiliation_no,
                    school_code: school
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/uploadsklimg',
                    data: "data=" + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    if (jsondata.type == 'UPLOAD') {
                        $scope.schooldata.school_logo_path = myURL + jsondata.value;
                    } else {
                        alert(jsondata.message);
                    }
                });
            }

        });

    }]);


