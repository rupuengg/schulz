var app = angular.module('bluesheet', ['blockUI']);
app.controller('bluesheetController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
        $scope.checked=false;
        $scope.classDetails = 0;
        console.log($scope.classDetails);
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallsectionlist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySectionList = jsondata.section;
        });
        $scope.checkCount=function(){
            $scope.checked=false;
            angular.forEach($scope.examList,function(value,key){
                if(value.loadresult){
                    $scope.checked=true;
                    return false;
                }
            });
        };
        $scope.getClassDetail = function () {
            $scope.subList=null;
            $scope.checked=false;
           $scope.show = 'FALSE';
            $http({
                method: 'POST',
                url: myURL + 'index.php/staff/getblueexamlist',
                data: 'data=' + encodeURIComponent(angular.toJson($scope.classDetails)),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (jsondata) {
                console.log(jsondata);
                $scope.examList = jsondata.examList;
                $scope.classTeacher = jsondata.classTeacher.teacher;
                
            });
        }
        $scope.loadMarks = function (myData) {
            console.log(myData);
            var myDetail = null;
            myDetail = $scope.examList;
            var hint = 0;
            $.each(myDetail, function (key, value) {
                if (value.loadresult) {
                    hint++;
                }
            });
            $scope.myPostData = myDetail;
            $scope.count = hint;
            if ($scope.count == 0) {
                alert("Please select atleast one exam first then try again ..");
            }
            else {
                var data = {
                    exam: $scope.myPostData,
                    class: $scope.classDetails
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/loadexammarks',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.subList = jsondata;
                    $scope.show = 'TRUE';
                });
            }
        }
    }]);
