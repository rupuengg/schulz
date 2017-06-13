var app = angular.module('gradesummary', ['blockUI']);
app.controller('gradeSummaryController', ['$scope', '$http', 'blockUI', function ($scope, $http, blockUI) {
     
        $scope.term = '';
        $scope.sectionId = 0;
        $http({
            method: 'POST',
            url: myURL + 'index.php/staff/getallccesectionlist',
            data: '',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (jsondata) {
            $scope.mySectionList = jsondata.section;
        });
        $scope.getStudentList = function () {
            if ($scope.term == '') {
                alert("Please select term first then try again..");
            }
            else {
                var data = {
                    term: $scope.term,
                    section_id: $scope.sectionId
                }
                $http({
                    method: 'POST',
                    url: myURL + 'index.php/staff/studentgradelist',
                    data: 'data=' + encodeURIComponent(angular.toJson(data)),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).success(function (jsondata) {
                    $scope.mycceStudentList = jsondata.cceStudentList;
                    $scope.classTeacher = jsondata.classTeacher;
                    $scope.classTeacherId = jsondata.classteacherid;
                });
            }
        }
        $scope.firstterm=function(){
            $scope.term = '1';
            $scope.sectionId=0; 
        }
        $scope.secondterm=function(){
            $scope.term = '2';
            $scope.sectionId=0; 
        }
    }
]);
